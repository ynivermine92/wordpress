  1 product-item__link-heart - класса должет быть (на лайке клик)
  2 если товар выбран появится  product-item__link-heart active
  3 user-nav__like должен быть хедере( на количестве лайков  )  

  4 передать  обьект авторизированого пользователя в жс



  
	wp_enqueue_script(
		'script', 
		get_template_directory_uri() . '/assets/js/main.js',
		array('jquery'),
		'1.0',
		true
	);
	
	wp_localize_script('script', 'wpApiSettings', [
		'root' => esc_url(rest_url()),
		 /*передаем авторизированного юзера в жс */
		'nonce' => wp_create_nonce('wp_rest'),
	]);
