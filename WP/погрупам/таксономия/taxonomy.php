/* Регистрация таксономии  категории название */

function register_taxonomies()
{
    // Регистрация таксономии для брендов
    $brand_labels = array(
        'name'              => 'Бренды',
        'singular_name'     => 'Бренд',
        'search_items'      => 'Искать бренды',
        'all_items'         => 'Все бренды',
        'parent_item'       => 'Родительский бренд',
        'parent_item_colon' => 'Родительский бренд:',
        'edit_item'         => 'Редактировать бренд',
        'update_item'       => 'Обновить бренд',
        'add_new_item'      => 'Добавить новый бренд',
        'new_item_name'     => 'Название нового бренда',
        'menu_name'         => 'Бренды',
    );

    $brand_args = array(
        'hierarchical'      => true, // таксономия будет иерархической (как категории)
        'labels'            => $brand_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug' => 'brand', // Slug для URL
        ),
    );

    register_taxonomy('brand', 'product', $brand_args); // 'product' - тип записи для WooCommerce

    // Регистрация таксономии для сезонов
    $season_labels = array(
        'name'              => 'Сезоны',
        'singular_name'     => 'Сезон',
        'search_items'      => 'Искать сезоны',
        'all_items'         => 'Все сезоны',
        'parent_item'       => 'Родительский сезон',
        'parent_item_colon' => 'Родительский сезон:',
        'edit_item'         => 'Редактировать сезон',
        'update_item'       => 'Обновить сезон',
        'add_new_item'      => 'Добавить новый сезон',
        'new_item_name'     => 'Название нового сезона',
        'menu_name'         => 'Сезоны',
    );

    $season_args = array(
        'hierarchical'      => true, // таксономия будет иерархической (как категории)
        'labels'            => $season_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug' => 'season', // Slug для URL
        ),
    );

    register_taxonomy('season', 'product', $season_args); // 'product' - тип записи для WooCommerce
}

// Хук для инициализации
add_action('init', 'register_taxonomies');
