<?php
function breadcrumbs()
{
?>

  <div class="breadcrumbs">
    <div class="wrapper">

      <ul class="breadcrumbs__list">

        <!-- Главная -->
        <li class="breadcrumbs__item">
          <a class="breadcrumbs__link" href="<?php echo esc_url(home_url()); ?>">
            Главная
            <span class="breadcrumbs__separator"><?php svg_arrown() ?></span>
          </a>
        </li>

        <?php

        // Товар WooCommerce
        if (function_exists('is_product') && is_product()) {

          global $post;
          $terms = wp_get_post_terms($post->ID, 'product_cat');

          if (!empty($terms) && !is_wp_error($terms)) {

            foreach ($terms as $term) { ?>

              <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="<?php echo esc_url(get_term_link($term)); ?>">
                  <?php echo esc_html($term->name); ?>
                  <span class="breadcrumbs__separator"><?php svg_arrown() ?></span>
                </a>
              </li>

          <?php }
          } ?>

          <li class="breadcrumbs__item">
            <span class="breadcrumbs__current">
              <?php echo esc_html(get_the_title()); ?>
            </span>
          </li>

        <?php
        }

        // Категория WooCommerce
        elseif (is_product_category()) {

          $term = get_queried_object(); ?>

          <li class="breadcrumbs__item">
            <span class="breadcrumbs__current">
              <?php echo esc_html($term->name); ?>
            </span>
          </li>

          <?php
        }

        // Пост
        elseif (is_single()) {

          $categories = get_the_category();

          if (!empty($categories)) {

            foreach ($categories as $cat) { ?>

              <li class="breadcrumbs__item">

                <a class="breadcrumbs__link" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                  <?php echo esc_html($cat->name); ?>
                  <span class="breadcrumbs__separator"><?php svg_arrown() ?></span>
                </a>

              </li>

          <?php }
          } ?>

          <li class="breadcrumbs__item">
            <span class="breadcrumbs__current">
              <?php echo esc_html(get_the_title()); ?>
            </span>
          </li>

        <?php
        }

        // Обычная страница
        elseif (is_page()) { ?>

          <li class="breadcrumbs__item">
            <span class="breadcrumbs__current">
              <?php echo esc_html(get_the_title()); ?>
            </span>
          </li>

        <?php } ?>

      </ul>

    </div>
  </div>

<?php
}
?>