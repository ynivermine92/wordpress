/* Корзина  */



/* Вызов мини корзины */
const cartToggle = () => {
  /* кнопка которая будет вызать корзину*/
  let cartBtm = document.querySelectorAll(".cart-user");

  let cart = document.querySelector(".cart__inner");
  let clouse = document.querySelector(".cart__clouse");
  let cartBlur = document.querySelector(".mini-cart");

  cartBtm.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      cart.classList.add("active");
      document.body.classList.add("locked");
      cartBlur.classList.add("active");
    });
  });
  clouse.addEventListener("click", () => {
    cart.classList.remove("active");
    document.body.classList.remove("locked");
    cartBlur.classList.remove("active");
  });
};

cartToggle();



/* аякс  */
async function cartAjax(productId, variationId, quantity, attributes = {}) {

  try {
    const params = new URLSearchParams();
    if (variationId === 'delete') {
      /* удаление из корзины */
      params.append("action", "cartRemove");
      params.append("cart_key", attributes.cart_key);
    } else {
      /* добавление  в корзину*/
      params.append("action", "cartAdd");

      /* добавление товара,варитивного или простого */
      if (variationId && variationId !== "0") {
        params.append("variation_id", variationId);
        Object.entries(attributes).forEach(([key, value]) => {
          if (value) params.append(key, value);
        });
      }
      /* манпуляции простым товаром корзине */
      if (attributes.cart_key) {
        params.append("cart_key", attributes.cart_key);

      }
    }
    params.append("nonce", my_ajax_obj.nonce);
    params.append("product_id", productId);
    params.append("quantity", quantity);



    const response = await fetch(my_ajax_obj.ajax_url, {
      method: "POST",
      body: params,
    });


    const result = await response.json();
    /* получаем ответ */
    console.log(result);


    if (result.success) {
      /* функции */
      updateCartUI(result.data.cart_items);
      updateCartCount(result.data.cart_count);
      cartPrice(result.data.cart_total);
    } else {
      console.error("❌ Ошибка сервера:", result);
    }

  } catch (err) {
    console.error(err);
  }
}





/* Собираем информацию по продукте  для добавления товара */
if (document.body.classList.contains("single-product")) {

  /* Добавить товар */
  const cartAdd = () => {
    const prodBtn = document.querySelectorAll(".single_add_to_cart_button");

    prodBtn.forEach((button) => {
      button.addEventListener("click", function (e) {

        e.preventDefault();

        const form = button.closest("form");
        /*  параметры по продукту */
        let productId = "0";
        let variationId = "0";
        let quantity = 1;
        let attributes = {};

        if (form.classList.contains("variations_form")) {
          variationId = form.querySelector('input[name="variation_id"]')?.value;
          productId = form.querySelector('input[name="product_id"]')?.value;

          if (variationId && variationId === "0") {
            return;
          }

          // 👇 СОБИРАЕМ АТРИБУТЫ
          form
            .querySelectorAll('select[name^="attribute_"]')
            .forEach((select) => {
              if (select.value) {
                attributes[select.name] = select.value;
              }
            });
        } else {


          productId = form.querySelector('input[name="add-to-cart"]')?.value;
        }

        // 👉 количество
        const quantityInput = form?.querySelector(".counter__input");

        if (quantityInput) {
          const val = parseInt(quantityInput.value);
          if (!isNaN(val) && val > 0) {
            quantity = val;
          }
        }

        // 👇 передаём attributes дальше


        cartAjax(productId, variationId, quantity, attributes);
      });
    });
  }
  cartAdd();











}

/* Отрисовка продукта в мини корзине по ответу  АЯКС*/
function updateCartUI(items) {
  console.log(items)
  const wrapper = document.querySelector(".cart__box-wrapper");

  if (!wrapper) return;

  let cartItemsContainer = wrapper.querySelector(".cart__items");
  let cartBtn = wrapper.querySelector(".cart__btn");
  let emptyMsg = wrapper.querySelector(".cart__empty");





  // ПУСТАЯ КОРЗИНА
  if (items.length === 0) {
    // удаляем список товаров
    if (cartItemsContainer) {
      cartItemsContainer.remove();
    }

    // удаляем кнопку
    if (cartBtn) {
      cartBtn.remove();
    }

    // если сообщения нет — создаём
    if (!emptyMsg) {
      const p = document.createElement("p");

      p.className = "cart__empty";
      p.textContent = "Поки що немає товару в магазині ...";

      wrapper.appendChild(p);
    }

    return;
  }

  // ЕСЛИ ТОВАРЫ ЕСТЬ
  // удаляем сообщение пустой корзины
  if (emptyMsg) {
    emptyMsg.remove();
  }

  // если контейнера нет — создаём
  if (!cartItemsContainer) {
    cartItemsContainer = document.createElement("ul");
    cartItemsContainer.className = "cart__items";

    wrapper.appendChild(cartItemsContainer);
  }

  // Получаем все текущие товары в DOM
  const existingItems = cartItemsContainer.querySelectorAll(".cart__item");

  // Создаём Set из актуальных id
  const currentIds = new Set(items.map(item => String(item.id)));

  // -----------------------------
  // УДАЛЯЕМ ТОВАРЫ КОТОРЫХ НЕТ
  // -----------------------------
  existingItems.forEach((el) => {
    const productId = el.dataset.productId;

    if (!currentIds.has(productId)) {
      el.remove();
    }
  });

  // -----------------------------
  // ДОБАВЛЯЕМ / ОБНОВЛЯЕМ
  // -----------------------------
  items.forEach((item) => {
    let itemEl = cartItemsContainer.querySelector(
      `[data-product-id="${item.id}"]`
    );

    // -----------------------------
    // ЕСЛИ ТОВАРА НЕТ — СОЗДАЁМ
    // -----------------------------
    if (!itemEl) {
      itemEl = document.createElement("li");

      itemEl.className = "cart__item";

      // 👇 прокидываем WooCommerce данные

      itemEl.dataset.cartKey = item.key;
      itemEl.dataset.productId = item.id;
      itemEl.dataset.variationId = item.variationId || 0;

      // 👇 Получаем вариацию товара если есть
      let variationsHtml = '';

      if (item.variation) {

        for (let key in item.variation) {

          variationsHtml += `
            <div class="mini-cart__variation">
              <span>${key.replace('attribute_pa_', '')}:</span>
              <span>${item.variation[key]}</span>
            </div>
          `;
        }

      }

      itemEl.innerHTML = `
        <div class="cart__box">
          <img class="cart__image" src="${item.image}" alt="${item.name}">

          <div class="cart__wrapper">
            <div class="cart__sub-title">${item.name}</div>

          <div class="mini-cart__variations" >
            ${variationsHtml}
         </div >
          

            

        <div class="mini-cart__counter" data-qty="${item.qty}"> 
      <button class="mini-cart__counter-btn minus" type="button">-</button>

      <input 
        class="mini-cart__counter-input"
        type="text"
        value="${item.qty}"
        maxlength="3"
      >

      <button class="mini-cart__counter-btn plus" type="button">+</button>
    </div>
        
      </div>

      <div class="cart__wrapper-inner">
        <div class="cart__price">${item.total}</div>

        <div class="cart__delete">
          Удалить
        </div>
      </div>
    </div>
  `;




      cartItemsContainer.appendChild(itemEl);

      return;
    }

    // -----------------------------
    // ОБНОВЛЯЕМ ТОЛЬКО ИЗМЕНЕНИЯ
    // -----------------------------

    // qty
    const qtyInput = itemEl.querySelector(".mini-cart__counter-input");

    if (qtyInput && qtyInput.value != item.qty) {
      qtyInput.value = item.qty;
    }

    // total
    const priceEl = itemEl.querySelector(".cart__price");

    if (priceEl && priceEl.innerHTML !== item.total) {
      priceEl.innerHTML = item.total;
    }

    // image
    const imageEl = itemEl.querySelector(".cart__image");

    if (imageEl && imageEl.src !== item.image) {
      imageEl.src = item.image;
    }

    // title
    const titleEl = itemEl.querySelector(".cart__sub-title");

    if (titleEl && titleEl.innerHTML !== item.name) {
      titleEl.innerHTML = item.name;
    }
  });

  // -----------------------------
  // КНОПКА ОФОРМЛЕНИЯ
  // -----------------------------
  if (!cartBtn) {
    cartBtn = document.createElement("div");

    cartBtn.className = "cart__btn";

    cartBtn.innerHTML = `
      <div class="cart__price">
        Загальна ціна:
        <span class="cart__price-currency"></span>
        <span class="cart__price-coin">₴</span>
      </div>

      <a class="cart__link" href="checkout.html">
        Оформить заказ
      </a>
    `;

    wrapper.appendChild(cartBtn);
  }
}




/* Удалить товар */
const cartRemove = () => {
  const cartContainer = document.querySelector(".cart__box-wrapper");
  if (!cartContainer) return;

  cartContainer.addEventListener("click", (e) => {

    const removeBtn = e.target.closest(".cart__delete");
    console.log(removeBtn);
    if (!removeBtn) return;

    const cartItem = removeBtn.closest(".cart__item");
    if (!cartItem) return;

    const cartKey = cartItem.dataset.cartKey;

    if (!cartKey) {
      console.error("❌ Нет cart_key");
      return;
    }

    cartItem.remove();


    cartAjax(0, 'delete', 0, { cart_key: cartKey });
  });
};

cartRemove();




/* select counter в мини корзине для изменения количества товра  акякс */
const cartWrapper = document.querySelector('.cart__box-wrapper');

if (cartWrapper) {

  let ajaxTimer = null;
  let inputTimer = null;
  let lastState = new Map(); // чтобы не дергать одинаковые значения

  function updateCart(item, quantity) {
    quantity = Math.max(1, quantity);

    const input = item.querySelector('.mini-cart__counter-input');
    if (input) input.value = quantity;

    const cartKey = item.dataset.cartKey;
    const productId = item.dataset.productId;
    const variationId = item.dataset.variationId;

    const stateKey = cartKey + ':' + quantity;

    // защита от дублей
    if (lastState.get(item) === stateKey) return;
    lastState.set(item, stateKey);

    clearTimeout(ajaxTimer);

    ajaxTimer = setTimeout(() => {
      cartAjax(productId, variationId, quantity, {
        cart_key: cartKey
      });
    }, 300);
  }

  /* CLICK + / - */
  cartWrapper.addEventListener('click', (e) => {
    const plusBtn = e.target.closest('.mini-cart__counter-btn.plus');
    const minusBtn = e.target.closest('.mini-cart__counter-btn.minus');

    if (!plusBtn && !minusBtn) return;

    const item = e.target.closest('.cart__item');
    if (!item) return;

    const input = item.querySelector('.mini-cart__counter-input');
    if (!input) return;

    let quantity = parseInt(input.value, 10) || 1;

    if (plusBtn) quantity++;
    if (minusBtn) quantity--;

    updateCart(item, quantity);
  });


  /* INPUT typing */
  cartWrapper.addEventListener('input', (e) => {
    const input = e.target.closest('.mini-cart__counter-input');
    if (!input) return;

    const item = input.closest('.cart__item');
    if (!item) return;

    clearTimeout(inputTimer);

    inputTimer = setTimeout(() => {
      let value = input.value.trim();

      if (value === '') value = 1;

      let quantity = parseInt(value, 10);
      if (isNaN(quantity) || quantity < 1) quantity = 1;

      updateCart(item, quantity);

    }, 1500);
  });

  /* blur fix */
  cartWrapper.addEventListener('blur', (e) => {
    const input = e.target.closest('.mini-cart__counter-input');
    if (!input) return;

    if (input.value.trim() === '') {
      input.value = 1;
    }
  }, true);
}

/* select counter end*/




/* Общая цена в корзине за все товары */
const cartPrice = (prace) => {
  let cartPrace = document.querySelector(".cart__price-currency");
  cartPrace.textContent = prace;
};

// === Обновление счётчика корзинны Хедере ===
function updateCartCount(count) {
  const cartCount = document.querySelectorAll(".cart__quantity-product");
  if (cartCount) {
    cartCount.forEach((item) => {
      item.textContent = count;
      item.classList.add("cart-updated");
      // Немного анимации для UX
      setTimeout(() => item.classList.remove("cart-updated"), 500);
    });
  }
}