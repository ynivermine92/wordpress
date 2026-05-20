
/* 

Вставить в функцию аякс корзины , мои функции на оформления заказа что бы получить обьект ответа 
передать по функциям что бы через аякс отрисовать продукт в формлении заказа 
Эта функция у меня есть кастоной разработки корзины(мини)


мои функции которые нужно ставить 
checkout(result.data.cart_items);
checkoutPrice(result.data.cart_total); 













/* Отрисовка аякс */

const checkout = (items) => {



    const basketItems = document.querySelector('.basket__items');

    if (!basketItems) return;

    // ✅ текущие cart keys
    const currentKeys = items.map(item => item.key);

    // ✅ удаляем товары которых больше нет
    document.querySelectorAll('.basket__item').forEach((element) => {

        const cartKey = element.dataset.cartKey;

        if (!currentKeys.includes(cartKey)) {
            element.remove();
        }
    });

    // ✅ обновляем / создаём
    items.forEach((item) => {

        const variations = Object.entries(item.variation || {})
            .map(([key, value]) => `
        <div class="mini-cart__variation">
          <span>${key.replace('attribute_pa_', '')}:</span>
          <span>${value}</span>
        </div>
      `)
            .join('');

        const html = `
      <div class="basket__box">

        <a href="#">
          <img 
            class="basket__image" 
            src="${item.image}" 
            alt="${item.name}"
          >
        </a>

        <div class="basket__wrapper">

          <div class="basket__sub-title">
            ${item.name}
          </div>

          <div class="mini-cart__variations">
            ${variations}
          </div>

          <div class="basket__wrapper-inner">

            <div class="basket__content-inner">

              <div class="basket__quantity">
                <span>Кількість :</span> ${item.qty}
              </div>

              <div class="basket__prace__wrapper">
                <div class="basket__prace">
                  ${item.total}
                </div>
              </div>

            </div>

          </div>

        </div>

      </div>
    `;

        // ✅ поиск по cart key
        const existingItem = document.querySelector(
            `.basket__item[data-cart-key="${item.key}"]`
        );

        // ✅ обновляем
        if (existingItem) {

            existingItem.innerHTML = html;

        } else {

            // ✅ создаём
            const li = document.createElement('li');

            li.className = 'basket__item cart__item';
            li.dataset.cartKey = item.key;
            li.innerHTML = html;

            basketItems.appendChild(li);
        }
    });
};

/* Общая цена в корзине за все товары */
const checkoutPrice = (price) => {
    let checkoutPrice = document.querySelectorAll(".checkout__price-currency");

    checkoutPrice.forEach((item) => {
        item.textContent = price;
    });
    disableFormCheckout(price)
};






/* Если корзине нету продукта тогда ридирект на каталог перекидывет */

const summaryProductRidirect = () => {

    const basket = document.querySelector('.summary');

    if (!basket) return;

    const checkBasket = () => {
        const items = document.querySelectorAll('.basket__item');

        if (items.length === 0) {
            window.location.href = 'сategory/';
        }
    };

    checkBasket();

    const observer = new MutationObserver(() => {
        checkBasket();
    });

    observer.observe(basket, {
        childList: true,
        subtree: true
    });
};

summaryProductRidirect();