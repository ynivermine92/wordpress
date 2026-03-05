<?php

/* аякс запрос для регистрованных юзеров */
add_action('wp_ajax_filter_blogs', 'filter_blogs_callback');

/*  не для регистрированных аякс запрос для регистрованных юзеров */
add_action('wp_ajax_nopriv_filter_blogs', 'filter_blogs_callback');




function filter_blogs_callback()
{

    /* получает номер кнопки (айди) */
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



    $main_cat = get_category_by_slug('main');   /* сохранием ярлык рубрики котрый будем игнорировать блоге */



    $query = new WP_Query([
        'cat'              => $categoryId,           /* сохраняем айди кпопки */
        'posts_per_page'   => 2,
        'paged'            => $paged,                /* странится текущая */
        'category__not_in' => [$main_cat->term_id],  /* игнорирум вывод ярлык рубрики main */
    ]);




    // начинаем собирать буфер для блогов
    ob_start();




    /*  если пост не пустой  */
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $categories = get_the_category();
            $cats_names = [];
            if (!empty($categories)) {
                foreach ($categories as $cat) {
                    // сохраням название рубрики у каждого одельно поста 

                    $cats_names[$cat->term_id] = $cat->name; // сохраняем ID категории как ключ

                }
            }

            // если нет категорий после фильтра
            if (empty($cats_names)) {
                $cats_names[] = 'Без категории';
            } ?>



            <div class="col-md-4 col-sm-6 col-12">
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

                                // вывод категорий в зависимости от выбранного фильтра
                                if ($categoryId === 0) {
                                    // показываем все категории
                                    foreach ($cats_names as $item) { ?>
                                        <div class="blogs__label"><?php echo esc_html($item); ?></div>
                                    <?php }
                                } else {
                                    // показываем только выбранную категорию
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

    /* заканчивваем сбор фуфера постов */
    $html_posts = ob_get_clean();





    /* Пагинация */
    /* собираем пагинациию буфер */
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
                // Получаем массив ссылок для страниц
                $pagination_links = paginate_links([
                    'total'     => $total_pages,
                    'current'   => $paged,
                    'type'      => 'array',
                    'prev_next' => false,
                    'end_size'  => 1, // сколько ссылок слева и справа показывать
                    'mid_size'  => 1, // сколько ссылок вокруг текущей страницы
                    'dots'      => '…',
                ]);

                if (!empty($pagination_links)) {
                    foreach ($pagination_links as $item) {

                        $class = 'pagination__item';

                        // Если ссылка текущая
                        if (strpos($item, 'current') !== false) $class .= ' active';

                        // Определяем номер страницы
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

    /* останавливаем WP_Query */
    wp_reset_postdata();

    /* заканчиваем сбор пагинации буфер */
    $html_pagination = ob_get_clean();



    /*передаем на аякс нашу разметку  и она лит в ответ аякс*/
    wp_send_json_success([
        'posts' => $html_posts,
        'pagination' => $html_pagination,
    ]);
}
