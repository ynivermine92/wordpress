<?php


add_action('wp_ajax_filter_blogs', 'filter_blogs_callback');

add_action('wp_ajax_nopriv_filter_blogs', 'filter_blogs_callback');




function filter_blogs_callback()
{


    if (isset($_POST['categoryId'])) {
        $categoryId = intval($_POST['categoryId']);
    } else {
        wp_send_json_error(['message' => 'Не передан ID категории']);
    }

    /* получает номер страницы (айди) */
    if (isset($_POST['pageId'])) {
        $paged = intval($_POST['pageId']);
    } else {
        $paged = 1;
    }



    $main_cat = get_category_by_slug('main');  



    $query = new WP_Query([
        'cat'              => $categoryId,         
        'posts_per_page'   => 1,
        'paged'            => $paged,              
        'category__not_in' => [$main_cat->term_id],  
    ]);





    ob_start();





    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $categories = get_the_category();
            $cats_names = [];
            if (!empty($categories)) {
                foreach ($categories as $cat) {
                

                    $cats_names[$cat->term_id] = $cat->name;

                }
            }

       
            if (empty($cats_names)) {
                $cats_names[] = 'Без категории';
            } ?>



            <div class="col-lg-4 col-sm-6 col-12">
                <a class="blogs__inner" href="<?php the_permalink(); ?>">
                    <div class="blogs__image">
                        <?php
                        if (has_post_thumbnail()) :
                            the_post_thumbnail('blog_item');
                        else :
                            echo 'Миниатюра не установлена';
                        endif;
                        ?>
                    </div>
                    <div class="blogs__box">
                        <div class="blogs__data">
                            <div class="blogs__wrapper-contnet">
                                <?php if (empty($cats_names)) {
                                    $cats_names[0] = 'Без категории';
                                }

                               
                                if ($categoryId === 0) {
                                   
                                    foreach ($cats_names as $item) { ?>
                                        <div class="blogs__label"><?php echo esc_html($item); ?></div>
                                    <?php }
                                } else {
                                    
                                    if (isset($cats_names[$categoryId])) { ?>
                                        <div class="blogs__label"><?php echo esc_html($cats_names[$categoryId]); ?></div>
                                <?php }
                                }
                                ?>
                            </div>
                            <span class="blogs__month month"><?php echo get_the_date('M d, Y'); ?></span>
                        </div>
                        <div class="blogs__sub-title title"><?php the_title(); ?></div>
                        <p class="blogs__text text"><?php echo get_the_excerpt(); ?></p>
                        <button class="blogs__content-btn">
                            <span class="btn-text text">Learn more</span>
                            <?php
                            $arrow = get_template_directory() . '/assets/img/svg/arrow.svg';
                            if (file_exists($arrow)) {
                                $svg = file_get_contents($arrow);
                                echo str_replace('<svg', '<svg class="icon-arrow"', $svg);
                            }
                            ?>
                        </button>
                    </div>
                </a>
            </div>

        <? }
    } else {
        echo '<p>Постов нет.</p>';
    }

  
    $html_posts = ob_get_clean();





    /* Пагинация */
   
    ob_start();

    $total_pages = $query->max_num_pages;

    if ($total_pages > 1) { ?>


        <div class="pagination">
            <ul class="pagination__items">
                <?
                // Prev
                $prev_disabled = ($paged <= 1) ? ' disabled' : '';
                $prev_page = max(1, $paged - 1);
                ?>
                <li class="pagination__item pagination__item-prev<?php echo $prev_disabled; ?>" data-pagination-id="<?php echo $prev_page; ?>">
                    <a class="pagination__link pagination__link-prev" href="#">
                        <span class="pagination__arrow">&lt;</span>
                    </a>
                </li>
                <?

                $pagination_links = paginate_links([
                    'total'     => $total_pages,
                    'current'   => $paged,
                    'type'      => 'array',
                    'prev_next' => false,
                    'end_size'  => 1, 
                    'mid_size'  => 1, 
                    'dots'      => '…',
                ]);

                if (!empty($pagination_links)) {
                    foreach ($pagination_links as $item) {

                        $class = 'pagination__item';
                        if (strpos($item, 'current') !== false) $class .= ' active';
                        if (preg_match('/page\/(\d+)/', $item, $matches)) {
                            $page_number = $matches[1];
                        } elseif (preg_match('/paged=(\d+)/', $item, $matches)) {
                            $page_number = $matches[1];
                        } else {
                            $page_number = 1;
                        }

                        // Заменяем классы WP на твои
                        $item = str_replace('page-numbers', 'pagination__link', $item);

                        // Если это dots (многоточие)
                        if (strpos($item, '…') !== false) {
                            echo '<li class="' . $class . '" data-pagination-id="' . $page_number . '"><span class="pagination__link dots">…</span></li>';
                        } else {
                            echo '<li class="' . $class . '" data-pagination-id="' . $page_number . '">' . $item . '</li>';
                        }
                    }
                }

                // Next
                $next_disabled = ($paged >= $total_pages) ? ' disabled' : '';
                $next_page = min($total_pages, $paged + 1);
                ?>
                <li class="pagination__item pagination__item-next<?php echo $next_disabled; ?>" data-pagination-id="<?php echo $next_page; ?>">
                    <a class="pagination__link pagination__link-next" href="#">
                        <span class="pagination__arrow">&gt;</span>
                    </a>
                </li>
            </ul>

        </div>

<? }


    wp_reset_postdata();


    $html_pagination = ob_get_clean();



   
    wp_send_json_success([
        'posts' => $html_posts,
        'pagination' => $html_pagination,
    ]);
}
