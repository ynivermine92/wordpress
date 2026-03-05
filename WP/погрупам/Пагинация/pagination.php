<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

global $wp_query;

$total_pages = $wp_query->max_num_pages;
$current_page = max(1, get_query_var('paged'));

if ( $total_pages <= 1 ) return;

echo '<div class="pagination">';

// Prev
if ( $current_page > 1 ) {
  echo '<a class="pagination__prev pagination__arrows" href="' . get_pagenum_link($current_page - 1) . '">PREVIOUS</a>';
}

// Pages
echo '<ul class="pagination__items">';
for ( $i = 1; $i <= $total_pages; $i++ ) {
  $active_class = ($i === $current_page) ? 'pagination__link pagination__link--active' : 'pagination__link';
  echo '<li class="pagination__item">
          <a class="' . esc_attr($active_class) . '" href="' . esc_url(get_pagenum_link($i)) . '">' . $i . '</a>
        </li>';
}
echo '</ul>';

// Next
if ( $current_page < $total_pages ) {
  echo '<a class="pagination__next pagination__arrows" href="' . get_pagenum_link($current_page + 1) . '">NEXT</a>';
}

echo '</div>';
