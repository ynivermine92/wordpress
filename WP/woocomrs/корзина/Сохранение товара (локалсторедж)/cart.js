    // Отслеживаем события добавления в корзину (через делегирование)
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('add_to_cart_button')) {
            setTimeout(saveCartToLocalStorage, 500); // подождать, пока WooCommerce обновит корзину
        }
    });

    // Сохраняем корзину в localStorage
    function saveCartToLocalStorage() {
        const cartForm = document.querySelector('form.woocommerce-cart-form');
        if (cartForm) {
            const formData = new FormData(cartForm);
            const serializedData = new URLSearchParams(formData).toString();
            localStorage.setItem('savedCart', serializedData);
            console.log('Корзина сохранена:', serializedData);
        }
    }

    // При загрузке — попытка восстановить корзину
    const savedCart = localStorage.getItem('savedCart');
    if (savedCart) {
        console.log('Сохранённые данные корзины:', savedCart);
        // ТУТ можно сделать восстановление корзины через AJAX-запрос к серверу
    }



});