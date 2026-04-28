Вывод кастомного елси нужно без коментаря можно поставить сразу звездочки




 // Рейтинг
            echo '<div class="star jq-ry-container" data-rateyo-rating="' . esc_attr($product->get_average_rating()) . '" style="width: 85px;">';
                echo wc_get_rating_html($product->get_average_rating());
            echo '</div>';