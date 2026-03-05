<?php

class Wayup_About_Widget extends WP_Widget
{
    public $image_field = 'image';

    /**
     * General Setup
     */
    public function __construct() {

        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'wayup_about_widget',
            'description' => 'Виджет который выводит информацию в Компании'
        );
        /* Widget control settings. */
        $control_ops = array(
            'width'		=> 500,
            'height'	=> 450,
            'id_base'	=> 'wayup_about_widget'
        );
        /* Create the widget. */
        parent::__construct( 'wayup_about_widget', 'Wayup | О компании', $widget_ops, $control_ops );
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

        $text = $instance['text'];

        $link_more = $instance['link_more'];

        $link_anchor = $instance['link_anchor'];

        /* Our variables from the widget settings. */
        $image_id = $instance[$this->image_field];

        $image = new Aletheme_WidgetImageField( $this, $image_id );

        // Display Widget
        ?>

        <div class="widget banner" style="background: url(<?php echo $image->get_image_src(); ?>) no-repeat center top/ cover;">
            <?php /* Display the widget title if one was input (before and after defined by themes). */
            if ( $title )
                echo '<h4 class="banner__title">' . $title . '</h4>';
            ?>
            <p class="banner__text"><?php echo $text; ?></p>
            <?php if($link_more){ ?>
                <a href="<?php echo $link_more; ?>" class="banner__btn <?php if($link_anchor !=='Купить'){ ?>btn<?php } ?>"><?php echo $link_anchor; ?></a>
            <?php }?>

        </div>

        <?php

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
        $instance['text'] = strip_tags( $new_instance['text'] );
        $instance['link_more'] = strip_tags( $new_instance['link_more'] );
        $instance['link_anchor'] = strip_tags( $new_instance['link_anchor'] );

        $instance[$this->image_field] = (int) $new_instance[$this->image_field];
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
            'title'		=> 'Юридические консультации для малого бизнеса',
            'text'		=> 'Не позволяйте юридическим вопросам отвлекать вас от ведения бизнеса',
            'link_more' => '',
            'image'		=> '',
            'link_anchor'=>''
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $image_id   = isset( $instance[$this->image_field]) ? (int) $instance[$this->image_field] : 0;
        $image      = new Aletheme_WidgetImageField( $this, $image_id );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'text' ); ?>">Описание</label>
            <textarea class="widefat" cols="100" rows="5" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" ><?php echo $instance['text']; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link_more' ); ?>">Ссылка</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link_more' ); ?>" name="<?php echo $this->get_field_name( 'link_more' ); ?>" value="<?php echo $instance['link_more']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link_anchor' ); ?>">Текст кнопки</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link_anchor' ); ?>" name="<?php echo $this->get_field_name( 'link_anchor' ); ?>" value="<?php echo $instance['link_anchor']; ?>" />
        </p>
        <p>
            <label>Image: </label>
            <?php echo $image->get_widget_field(); ?>
        </p>

        <?php
    }
}