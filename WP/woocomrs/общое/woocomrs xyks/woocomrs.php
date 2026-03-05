<?php




if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    //woocommerce support
    function modis_add_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }
    add_action('after_setup_theme', 'modis_add_woocommerce_support');








    /* _________________ Все товары    файл archive-product_______________________________________________ */


    /* кастомный селект */

    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);



    /*  2 ставляем мой кастомный селект на тяжкой на вокомерс   */


?>
    <div class="selector">
        <form class="woocommerce-ordering" method="get"> /* класс оставляем вокомерса */
            <div class="categories__box">

                <div class="selector__box">
                    <div class="selector__inner">
                        <select name="orderby" class="selector__wrapper" onchange="this.form.submit()"> <!-- сюда ставляем свой класс   -->
                            <option value="menu_order" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'menu_order'); ?>>За популярністю</option>
                            <option value="popularity" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'popularity'); ?>>По популярності</option>
                            <option value="rating" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'rating'); ?>>По рейтингу</option>
                            <option value="date" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'date'); ?>>Новинки</option>
                            <option value="price" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'price'); ?>>Вид дешевих до дешевих</option>
                            <option value="price-desc" <?php selected(isset($_GET['orderby']) ? $_GET['orderby'] : '', 'price-desc'); ?>>Вид дорогих до дешевих</option>
                        </select>
                    </div>
                </div>

            </div>
            <input type="hidden" name="paged" value="1">
        </form>
    </div>

<?


    /*  кастомизировать ul li не нужно если будет фильтр через аякс 
    */

    /* Для замены класса ul карточёк товара ( обертки  items) */
    add_filter('woocommerce_product_loop_start', 'my_custom_products_ul', 10);
    function my_custom_products_ul($html)
    {
        // Заменяем стандартный класс на свой
        $html = str_replace('class="products columns-4"', 'class="categories__items"', $html);
        return $html;
    }


    /* Для замены класса li  ( item ) */
    add_filter('post_class', 'productItem', 20, 3);
    function productItem($classes, $class, $post_id)
    {
        if ('product' === get_post_type($post_id) && !is_admin()) {
            if (!is_singular('product')) {
                $classes = array_diff($classes, ['columns-4']);
                $classes[] = 'categories__item';
            }
        }
        return $classes;
    }






    /* _________________ Отдельный товар         файл content-product_____________________________________ */



    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

    // ссылка на товар свой класс
    add_action('woocommerce_before_shop_loop_item', function () {
        echo '<a href="' . get_the_permalink() . '" class="categories__cart">';
    }, 10);
    //закрывает ссылку
    add_action('woocommerce_after_shop_loop_item', function () {
        echo '</a>';
    }, 5);





    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

    // названия товара свой класс
    add_action('woocommerce_shop_loop_item_title', function () {
        echo 'h2 class=categories__name' . get_the_title() . 'h2';
    }, 10);
}












remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
/* кнопка на карточке товара  */
add_action('woocommerce_after_shop_loop_item', function () {
    echo '<a href="' . get_the_permalink() . '" class="categories__link">В КОШИК</a>';
}, 10);



/* изменить текст и  стили   на карточке товара (акция )  */
add_filter('woocommerce_sale_flash', function ($html, $post, $product) {
    return '<span class="onsale"> АКЦІЯ </span>';
}, 10, 3);
