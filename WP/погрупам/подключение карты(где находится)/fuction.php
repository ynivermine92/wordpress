function enqueue_leaflet_assets()
{
  // Leaflet CSS
  wp_enqueue_style(
    'leaflet-css',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    array(),
    '1.9.4'
  );

  // Leaflet JS
  wp_enqueue_script(
    'leaflet-js',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    array(),
    '1.9.4',
    true
  );

  // Скрипт инициализации карты (создадим ниже)
  wp_enqueue_script(
    'leaflet-init',
    get_template_directory_uri() . '/assets/js/leaflet-init.js',
    array('leaflet-js'),
    '1.0',
    true
  );
}
add_action('wp_enqueue_scripts', 'enqueue_leaflet_assets');