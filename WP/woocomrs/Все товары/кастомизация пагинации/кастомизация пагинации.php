/* кастомая пагинация  */

function custom_woocommerce_pagination_with_numbers() {
    global $wp_query;

    // Получаем количество страниц и текущую страницу
    $total_pages = $wp_query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));

    // Если страниц больше одной, выводим пагинацию
    if ($total_pages > 1) {
        echo '<nav class="woocommerce-pagination">';

        // Предыдущая страница
        if ($current_page > 1) {
            echo '<a href="' . esc_url(get_pagenum_link($current_page - 1)) . '" class="prev page-numbers">Предыдущая</a>';
        } else {
            echo '<span class="prev page-numbers disabled">Предыдущая</span>';
        }

        // Нумерация страниц
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i === $current_page) {
                echo '<span class="page-numbers current">' . $i . '</span>';
            } else {
                echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="page-numbers">' . $i . '</a>';
            }
        }

        // Следующая страница
        if ($current_page < $total_pages) {
            echo '<a href="' . esc_url(get_pagenum_link($current_page + 1)) . '" class="next page-numbers">Следующая</a>';
        } else {
            echo '<span class="next page-numbers disabled"> </span>';
        }

        echo '</nav>';
    }
}


add_action('woocommerce_after_shop_loop', 'custom_woocommerce_pagination_with_numbers', 10);