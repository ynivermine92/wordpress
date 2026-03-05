<?php

class Wayup_Rating_Widget extends WP_Widget
{

    /**
     * General Setup
     */
    public function __construct() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'wayup_rating_widget',
            'description' => 'Виджет который выводит блок с Рейтингом'
        );
        /* Widget control settings. */
        $control_ops = array(
            'width'		=> 500,
            'height'	=> 450,
            'id_base'	=> 'wayup_rating_widget'
        );
        /* Create the widget. */
        parent::__construct( 'wayup_rating_widget', 'Wayup | Рейтинг', $widget_ops, $control_ops );
    }

    protected function get_filtered_product_count( $rating ) {
        global $wpdb;

        $tax_query  = WC_Query::get_main_tax_query();
        $meta_query = WC_Query::get_main_meta_query();

        // Unset current rating filter.
        foreach ( $tax_query as $key => $query ) {
            if ( ! empty( $query['rating_filter'] ) ) {
                unset( $tax_query[ $key ] );
                break;
            }
        }

        // Set new rating filter.
        $product_visibility_terms = wc_get_product_visibility_term_ids();
        $tax_query[]              = array(
            'taxonomy'      => 'product_visibility',
            'field'         => 'term_taxonomy_id',
            'terms'         => $product_visibility_terms[ 'rated-' . $rating ],
            'operator'      => 'IN',
            'rating_filter' => true,
        );

        $meta_query     = new WP_Meta_Query( $meta_query );
        $tax_query      = new WP_Tax_Query( $tax_query );
        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

        $sql  = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) FROM {$wpdb->posts} ";
        $sql .= $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = WC_Query::get_main_search_query_sql();
        if ( $search ) {
            $sql .= ' AND ' . $search;
        }

        return absint( $wpdb->get_var( $sql ) ); // WPCS: unprepared SQL ok.
    }

    /**
     * Display Widget
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        extract( $args );

        $title = $instance['title'];
        ob_start();

        $found = false;

        echo '<div class="rating"><h5 class="rating__title">'.$title.'</h5>';

        for ( $rating = 5; $rating >= 1; $rating-- ) {
            $count = $this->get_filtered_product_count( $rating );
            if ( empty( $count ) ) {
                continue;
            }
            $found = true;

            $count_html  = esc_html( apply_filters( 'woocommerce_rating_filter_count', "({$count})", $count, $rating ) );

            if($rating == 5){$class ='stars5';}
            elseif($rating == 4){$class='stars4';}
            elseif($rating == 3){$class='stars3';}
            elseif($rating == 2){$class='stars2';}
            else{$class='stars1';}
            ?>

            <div class="rating__block <?php echo $class ?>">
                <div class="rate"></div>
                <span><?php echo $count_html; ?></span>
            </div>

            <?php
        }

        echo '</div>';



        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean(); // WPCS: XSS ok.
        }


    }



    /**
     * Update Widget
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;
    }




    /**
     * Widget Settings
     * @param array $instance
     */
    public function form( $instance )
    {
        //default widget settings.
        $defaults = array(
            'title'		=> 'Рейтинг',
        );
        $instance = wp_parse_args( (array) $instance, $defaults );


        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <?php
    }
}