

<!-- 1  асf должен быть установлен 
2  Регистрирую  страничку пример (глобал админке появилась)
3  акф создаю структуру моей странице
4 связиваю страницу мою и с акф ( картинка есть как сделать)
5 админке нахожу свою страницу и заполняю поля  -->






<?

/* page global admin register*/
add_action('init', function () {
  if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
      'page_title' => 'Global',    //название страницы
      'menu_title' => 'Global',    //название страницы
      'menu_slug'  => 'footer-settings',
      'capability' => 'edit_posts',
      'redirect'   => false
    ));
  }
});