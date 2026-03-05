  /* аякс  */
  async function CartAjax(productId, type, quantity = 1) {
    try {
      const response = await fetch(my_ajax_obj.ajaxurl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: `action=ajaxCart&nonce=${my_ajax_obj.nonce}&product_id=${productId}&quantity=${quantity}&type=${type}`
      });

      const result = await response.json();
      const { success, data } = result;

      if (success) {
        updateCartUI(data.cart_items);
        updateCartCount(data.cart_count);
        cartPrice(data.cart_total);
      } else {
        console.error(`❌ Ошибка при ${type}`);
      }
    } catch (err) {
      console.error('Ошибка fetch:', err);
    }
  }



  // === Обновление счётчика корзинны ===
  function updateCartCount(count) {
    const cartCount = document.querySelectorAll('.sidebar__cart-sum');
    if (cartCount) {
      cartCount.forEach((item) => {

        item.textContent = count;
        item.classList.add('cart-updated');
        // Немного анимации для UX
        setTimeout(() => item.classList.remove('cart-updated'), 500);
      })



    }
  }


  /* Добавление товара в корзину там где карточка товара  */
  if (document.body.classList.contains("single-product")) {

    const productButtons = document.querySelectorAll('.slider-product__btn');
    productButtons.forEach((button) => {
      button.addEventListener('click', function (e) {
        e.preventDefault();

        // Берём ID товара из value кнопки
        const productId = button.value;
        if (!productId) return;

        // Находим форму вокруг кнопки
        const form = button.closest('form.slider-product__select');

        // Находим input с количеством рядом с кнопкой
        let quantity = 1; // значение по умолчанию
        if (form) {
          const quantityInput = form.querySelector('.counter__input');
          if (quantityInput) {
            const val = parseInt(quantityInput.value);
            if (!isNaN(val) && val > 0) {
              quantity = val;
            }
          }
        }

        // Вызываем AJAX, передавая ID и количество
        CartAjax(productId, 'addSelect', quantity);
      });
    });
  }



  /* ДОбавление корзину там где категории (отуда сразу доабвить корзину товар) */
  if (document.body.classList.contains("woocommerce-shop")) {
    const categoriesSection = document.querySelector('.categories');
    categoriesSection.addEventListener('click', function (e) {

      const link = e.target.closest('.categories__link');
      if (!link) return;

      e.preventDefault();
      const match = link.href.match(/add-to-cart=(\d+)/);

      if (match) CartAjax(match[1], 'addSelect');
    });
  }



  /* Отрисовка корзинны когда приходит ответ от АЯКС*/
  function updateCartUI(items) {

    const wrapper = document.querySelector('.cart__box-wrapper');
    if (!wrapper) return;

    // Удаляем старую корзину и сообщение о пустой корзине
    let cartItemsContainer = wrapper.querySelector('.cart__items');
    if (cartItemsContainer) cartItemsContainer.remove();

    const emptyMsg = wrapper.querySelector('.cart__empty');
    if (emptyMsg) emptyMsg.remove();

    const oldBtn = wrapper.querySelector('.cart__btn');
    if (oldBtn) oldBtn.remove();

    if (items.length === 0) {
      // Если товаров нет — показываем сообщение
      const p = document.createElement('p');
      p.className = 'cart__empty';
      p.textContent = 'Поки що немає товару в магазині ...';
      wrapper.appendChild(p);
      return;
    }

    // Создаём контейнер для товаров
    cartItemsContainer = document.createElement('ul');
    cartItemsContainer.className = 'cart__items';
    wrapper.appendChild(cartItemsContainer);

    items.forEach(item => {
      const li = document.createElement('li');
      li.className = 'cart__item';
      li.dataset.productId = item.id;
      li.innerHTML = `
      <div class="cart__box">
        <img class="cart__image" src="${item.image}" alt="${item.name}">
        <div class="cart__wrapper">
          <div class="cart__sub-title">${item.name}</div>
          <div class="counter"> 
            <button class="counter__btn minus" type="button"></button>
                         <input class="counter__input cart-counter__input" type="text" value="${item.qty}" maxlength="3">
            <button class="counter__btn plus" type="button"></button>
          </div>
        </div>
        <div class="cart__wrapper-inner">
          <div class="cart__price">${item.total}</div>
          <div class="cart__delete">Удалить</div>
        </div>
      </div>
    `;
      cartItemsContainer.appendChild(li);
    });


    // Добавляем кнопку "Оформить заказ"


    // Создаём общий блок для цены и кнопки
    const btnDiv = document.createElement('div');
    btnDiv.className = 'cart__btn';

    // Вставляем HTML для цены и кнопки
    btnDiv.innerHTML = `
  <div class="cart__price">
    Загальна ціна: <span class="cart__price-currency"></span> 
    <span class="cart__price-coin">₴</span>
  </div>
  <a class="cart__link" href="checkout.html">Оформить заказ</a>
`;

    // Добавляем блок в контейнер
    wrapper.appendChild(btnDiv);


  }


  /* Удаление товара из корзины */
  function cartRemove() {
    const cartContainer = document.querySelector('.cart__box-wrapper'); // общий контейнер с товарами

    if (!cartContainer) return;

    cartContainer.addEventListener('click', (e) => {
      const removeBtn = e.target.closest('.cart__delete'); // проверяем клик по кнопке "Удалить"
      if (!removeBtn) return;

      const cartItem = removeBtn.closest('.cart__item'); // ищем родительский элемент товара
      if (!cartItem) return;

      const productId = cartItem.dataset.productId; // получаем ID товара
      if (!productId) {
        console.error('❌ Нет productId у cart__item');
        return;
      }

      // Удаляем товар визуально
      cartItem.remove();

      // Отправляем AJAX-запрос на сервер

      CartAjax(productId, 'remove');
    });
  }

  cartRemove();




  /* select counter */

  function updateCounter(input) {
    let val = parseInt(input.value);
    if (isNaN(val) || val < 1) {
      val = 1;
    } else if (val > 999) {
      val = 999;
    }
    input.value = val;

    const counter = input.closest(".counter");
    const minusBtn = counter.querySelector(".minus");
    const plusBtn = counter.querySelector(".plus");

    if (val <= 1) {
      minusBtn.classList.add("disabled");
    } else {
      minusBtn.classList.remove("disabled");
    }

    if (val >= 999) {
      plusBtn.classList.add("disabled");
    } else {
      plusBtn.classList.remove("disabled");
    }
  }


  let clickTimeout;
  let counterChanges = {}; // хранит сколько раз изменили каждый товар

  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".counter__btn");
    if (!btn) return;

    const counter = btn.closest(".counter");
    const input = counter.querySelector(".counter__input");
    const cartItem = btn.closest(".cart__item");
    const productId = cartItem ? cartItem.dataset.productId : btn.dataset.productId;

    let val = parseInt(input.value);
    if (isNaN(val)) val = 1;

    if (!counterChanges[productId]) counterChanges[productId] = 0;

    if (btn.classList.contains("plus") && val < 999) {
      input.value = val + 1;
      counterChanges[productId] += 1; // увеличиваем счетчик
    }

    if (btn.classList.contains("minus") && val > 1) {
      input.value = val - 1;
      counterChanges[productId] -= 1; // уменьшаем счетчик
    }

    // Сбрасываем таймер и ставим новый на 1 секунду
    clearTimeout(clickTimeout);
    clickTimeout = setTimeout(() => {
      // Отправляем суммарные изменения через AJAX
      for (const id in counterChanges) {
        if (counterChanges[id] !== 0) {
          console.log(counterChanges)
          CartAjax(id, counterChanges[id] > 0 ? 'addSelect' : 'removeSelect', Math.abs(counterChanges[id]));

        }
      }
      // Сбрасываем счетчик после отправки
      counterChanges = {};
    }, 1000);
  });

  // Ручной ввод импут 

  // создаём объект для хранения таймеров по productId
  const debounceTimers = {};

  document.addEventListener("input", function (e) {
    if (!e.target.classList.contains("cart-counter__input")) return;

    updateCounter(e.target);

    const cartItem = e.target.closest(".cart__item");
    const productId = cartItem ? cartItem.dataset.productId : e.target.dataset.productId;
    if (!productId) return;

    let quantity = parseInt(e.target.value);
    if (isNaN(quantity) || quantity < 1) quantity = 1;

    // Сбрасываем предыдущий таймер
    if (debounceTimers[productId]) clearTimeout(debounceTimers[productId]);

    // Ставим новый таймер на 0.5 секунды
    debounceTimers[productId] = setTimeout(() => {
      CartAjax(productId, 'allSelect', quantity);
      delete debounceTimers[productId];
    }, 1000); // 500ms = полсекунды
  });






/* Общая цена корзинны получаю цену из аякс */
const cartPrice = (prace) =>{
  let cartPrace = document.querySelector('.cart__price-currency');
  cartPrace.textContent = prace;
}

