<?php

/* endpoint */

add_action('rest_api_init', function () {
    register_rest_route('wishlist/v1', '/filter', [
        'methods' => 'POST',
        'callback' => 'get_wishlist_callback_rest', /* название вывода функции*/
        'permission_callback' => '__return_true', // доступ для всех
    ]);
});





function get_wishlist_callback_rest($request)
{
    $wishlist = $request->get_param('wishlist');



    if (empty($wishlist)) {
        return new WP_Error('empty_wishlist', 'wishlist пуст', ['status' => 400]);
    }

    $ids = array_map('intval', explode(',', sanitize_text_field($wishlist)));


    // если пользователь авторизован — сохраняем wishlist в user meta
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();

        update_user_meta($user_id, 'user_wishlist', $ids);
    }

    $args = [
        'post_type' => 'product',
        'post__in' => $ids,
        'posts_per_page' => -1,
        'orderby' => 'post__in'
    ];

    $query = new WP_Query($args);

    $products = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;

            $products[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => $product->get_image('woocommerce_thumbnail', ['class' => 'wishlist__item-img']),
                'price' => $product->get_price_html()
            ];
        }
        wp_reset_postdata();
    }

    return ['products' => $products];
}