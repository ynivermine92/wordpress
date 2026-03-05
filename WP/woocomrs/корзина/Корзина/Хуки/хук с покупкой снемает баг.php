


хук после покупки перекидывает назад там где совершал покупку (и товары не будут постоянно покупаться если я обновлю страницу)



add_action('template_redirect', 'lf_redirect_after_add_to_cart');
function lf_redirect_after_add_to_cart() {
	if (isset($_GET['add-to-cart'])) {
		$referrer = wp_get_referer(); 
		if ($referrer) {
			wp_safe_redirect($referrer);
			exit;
		}
	}
}







Когда юзер чистить куки  Или вылогенивается ( его выкидует из акаунта до гостя )

add_action('init', function() {
    $cookie_name = 'wordpress_logged_in_' . COOKIEHASH;

    if (!isset($_COOKIE[$cookie_name]) && is_user_logged_in()) {
        // Полный выход пользователя
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_set_current_user(0);
    }
});
