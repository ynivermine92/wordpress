<?php
/* Template Name: Blog */
get_header();
?>

<section class="blogs">


    <div class="blogstop">
        <div class="wrapper">
            <div class="row">
                <div class="col-12">
                    <h1 class="title">Inspiration & Education</h1>
                </div>
            </div>

            <!-- Категории кпопки -->
            <div class="row">
                <div class="col-12">
                    <ul class="blogs__items">

                        <li class="blogs__item">
                            <button class="blogs__btn active btn-green" id="btn-all" data-category-id="0">
                                Все
                            </button>
                        </li>

                        <?php

                        $categories = array_filter(get_categories());
                        foreach ($categories as $category) {
                            if ($category->slug === 'main') continue;
                        ?>
                            <li class="blogs__item">
                                <button class="blogs__btn btn-green" data-category-id="<?php echo esc_attr($category->term_id); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </button>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>



            <!-- Главный пост -->
            <?php
            $args_main = [
                'post_type'      => 'post',
                'posts_per_page' => 1,
                'category_name'  => 'main',
            ];
            $main_query = new WP_Query($args_main);


            if ($main_query->have_posts()) {
                $main_post_id = $main_query->posts[0]->ID; ?>


                <div class="row blogstop__inner">
                    <!-- перебераем посты -->
                    <?php while ($main_query->have_posts()) {

                        $main_query->the_post(); ?> <!-- делает глобальные параметры для поста    the_title() the_content() the_permalink()  -->


                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="blogstop__content">
                                    <div class="blogstop__subtitle"><?php the_title(); ?></div>
                                    <p class="blogstop__text text"><?php echo get_the_excerpt(); ?></p>
                                    <a class="blogstop__link btn-green" href="<?php the_permalink(); ?>">Read article</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="blogstop__box">
                                    <?php if (has_post_thumbnail()) :
                                        the_post_thumbnail('servis', ['class' => 'blogstop__image']);
                                    else :
                                        echo 'Миниатюра не установлена';
                                    endif; ?>
                                </div>
                            </div>
                        </div>

                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>

    <?php wp_reset_postdata(); ?>




    <!-- Все остальные блоги -->

    <?php $paged = max(1, get_query_var('paged'));

    $args_other = [
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post__not_in'   => [$main_post_id],
        'paged'          => $paged,
    ];


    $other_query = new WP_Query($args_other); ?>

    <div class="wrapper">
        <?php if ($other_query->have_posts()) { ?>
            <div class="row blogs__category">
                <?php while ($other_query->have_posts()) {


                    $other_query->the_post();


                    $categories = get_the_category();

                    $cats_names = [];
                    if (!empty($categories)) {
                        foreach ($categories as $cat) {
                            $cats_names[] = $cat->name;
                        }
                    }   ?>

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


                                        <?php foreach ($cats_names as $name) { ?>
                                            <div class="blogs__label"><?php echo esc_html($name); ?></div>
                                        <?php } ?>
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


                <? } ?>
            </div>
        <? } ?>
    </div>



    <!-- Пагинация -->
    <div class="wrapper">
        <?php


        $total_pages = $other_query->max_num_pages;

        if ($total_pages > 1) { ?>
            <div class="pagination">
                <ul class="pagination__items">
                    <?php
                    // Prev
                    $prev_disabled = ($paged <= 1) ? ' disabled' : '';

                    $prev_page = max(1, $paged - 1);
                    ?>
                    <li class="pagination__item pagination__item-prev<?php echo $prev_disabled; ?>" data-pagination-id="<?php echo $prev_page; ?>">
                        <a class="pagination__link pagination__link-prev" href="#">
                            <span class="pagination__arrow">&lt;</span>
                        </a>
                    </li>

                    <?php
                    // параметры для пагинации 
                    $pagination_links = paginate_links([
                        'total'      => $total_pages, /* Общее количество страниц  передаем*/
                        'current'    => $paged,       /* тикущая страница */
                        'type'       => 'array',    /* Вернуть масив ссылклок */
                        'prev_next'  => false,     /* право лево убираем стандартные вопрес стрелки */
                        'end_size'   => 1, // сколько ссылок в начале/конце
                        'mid_size'   => 1, // сколько ссылок вокруг текущей
                        'dots'       => '…',
                    ]);

                    if (!empty($pagination_links)) {
                        foreach ($pagination_links as $item) {
                            $class = 'pagination__item';

                            // активная страница
                            if (strpos($item, 'current') !== false) $class .= ' active';

                            // определяем номер страницы
                            if (preg_match('/(?:page\/|paged=)(\d+)/', $item, $matches)) {
                                $page_number = $matches[1];
                            } else {
                                $page_number = 1;
                            }

                            // заменяем стандартный класс
                            $item = str_replace('page-numbers', 'pagination__link', $item);

                            // если это dots — выводим span
                            if (strpos($item, '…') !== false) {
                                echo '<li class="' . $class . '" data-pagination-id="' . $page_number . '"><span class="pagination__link dots">…</span></li>';
                            } else {
                                echo '<li class="' . $class . '" data-pagination-id="' . $page_number . '">' . $item . '</li>';
                            }
                        }
                    }
                    ?>

                    <?php
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
        <? } ?>
    </div>



    <?php wp_reset_postdata(); ?>
</section>

<?php get_footer(); ?>