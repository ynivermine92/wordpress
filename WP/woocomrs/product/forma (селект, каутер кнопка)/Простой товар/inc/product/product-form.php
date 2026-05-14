<?php

/* простой товар */

remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
add_action('woocommerce_simple_add_to_cart', 'couter_simple', 30);



function couter_simple()
{
    global $product;

    if (!$product || !$product->is_type('simple')) return;
?>

    <form class="cart" method="post" enctype="multipart/form-data">

        <div class="cout__sum">
            <span class="cout__product-sum cout__simple-sum">0</span>
            <span class="cout__product-currency">
                <?php echo get_woocommerce_currency_symbol(); ?>
            </span>
        </div>

        <div class="woocommerce-simple-add-to-cart">

            <!-- COUNTER -->
            <div class="counter">
                <button type="button" class="counter__btn minus">-</button>

                <input type="number"
                    class="counter__input qty"
                    name="quantity"
                    value="1"
                    min="1"
                    step="1">

                <button type="button" class="counter__btn plus">+</button>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="single_add_to_cart_button button alt">
                В корзину
            </button>

            <!-- REQUIRED -->
            <input type="hidden"
                name="add-to-cart"
                value="<?php echo esc_attr($product->get_id()); ?>">

        </div>

    </form>

<?php
}
