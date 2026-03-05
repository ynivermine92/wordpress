<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <?php global $geniuscourses_options; ?>




  <header>

    <nav>
      <?php
      wp_nav_menu(array(
        'theme_location'  => 'header_nav',
        'container'      => false,
        'items_wrap'     => '%3$s',
      ));
      ?>
    </nav>


  </header>









<!-- 
  копируем верху хедер  и заменяем wp дальше  натягиваем  наш хедер 

  '%3$s' - этот параметр оставляем (скидует классы ul li  что бы можно было заменить на свои )

  1 регистрируем php меню


  function theme_register_nav_menus()
  {
  register_nav_menus(
  array(
  'header_nav' => 'Header Navigation',
  'footer_nav' => 'Footer Navigation',
  )
  );
  }
  add_action('after_setup_theme', 'theme_register_nav_menus', 0);



  2 админке Внешний вид / меню дальше
  1 нажимаем на наше меню на чекбокс выбераем
  2 создаем меню их обьеденяем название меню (header) чекбокс выбераем Header Navigation и сохранить меню
  3 тут же с верху перехождим управление областями и там где навигатион выберам header
  4 и добавляем страницы и сохраняем ( меню должно подтянуться ) и наче я не смогу переменувать ul menu__items


  5 хуки изменяют классы ul li hedere


  /* nav menu class li хук для ли */
  add_filter('nav_menu_css_class', 'nav_li_class', 10, 4);

  function nav_li_class($classes, $item, $args, $depth)
  {
  if ($args->theme_location === 'header_nav') {
  $classes = ['menu__item'];
  }
  return $classes;
  }


  /* nav menu class link хук для ссылки */
  add_filter('nav_menu_link_attributes', 'navLinkClass', 10, 4);

  function navLinkClass($atts, $item, $args, $depth)
  {
  if ($args->theme_location === 'header_nav') {
  $atts['class'] = 'menu__item-link';
  }
  return $atts;
  } -->