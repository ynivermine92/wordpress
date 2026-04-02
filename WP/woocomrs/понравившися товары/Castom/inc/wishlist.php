<?php
/* REST API endpoint для wishlist  */


add_action('rest_api_init', function () {

    // GET wishlist
    register_rest_route('wishlist/v1', '/wishlist', [
        'methods' => 'GET',
        'callback' => 'get_user_wishlist',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ]);

    // POST wishlist
    register_rest_route('wishlist/v1', '/wishlist', [
        'methods' => 'POST',
        'callback' => 'handle_user_wishlist',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ]);
});


/* GET */
function get_user_wishlist()
{
    $user_id = get_current_user_id();

    $wishlist = get_user_meta($user_id, 'user_wishlist', true);

    if (!is_array($wishlist)) {
        $wishlist = [];
    }

    if (empty($wishlist)) {
        return rest_ensure_response(['products' => []]);
    }

    $products = wc_get_products([
        'include' => $wishlist,
        'limit' => -1,
    ]);

    $data = [];
    foreach ($products as $product) {
        $data[] = [
            'id'    => $product->get_id(),
            'title' => $product->get_name(),
            'link'  => $product->get_permalink(),
            'image' => $product->get_image('woocommerce_thumbnail'),
            'price' => $product->get_price_html(),
        ];
    }

    return rest_ensure_response(['products' => $data]);
}


/*  POST */
/* request  получает парметры ндропоинта( а колбек ендропоинта хранит все что пришло из фроентенда*/
function handle_user_wishlist($request)
{
    $user_id = get_current_user_id();
    $wishlist_param = $request->get_json_params()['wishlist'] ?? [];


 
    /* не пустой  */
    if (!empty($wishlist_param)) {
        /* перезаписываем из wishlist_param в базу данныъ  user_wishlist*/
        update_user_meta($user_id, 'user_wishlist', $wishlist_param);
    }
    /* пустой  */
    if (empty($wishlist_param)) {
        /* презаписсываем в базе данных user_wishlist */
        update_user_meta($user_id, 'user_wishlist', []);
    }


    /* читаем из базы данных user_wishlist */
    $wishlist = (array) get_user_meta($user_id, 'user_wishlist', true);

   

    

    if (empty($wishlist)) {
        return rest_ensure_response(['products' => []]);
    }

    $products = wc_get_products([
        'include' => $wishlist,
        'limit' => -1,
    ]);

    $data = [];
    foreach ($products as $product) {
        $data[] = [
            'id'    => $product->get_id(),
            'title' => $product->get_name(),
            'link'  => $product->get_permalink(),
            'image' => $product->get_image('woocommerce_thumbnail'),
            'price' => $product->get_price_html(),
        ];
    }

    return rest_ensure_response(['products' => $data]);
}


    /*      echo '<pre>';
    print_r($ids_to_save);
    echo '</pre>';
    exit;
 */
