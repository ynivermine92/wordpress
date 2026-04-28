<aside class="sidebar">
    <?php
    if (is_active_sidebar('main-sidebar')) {
        dynamic_sidebar('main-sidebar');
    } ?>


    <div class="fillter">
        <div class="fillter__content-wrapper">
            <div class="fillter__wrapper">
                <div class="fillter__title">
                    Filter
                </div>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img//png/filter.png" alt="filter">
            </div>
            <div class="fillter__clouse">X</div>
        </div>

        <div class="fillter__inner">


            <div class="fillter__box  fillter__content active">
                <!-- категория -->

                <?php echo do_shortcode('[br_filter_single filter_id=742]'); ?>
            </div>

            <div class="fillter__box">
                <!--   свет -->
                <?php echo do_shortcode('[br_filter_single filter_id=730]'); ?>
            </div>
            <div class="fillter__box">
                <!--    уход -->
                <?php echo do_shortcode('[br_filter_single filter_id=729]'); ?>
            </div>
            <!--  цена -->
            <?php echo do_shortcode('[br_filter_single filter_id=633]'); ?>
            <!--  удалить -->

            <div class="fillter__mob-content">
                <button class="fillter__btn-clouse btn-orange">Показать</button>
                <?php echo do_shortcode('[br_filter_single filter_id=735]'); ?>
            </div>



        </div>

    </div>

</aside>