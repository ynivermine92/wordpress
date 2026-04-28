<?php
/* variation */

/* select добавить класс */
add_filter('woocommerce_dropdown_variation_attribute_options_args', function ($args) {

    if (!empty($args['class'])) {
        $args['class'] .= ' variations__select';
    } else {
        $args['class'] = 'variations__select';
    }

    return $args;
});



/* costom: count,  btn */
remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
add_action('woocommerce_single_variation', 'couter_variation', 20);

function couter_variation()
{
    global $product;

    if (!$product) return;
?>



    <div class="woocommerce-variation-add-to-cart variations_button">

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

        <!-- REQUIRED HIDDEN INPUTS -->
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
        <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">
        <input type="hidden" name="variation_id" class="variation_id" value="0">

    </div>

<?php
}
