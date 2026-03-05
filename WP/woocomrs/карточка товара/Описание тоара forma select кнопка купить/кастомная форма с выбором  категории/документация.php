 кастомизация формы ( тут у меня табы ) размер и цвет

1  woocommerce\content-single-product.php захожу

2 убираю хук  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

3 ставлю свой хук woocoms.php