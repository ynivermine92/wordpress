<?php

remove_action(
    'woocommerce_after_single_product_summary',
    'woocommerce_output_related_products',
    20
);
add_action(
    'woocommerce_after_single_product_summary',
    'my_related_products_slider',
    20
);

function my_related_products_slider()
{
    global $product;

    if (!$product) return;

    $related_ids = wc_get_related_products($product->get_id(), 8);

    if (empty($related_ids)) return;

?>

    <section class="related products">
        <div class="row">
            <div class="col-12">
                <h2 class="related__title title"><?php esc_html_e('Related products', 'woocommerce'); ?></h2>

            </div>
        </div>



        <div class="related__slider swiper">

            <div class="swiper-wrapper">

                <?php
                global $post;

                foreach ($related_ids as $product_id) :

                    $post = get_post($product_id);
                    setup_postdata($post);
                    wc_setup_product_data($post);
                ?>

                    <div class="swiper-slide">
                        <?php wc_get_template_part('content', 'product'); ?>
                    </div>

                <?php endforeach; ?>

                <?php wp_reset_postdata(); ?>

            </div>

            <!-- Навигация ВНЕ swiper-wrapper -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- если нужны точки -->
            <div class="swiper-pagination"></div>

        </div>
    </section>

<?php

    wp_reset_postdata();
}
