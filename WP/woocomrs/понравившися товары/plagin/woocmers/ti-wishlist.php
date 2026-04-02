<?php

/**
 * The Template for displaying wishlist if a current user is owner.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist.php.
 *
 * @version             2.3.3
 * @package           TInvWishlist\Template
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script('tinvwl');
?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear">
    <?php do_action('tinvwl_before_wishlist', $wishlist); ?>
    <?php if (function_exists('wc_print_notices') && isset(WC()->session)) wc_print_notices(); ?>

    <?php $form_url = tinv_url_wishlist($wishlist['share_key'], $wl_paged, true); ?>
    <form action="<?php echo esc_url($form_url); ?>" method="post" autocomplete="off"
          data-tinvwl_paged="<?php echo $wl_paged; ?>"
          data-tinvwl_per_page="<?php echo $wl_per_page; ?>"
          data-tinvwl_sharekey="<?php echo $wishlist['share_key']; ?>"
          class="tinvwl-wishlist-form">

        <?php do_action('tinvwl_before_wishlist_table', $wishlist); ?>

        <div class="row wishlist-wrapper">
            <?php do_action('tinvwl_wishlist_contents_before'); ?>

            <?php
            global $product, $post;
            $_product_tmp = $product;
            $_post_tmp = $post;

            foreach ($products as $wl_product) {
                if (empty($wl_product['data'])) continue;

                $product = apply_filters('tinvwl_wishlist_item', $wl_product['data']);
                $post = get_post($product->get_id());
                unset($wl_product['data']);

                if ($wl_product['quantity'] > 0 && apply_filters('tinvwl_wishlist_item_visible', true, $wl_product, $product)) {
                    $product_url = apply_filters('tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product);
                    do_action('tinvwl_wishlist_row_before', $wl_product, $product);
            ?>
                    <div class="col-3 <?php echo esc_attr(apply_filters('tinvwl_wishlist_item_class', $wl_product, $product)); ?>">
                        <div class="wishlist_item wishlist-card">
                            <!-- Checkbox -->
                            <?php if (!empty($wishlist_table['colm_checkbox'])): ?>
                                <div class="wishlist-col wishlist-checkbox col-auto">
                                    <?php
                                    echo apply_filters('tinvwl_wishlist_item_cb', sprintf(
                                        '<input type="checkbox" name="wishlist_pr[]" class="input-checkbox" value="%d" title="%s">',
                                        esc_attr($wl_product['ID']),
                                        __('Select for bulk action', 'ti-woocommerce-wishlist')
                                    ), $wl_product, $product);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Remove -->
                            <div class="wishlist-col wishlist-remove col-auto">
                                <button type="submit" name="tinvwl-remove" value="<?php echo esc_attr($wl_product['ID']); ?>"
                                        title="<?php _e('Remove', 'ti-woocommerce-wishlist'); ?>">
                                    <i class="ftinvwl ftinvwl-times"></i>
                                </button>
                            </div>

                            <!-- Thumbnail -->
                            <div class="wishlist-col wishlist-thumbnail col-auto">
                                <?php
                                $thumbnail = apply_filters('tinvwl_wishlist_item_thumbnail', $product->get_image(), $wl_product, $product);
                                if (!$product->is_visible()) {
                                    echo $thumbnail;
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_url), $thumbnail);
                                }
                                ?>
                            </div>

                            <!-- Product Name & Meta -->
                            <div class="wishlist-col wishlist-name col">
                                <?php
                                if (!$product->is_visible()) {
                                    echo apply_filters('tinvwl_wishlist_item_name', $product->get_name(), $wl_product, $product);
                                } else {
                                    echo apply_filters('tinvwl_wishlist_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_url), $product->get_name()), $wl_product, $product);
                                }
                                echo apply_filters('tinvwl_wishlist_item_meta_data', tinv_wishlist_get_item_data($product, $wl_product), $wl_product, $product);
                                ?>
                            </div>

                            <!-- Price -->
                            <?php if (!empty($wishlist_table_row['colm_price'])): ?>
                                <div class="wishlist-col wishlist-price col-auto">
                                    <?php echo apply_filters('tinvwl_wishlist_item_price', $product->get_price_html(), $wl_product, $product); ?>
                                </div>
                            <?php endif; ?>

                            <!-- Stock -->
                            <?php if (!empty($wishlist_table_row['colm_stock'])): ?>
                                <div class="wishlist-col wishlist-stock col-auto">
                                    <?php
                                    $availability = (array)$product->get_availability();
                                    $availability['availability'] = $availability['availability'] ?? '';
                                    $availability['class'] = $availability['class'] ?? '';
                                    $availability_html = empty($availability['availability'])
                                        ? '<p class="stock ' . esc_attr($availability['class']) . '"><i class="ftinvwl ftinvwl-check"></i> In stock</p>'
                                        : '<p class="stock ' . esc_attr($availability['class']) . '">' . esc_html($availability['availability']) . '</p>';
                                    echo apply_filters('tinvwl_wishlist_item_status', $availability_html, $availability['availability'], $wl_product, $product);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!-- Add to Cart -->
                            <?php if (!empty($wishlist_table_row['add_to_cart'])): ?>
                                <div class="wishlist-col wishlist-action col-auto">
                                    <?php
                                    if (apply_filters('tinvwl_wishlist_item_action_add_to_cart', $wishlist_table_row['add_to_cart'], $wl_product, $product)) {
                                        ?>
                                        <button class="button alt" name="tinvwl-add-to-cart" value="<?php echo esc_attr($wl_product['ID']); ?>"
                                                title="<?php echo esc_html(apply_filters('tinvwl_wishlist_item_add_to_cart', $wishlist_table_row['text_add_to_cart'], $wl_product, $product)); ?>">
                                            <i class="ftinvwl ftinvwl-shopping-cart"></i>
                                            <span><?php echo wp_kses_post(apply_filters('tinvwl_wishlist_item_add_to_cart', $wishlist_table_row['text_add_to_cart'], $wl_product, $product)); ?></span>
                                        </button>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
            <?php
                    do_action('tinvwl_wishlist_row_after', $wl_product, $product);
                } // End if visible
            } // End foreach

            $product = $_product_tmp;
            $post = $_post_tmp;
            ?>
            <?php do_action('tinvwl_wishlist_contents_after'); ?>
        </div>

        <div class="wishlist-footer">
            <?php do_action('tinvwl_after_wishlist_table', $wishlist); ?>
            <?php wp_nonce_field('tinvwl_wishlist_owner', 'wishlist_nonce'); ?>
        </div>
    </form>

    <?php do_action('tinvwl_after_wishlist', $wishlist); ?>
    <div class="tinv-lists-nav tinv-wishlist-clear">
        <?php do_action('tinvwl_pagenation_wishlist', $wishlist); ?>
    </div>
</div>


