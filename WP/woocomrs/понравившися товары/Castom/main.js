
  const wishlis = () => {

    /* нажатия на лайк */
    document.addEventListener('click', function (e) {
      let btn = e.target.closest('.product-item__link-heart');
      if (!btn) return;

      e.preventDefault();
      const productId = Number(btn.dataset.id);

      if (btn.classList.contains('active')) {
        loadWishlist(productId, 0); // удалить
      } else {
        loadWishlist(productId, 1); // добавить
      }
    });




    /* получаю масив с карточками, и записываю длену масива count  лайков */
    function updateWishlistCounter(wishlist) {
      const countItems = document.querySelectorAll('.user-nav__like');
      const resultCount = wishlist.length;

      countItems.forEach(item => {
        item.textContent = resultCount;
      });
    }


    /* поиск нажатого сердечка по дата атрубиту*/
    const sershWisth = (ids) => {

      let wisthHard = document.querySelectorAll('.product-item__link-heart');

      wisthHard.forEach((item) => {
        let itemData = Number(item.dataset.id);
        if (ids.includes(itemData)) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }


      })

    }



    let ids = []; // глобальный массив wishlist
    let container = document.getElementById("wishlist-container");
    let wishlistLoaded = false;



    // Get Получаем
    async function fetchWishlistFromDB() {
      try {
        const response = await fetch('/wp-json/wishlist/v1/wishlist', {
          method: 'GET',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce
          }
        });

        if (response.status === 401) {
          console.log('Пожалуйста, войдите в аккаунт');
          return [];
        }
        const data = await response.json();
        const wishlist = data.products || [];

        ids = wishlist.map(item => item.id);


        sershWisth(ids);

        /* hardCount */
        updateWishlistCounter(wishlist);

        if (!container) return;
        if (wishlist.length > 0) {
          renderWishlist(wishlist);
        } else {
          container.innerHTML = "<p>Вы ещё не добавили товары в избранное.</p>";
        }
        wishlistLoaded = true
      } catch (err) {
        console.error('Ошибка при получении wishlist:', err);
        return [];
      }
    }



    /* Post Отправляем */
    async function loadWishlist(productId = 0, user = 0) {
      debugger;
      if (productId > 0 && user === 1) {
        if (!ids.includes(productId)) ids.push(productId);
      }

      if (productId !== 0 && user === 0) {
        ids = ids.filter(id => id !== productId);
      }

      try {
        const response = await fetch('/wp-json/wishlist/v1/wishlist', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': wpApiSettings.nonce
          },
          body: JSON.stringify({ wishlist: ids }),
        });

        if (user === 1 && response.status === 401) {
          alert('Пожалуйста, войдите в аккаунт.');
          return;
        }

        const data = await response.json();
        const wishlist = data.products || [];

        ids = wishlist.map(item => item.id);

        sershWisth(ids);
        updateWishlistCounter(wishlist);

        if (!container) return;

        if (wishlist.length > 0) {
          renderWishlist(wishlist);
        } else {
          container.innerHTML = "<p>Вы ещё не добавили товары в избранное.</p>";
        }

      } catch (err) {
        console.error(err);
        container.innerHTML = "<p>Ошибка при загрузке списка избранного.</p>";
      }
    }



    /* отрисовка карточки */

    function renderWishlist(products) {

      container.innerHTML = '';
      products.forEach(product => {
        const item = document.createElement('div');
        item.className = 'wishlist__item';
        item.innerHTML = `
        <a href="${product.link}" class="wishlist__item-link">
          ${product.image}
          <span class="wishlist__item-remove" data-id="${product.id}">X</span>
          <h3 class="wishlist__item-title">${product.title}</h3>
        </a>
        <div class="wishlist__item-price">${product.price}</div>
        <button class="wishlist__item-add" data-id="${product.id}">добавить корзину</button>
      `;
        container.appendChild(item);
      });

      removeWishlistItems();
    }

    /* удаление карточки */

    function removeWishlistItems() {
      const removeButtons = document.querySelectorAll('.wishlist__item-remove');
      removeButtons.forEach(btn => {
        btn.addEventListener("click", e => {
          e.preventDefault();
          const id = Number(btn.dataset.id);

          loadWishlist(id, user = 0);

        });
      });
    }




    if (wishlistLoaded !== true) {
      fetchWishlistFromDB();

    }


    /*   loadWishlist(); */
  }


  wishlis()