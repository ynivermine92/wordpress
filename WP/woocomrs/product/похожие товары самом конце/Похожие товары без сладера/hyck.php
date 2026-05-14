<?php 

/* если сладйер не нужин  этот ввывод  карточка такая же самая как каталоге */
/* 2) */
add_filter('woocommerce_post_class', 'custom_wc_product_grid_classes', 10, 2);

function custom_wc_product_grid_classes($classes, $product)
{

    if (is_admin()) return $classes;

    if (wc_get_loop_prop('name') === 'related') {
        $classes[] = 'col-lg-3';
        $classes[] = 'col-6';
    }


    return $classes;
}

