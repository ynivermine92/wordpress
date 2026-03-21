  const wishlis = () => {

    /* кнопка wishlis */
    const heartButtons = document.querySelectorAll(".product-item__link-heart");
    heartButtons.forEach(function (btn) {
      btn.addEventListener("click", function (e) {
   
        e.preventDefault();
        const productId = Number(btn.dataset.id);
        localHartd(productId);
      });
    });



    /* кнопка сохраняем  атрубут кнопки локал  сторедж */
    function localHartd(productId) {
      if (!productId) return;

      let favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];

      if (!favorites.includes(productId)) {
        favorites.push(productId);
        localStorage.setItem("wishlist_ids", JSON.stringify(favorites));
        alert("Товар добавлен в избранное!");
      } else {
        alert("Этот товар уже в избранном.");
      }

      updateWishlistCounter();
    }


    /* количество Лайков*/
    function updateWishlistCounter() {
      const favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];
      document.querySelectorAll('.user-nav__like').forEach(counter => {
        counter.textContent = favorites.length;
      });
    }
    updateWishlistCounter();



    /* количество Ajax отрисовка*/
    const wishlisAjax = () => {




      const container = document.getElementById("wishlist-container");
      let favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];

      if (favorites.length === 0) {
        container.innerHTML = "<p>Вы ещё не добавили товары в избранное.</p>";
      } else {
        loadWishlist();
      }

      // Загрузка данных через REST API
      async function loadWishlist() {

        const wishlist = JSON.parse(localStorage.getItem("wishlist_ids")) || [];

        try {
          const response = await fetch('/wp-json/wishlist/v1/filter', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ wishlist: wishlist.join(',') })
          });

          const result = await response.json();

          if (result.products && result.products.length > 0) {
          
            renderWishlist(result.products); // вызываем функцию отрисовки
          } else {
            container.innerHTML = "<p>Товары не найдены.</p>";
          }

        } catch (err) {
          console.error(err);
          container.innerHTML = "<p>Ошибка при загрузке списка избранного.</p>";
        }
      }




      // Функция отрисовки товаров
      function renderWishlist(products) {
        container.innerHTML = ''; // очищаем контейнер перед вставкой

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
        removeWishlisItem()
      }





        /* удаляение товра */
      const removeWishlisItem = () => {
        const wishlisRemove = document.querySelectorAll('.wishlist__item-remove');

        wishlisRemove.forEach((item) => {
          item.addEventListener("click", (e) => {

            e.preventDefault();
            const id = Number(e.target.dataset.id); // ✅ приводим к числу
            if (!id) return;

            let favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];
            favorites = favorites.filter(favId => favId !== id);
            localStorage.setItem("wishlist_ids", JSON.stringify(favorites));
            loadWishlist(); // перерисовка списка

            /* обновляю общее количество товара  */
            updateWishlistCounter();
          });
        });
      }


    }


    wishlisAjax()


  }
  wishlis()
