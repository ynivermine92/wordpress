<?php
if (!defined('_S_VERSION')) {
  define('_S_VERSION', '1.0.0');
}

function fast_vid_setup() {
  add_theme_support('title-tag');
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );
}
add_action('after_setup_theme', 'fast_vid_setup');




function fast_vid_scripts() {

  wp_enqueue_style('fast-vid-global-style', get_stylesheet_uri(), array(), _S_VERSION);

  wp_enqueue_style('fast-vid-style', get_template_directory_uri() . '/css/style.css', array(), _S_VERSION);


  wp_enqueue_script('fast-vid-script', get_template_directory_uri() . '/js/script.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'fast_vid_scripts');





require get_template_directory() . '/inc/template-tags.php';







/* регистрация нав меню */
function register_my_menu() {
    register_nav_menu('header-menu', 'Меню в шапке');
}
add_action('after_setup_theme', 'register_my_menu');
























