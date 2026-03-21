
<?php

add_action('acf/init', 'register_acf_blocks');
function register_acf_blocks()
{
    // Проверяем функцию
    if (function_exists('acf_register_block_type')) {

        acf_register_block_type([
            'name'              => 'flexible_block',
            'title'             => __('Flexible Block'),
            'description'       => __('Блок с Flexible Content внутри'),
            'render_template' => get_template_directory() . '/inc/template/flexible-block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'mode'              => 'edit',
        ]);
    }
}
