<?
function bredcrumbs()
{
?>
  <div data-aos="fade-right" class="top">
    <div class="container">
      <div class="bredcrumbs">
        <ul class="bredcrumbs__list">

          <li class="bredcrumbs__item">
            <a class="bredcrumbs__link" href="<?php echo esc_url(home_url()); ?>">Головна</a>
          </li>
          <li class="bredcrumbs__item">
            <span class="bredcrumbs__separator">/</span>
          </li>

          <?php
          // Страница продукта
          if (function_exists('is_product') && is_product()) {
            global $post;
            $product = wc_get_product($post->ID);

            if ($product) {
              $terms = wp_get_post_terms($product->get_id(), 'product_cat');

              if (! empty($terms) && ! is_wp_error($terms)) {
                $last_term = end($terms);
                echo '<li class="bredcrumbs__item">';
                echo '<a class="bredcrumbs__link" href="' . esc_url(get_term_link($last_term)) . '">' . esc_html($last_term->name) . '</a>';
                echo '</li>';
                echo '<li class="bredcrumbs__item"><span class="bredcrumbs__separator">/</span></li>';
              }

              echo '<li class="bredcrumbs__item">';
              echo '<span class="bredcrumbs__current">' . esc_html(get_the_title()) . '</span>';
              echo '</li>';
            }

            // Страницы WooCommerce (каталог, корзина, аккаунт и т. д.)
          } elseif (function_exists('is_woocommerce') && is_woocommerce()) {
            $title = woocommerce_page_title(false);
            echo '<li class="bredcrumbs__item"><span class="bredcrumbs__current">' . esc_html($title) . '</span></li>';

            // Обычные страницы и записи
          } else {
            echo '<li class="bredcrumbs__item"><span class="bredcrumbs__current">' . esc_html(get_the_title()) . '</span></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
<?php
}

// хлебные крошки как как на обычных страницах так ина вукомерс и товар тоже добавляют какой нажал Универсальные крошки 
