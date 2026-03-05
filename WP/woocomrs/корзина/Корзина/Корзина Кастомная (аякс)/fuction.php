Корзина общая
<?

function cart()
{
    // Форсуємо ініціалізацію сесії та корзини
    if (null === WC()->session) {
        WC()->session = new WC_Session_Handler();
        WC()->session->init();
    }

    if (null === WC()->cart) {
        WC()->cart = new WC_Cart();
    }

    // Форсуємо оновлення кошика
    WC()->cart->get_cart();

    $items = WC()->cart->get_cart();

?>

    <div class="cart">
        <div class="cart__inner">
            <div class="cart__box">
                <h4 class="cart__title">Ваш кошик</h4>
                <div class="cart__clouse"><img src="<?= get_template_directory_uri(); ?>/assets/img/cart/clouse.png" alt="" /></div>
            </div>
            <div class="cart__box-wrapper">

                <?php if (! empty($items)) : ?>
                    <ul class="cart__items">
                        <?php foreach ($items as $cart_item_key => $cart_item) :
                            $product = $cart_item['data'];
                        ?>
                            <li class="cart__item" data-product-id="<?= esc_attr($product->get_id()); ?>">
                                <div class="cart__box">
                                    <img class="cart__image"
                                        src="<?= esc_url(wp_get_attachment_image_url($product->get_image_id(), 'thumbnail')); ?>"
                                        alt="<?= esc_attr($product->get_name()); ?>" />
                                    <div class="cart__wrapper">
                                        <div class="cart__sub-title"><?= esc_html($product->get_name()); ?></div>
                                        <div class="counter" data-qty="<?= esc_attr($cart_item['quantity']); ?>">
                                            <button class="counter__btn minus" type="button"></button>
                                            <input class="counter__input cart-counter__input" type="text" value="<?= esc_attr($cart_item['quantity']); ?>" maxlength="3">
                                            <button class="counter__btn plus" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="cart__wrapper-inner">
                                        <div class="cart__price">
                                            <?= wc_price($cart_item['line_total']); ?>
                                        </div>
                                        <div class="cart__delete">Видалити</div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="cart__btn">
                        <div class="cart__price">
                            Загальна ціна:
                            <span class="cart__price-currency"><?= wc_price(WC()->cart->get_cart_contents_total()); ?></span>
                        </div>
                        <a class="cart__link" href="/checkout/">Оформити замовлення</a>
                    </div>

                <?php else : ?>
                    <p class="cart__empty">Поки що немає товару в магазині ...</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php
}
