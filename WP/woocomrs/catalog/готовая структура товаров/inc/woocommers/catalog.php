<?php


/********************************** !!!catalog!!! **********************************/

/********************************** wrapper продуктов **********************************/
/* Для замены класса ul карточёк товара ( обертки items) */
add_filter('woocommerce_product_loop_start', 'my_custom_products_ul', 10);
function my_custom_products_ul($html)
{
    // Заменяем стандартный класс на свой
    $html = str_replace('class="products columns-4"', 'class="categories__items row"', $html);
    return $html;
}


/********************************** item продуктов **********************************/
add_filter('woocommerce_post_class', 'productItemWoo', 20, 2);
function productItemWoo($classes, $product)
{
    if (!is_product()) {
        $classes[] = 'categories__item';
        $classes[] = 'col-md-4';
        $classes[] = 'col-6';
    }

    return $classes;
}

/********************************** обертка нутри item **********************************/
add_action('woocommerce_before_shop_loop_item', 'open_product_wrapper', 5);
function open_product_wrapper()
{
    echo '<div class="categories__item-box">';
}

add_action('woocommerce_after_shop_loop_item', 'close_product_wrapper', 20);
function close_product_wrapper()
{
    echo '</div>';
}


/********************************** image продуктов, кастомный размер image **********************************/

add_filter('single_product_archive_thumbnail_size', function () {
    return 'best_sellers';
});




/********************************** продукты, карточка товара **********************************/


remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

// 1. wishlist
add_action('woocommerce_before_shop_loop_item', function () {
    echo '<div class="categories__wishlist product-item__link-heart">';
    echo do_shortcode('[ti_wishlists_addtowishlist]');
    echo '</div>';
}, 5);


/********************************** продукты, лейбел акция **********************************/
add_filter('woocommerce_sale_flash', function ($html, $post, $product) {
    return '<span class="onsale"> АКЦІЯ </span>';
}, 10, 3);


// 2. ссылка на товар
add_action('woocommerce_before_shop_loop_item', function () {
    echo '<a href="' . get_the_permalink() . '" class="categories__cart">';
}, 10);

// 3. закрытие ссылки
add_action('woocommerce_after_shop_loop_item', function () {
    echo '</a>';
}, 5);






/********************************** продукты, Рейтинг **********************************/

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

add_action('woocommerce_shop_loop_item_title', function () {
    global $product;

    echo '<div class="categories__contnet">';
    echo get_template_part('section/rating');


    echo '<div class="review-content">';
    echo 'Отзывов :';
    echo '</div>';

    echo '<div class="review-count">';
    echo '' . $product->get_review_count();
    echo '</div>';


    echo '</div>';


    /********************************** продукты, title **********************************/
    echo '<h2 class="categories__name">' . get_the_title() . '</h2>';


    /********************************** продукты, Краткое описание **********************************/
    echo '<div class="categories__desc">';
    echo $product->get_short_description();
    echo '</div>';
}, 9);









/********************************** продукты, prace  **********************************/
add_filter('woocommerce_variable_price_html', 'custom_variable_min_price_only', 10, 2);


function custom_variable_min_price_only($price, $product)
{
    $min_regular = $product->get_variation_regular_price('min', true);
    $min_sale    = $product->get_variation_sale_price('min', true);

    // если есть скидка
    if ($min_sale && $min_sale < $min_regular) {
        return wc_format_sale_price(
            wc_price($min_regular),
            wc_price($min_sale)
        ) . $product->get_price_suffix();
    }

    // без скидки — просто минимальная цена
    return wc_price($min_regular) . $product->get_price_suffix();
}



// меняем разделитель копеек (запятая -> точка)
add_filter('wc_get_price_decimal_separator', function () {
    return '.';
});

// пробел между тысячами
add_filter('wc_get_price_thousand_separator', function () {
    return '';
});


// убираем пробел между числом и валютой и меняем порядок валюты и числа %1$s, валюта %2$s
add_filter('woocommerce_price_format', function () {
    return '%2$s%1$s';
});






/********************************** продукты, кнопка товара **********************************/
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_after_shop_loop_item', function () {
    global $product;

    if ($product->is_type('variation')) {
        echo '<a href="?add-to-cart=' . $product->get_id() . '" class="categories__link btn-orange">
        <span>В КОШИК</span>
        </a>';
    } else {
        echo '<a href="' . get_permalink($product->get_id()) . '" class="categories__link btn-orange">   <span>В КОШИК</span></a>';
    }
}, 10);




/**************** общия обертка кнопки фильтра для адаптива, моб фильтр ****************/

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

add_action('woocommerce_before_shop_loop', function () {
    echo '<div class="categories__count-box">';
    echo '<button class="fillter-mob__btn btn">
	<span>Фильтр</span>
	<img src="' . get_template_directory_uri() . '/assets/img/png/filter.png" alt="filter">
</button>';

    /* количество товаров */
    woocommerce_result_count();
    echo '</div>';
}, 20);
