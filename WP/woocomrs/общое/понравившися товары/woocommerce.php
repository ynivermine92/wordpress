<?

function get_wishlist_products_callback()
{
    if (empty($_POST['ids'])) {
        echo "<p>Нет избранных товаров.</p>";
        wp_die();
    }

    $ids = explode(',', sanitize_text_field($_POST['ids']));
    $ids = array_map('intval', $ids);

    $args = array(
        'post_type' => 'product',
        'post__in' => $ids,
        'posts_per_page' => -1,
        'orderby' => 'post__in' // чтобы сохранить порядок
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
?>
            <div class="wishlist__item">
                <a href="<?php the_permalink(); ?>" class="wishlist__item-link">
                    <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'wishlist__item-img']); ?>
                    <h3 class="wishlist__item-title"><?php the_title(); ?></h3>
                </a>
                <div class="wishlist__item-price"><?php echo $product->get_price_html(); ?></div>
                <button class="wishlist__item-remove" data-id="<?php echo get_the_ID(); ?>">Удалить из списка</button>
            </div>
<?php
        }
        wp_reset_postdata();
    } else {
        echo "<p>Товары не найдены.</p>";
    }

    wp_die();
}
