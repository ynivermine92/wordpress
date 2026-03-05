<!-- 1 -->
<!-- =   футере уже готовый шаблон скинуть проект футера   мой файл footer.php-->





<!-- 2 -->
<?
/* fuction.php */
/* Создать кастомный логотип для футера  если нужно что бы отличался от хедера  */

function my_customizer_footer_logo($wp_customize)
{
    // Раздел для футера
    $wp_customize->add_section('footer_logo_section', array(
        'title'    => __('Footer Logo', 'your-theme-textdomain'),
        'priority' => 30,
        'description' => 'Этот логотип будет отображаться в футере',
    ));

    // Настройка логотипа
    $wp_customize->add_setting('footer_logo_setting', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url',
    ));

    // Контрол для загрузки изображения
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo_control', array(
        'label'    => __('Footer Logo', 'your-theme-textdomain'),
        'section'  => 'footer_logo_section',
        'settings' => 'footer_logo_setting',
    )));
}
add_action('customize_register', 'my_customizer_footer_logo');
?>



<!--  вывод футер  логотипа  это писать footer.php-->

<?php
$footer_logo = get_theme_mod('footer_logo_setting');
if ($footer_logo) {
    echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($footer_logo) . '" alt="' . get_bloginfo('name') . '"></a>';
}
?>







<!-- 3 -->
<!-- ----------------вывод страниц нав в  футер ---------------------- -->


<!-- поменять на мои классы fuction php  (1 админке добавить меню в футер (пустое не выведиться)    
                                        2(через хедер регестрирую нав меню  футера (так что мне только нужно менять футере
  классы которые ниже )) ) -->





// Класс для <li> в футере
    add_filter('nav_menu_css_class', 'footer_nav_item_class', 10, 4);
    function footer_nav_item_class($classes, $item, $args, $depth) {
    if ($args->theme_location == 'footer_nav') { // только футер
    $classes = array('footer__item'); // твой класс для
<li>
    }
    return $classes;
    }

    // Класс для <a> в футере
        add_filter('nav_menu_link_attributes', 'footer_nav_link_class', 10, 4);
        function footer_nav_link_class($atts, $item, $args, $depth) {
        if ($args->theme_location == 'footer_nav') { // только футер
        $atts['class'] = 'footer__item-link'; // твой класс для <a>
            }
            return $atts;
            }






            <!--  вывод нав меню футер  это писать footer.php-->
            <ul class="footer__items footer__info-items">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_nav',
                    'container' => false,      // убираем лишний <div>
                    'items_wrap' => '%3$s',    // выводим только <li>
                ));
                ?>
            </ul>