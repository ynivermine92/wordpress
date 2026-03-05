<?







function theme_setup()
{
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'theme_setup');

/* регестрируем logo и он появиться  Внешний вид настройки свойстава сайта там можно будет ставить логотип */



/* вывод логотипа */

if (function_exists('has_custom_logo')) {
?>
    <a href="<?php echo esc_url(home_url("/")); ?>"> <? the_custom_logo(); ?> </a>
<?
}
?>