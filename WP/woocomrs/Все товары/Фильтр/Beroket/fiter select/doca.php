
1 скинуть вокомерс 

   /* select filter */
    /* убрать дефолт */
    add_filter('woocommerce_catalog_orderby', 'custom_orderby');
    add_filter('woocommerce_default_catalog_orderby_options', 'custom_orderby');

    function custom_orderby($options)
    {
        unset($options['menu_order']); // убирает "По умолчанию"
        return $options;
    }

    add_filter('woocommerce_catalog_orderby', 'my_orderby');
    add_filter('woocommerce_default_catalog_orderby_options', 'my_orderby');


     /*Название хтмл импутов селекте */
    function my_orderby($options)
    {

        return array(
            'popularity'  => 'Популярные',
            'rating'      => 'По рейтингу',
            'date'        => 'Новинки',
            'price'       => 'Цена ↑',
            'price-desc'  => 'Цена ↓',
        );
    }


2 в сетинге в селекторе ( авто силиктор нажать  тогда будет аякс селектор ) 