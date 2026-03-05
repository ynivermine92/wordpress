

<?


// AJAX обработчик добавления товара

function ajaxCart()
{
    check_ajax_referer('my_ajax_nonce', 'nonce');

    $product_id = intval($_POST['product_id']);
    $quantity   = intval($_POST['quantity']);
    $type       = sanitize_text_field($_POST['type']); // ← теперь тип действия

    if ($product_id <= 0) {
        wp_send_json_error('Ошибка обработки товара');
    }

    if ($type === 'add') {

        WC()->cart->add_to_cart($product_id, max(1, $quantity));
    } else {

        // Удаление товара полностью
        if ($type === 'remove') {
            foreach (WC()->cart->get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    WC()->cart->remove_cart_item($key);
                    break;
                }
            }
        }

        // Добавление через "+"
        if ($type === 'addSelect') {
            $found = false;
            foreach (WC()->cart->get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    WC()->cart->set_quantity($key, $item['quantity'] + max(1, $quantity));
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                WC()->cart->add_to_cart($product_id, max(1, $quantity));
            }
        }

        // Уменьшение через "-"
        if ($type === 'removeSelect') {
            foreach (WC()->cart->get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    $new_qty = max(1, $item['quantity'] - $quantity);
                    WC()->cart->set_quantity($key, $new_qty);
                    break;
                }
            }
        }

        // Добавление всех (например, при выборе всех товаров)
        if ($type === 'allSelect') {
            $found = false;

            foreach (WC()->cart->get_cart() as $key => $item) {
                if ($item['product_id'] == $product_id) {
                    // 🔁 Перезаписываем количество на то, что пришло из input
                    WC()->cart->set_quantity($key, max(1, $quantity));
                    $found = true;
                    break;
                }
            }
        }
    }


    // Формируем ответ
    $cart_items = [];
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $cart_items[] = [
            'id'    => $product->get_id(),
            'name'  => $product->get_name(),
            'qty'   => $cart_item['quantity'],
            'price' => wc_price($product->get_price()),
            'total' => wc_price($product->get_price() * $cart_item['quantity']),
            'image' => wp_get_attachment_image_url($product->get_image_id(), 'thumbnail')
        ];
    }

    wp_send_json_success([
        'cart_items' => $cart_items,
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'cart_total' => WC()->cart->total
    ]);
}


// --------------------------
// 4. Регистрация AJAX действий
// --------------------------
add_action('wp_ajax_ajaxCart', 'ajaxCart');
add_action('wp_ajax_nopriv_ajaxCart', 'ajaxCart');
