




1 Регестрируем fuction.php  апи nonse
2 получаем в жс апи 
3 выводим где то функциях бекенде где нужно nonse



1 fuction.php 

add_action('rest_api_init', function () {

	register_rest_route('myapp/v1', '/nonce', [
		'methods' => 'GET',
		'permission_callback' => '__return_true',
		'callback' => function () {
			return [
				'nonce' => wp_create_nonce('wp_rest')
			];
		}
	]);
});



получаем его  в жс (через апи)

2 async function getNonce() {
    const response = await fetch("/wp-json/myapp/v1/nonce");
    const data = await response.json();
    return data.nonce;
  }






проверяем на бекенде 
3 это проверка ключа (на бекенде где нужно проверить )
check_ajax_referer('wp_rest', 'nonce');




