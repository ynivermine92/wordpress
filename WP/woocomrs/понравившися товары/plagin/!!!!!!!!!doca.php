<!-- добавить шорт код  пхп или разкоментрировать  появиться класс на карточке который можно будет кликнуть -->

<!-- 1 woocomrs добавить  где кастомизация карточки  -->

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

// 1. wishlist
add_action('woocommerce_before_shop_loop_item', function () {
echo '<div class="categories__wishlist product-item__link-heart">';
    echo do_shortcode('[ti_wishlists_addtowishlist]');
    echo '</div>';
}, 5);

// 2. ссылка на товар
add_action('woocommerce_before_shop_loop_item', function () {
echo '<a href="' . get_the_permalink() . '" class="categories__cart">';
    }, 10);

    // 3. закрытие ссылки
    add_action('woocommerce_after_shop_loop_item', function () {
    echo '</a>';
}, 5);



<!-- 2 добавить класс щечику лайков   хедере -->
 wishlist_products_counter_number


 
<!--  3 в папку woocomerce  скинуть файл ti-wishlist.php  уже кастомизирвона  ( файл взятый из плагинна template) -->


<!-- 4 настройке плагина настройить под мой проект        и ставить название моего контейнера там где товары через точку  пример .categories__items   -->