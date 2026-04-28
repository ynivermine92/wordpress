

const wishlis = () => {

    const container = document.getElementById("wishlist-container");
    const heartButtons = document.querySelectorAll(".product-item__link-heart");


    /*  Получаю айди кнопки , и парамет передаю 1 ( что нажал на лайк на карточке)*/
    heartButtons.forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            const productId = Number(btn.dataset.id);
            loadWishlist(productId, user = 1);
        });
    });


    /* получаю масив с карточками, и записываю длену масива count  лайков */
    function updateWishlistCounter(wishlist) {
        const countItems = document.querySelectorAll('.user-nav__like');
        const resultCount = wishlist.length;

        countItems.forEach(item => {
            item.textContent = resultCount;
        });
    }


    let ids = [];


    /* Аякс */
    async function loadWishlist(productId = 0, user = 0) {


        if (ids.includes('defaultSlug') && ids.length >= 1) {
            ids.forEach((item, index) => {
                if (item === 'defaultSlug') {
                    ids.splice(index, 1)
                }
            })
        }



        if (productId > 0 && user === 1) {
            if (!ids.includes(productId)) ids.push(productId);
        }



        if (productId !== 0 && user === 0) {
            ids = ids.filter(id => id !== productId);
        }



        if (productId === 0 && user === 0) {
            ids.push('defaultSlug');
        }



        try {
            const response = await fetch('/wp-json/wishlist/v1/wishlist', {
                method: 'POST',
                credentials: 'include',
                headers: {

                    'Content-Type': 'application/json',
                    'X-WP-Nonce': wpApiSettings.nonce
                    /* передаю из  php  айди юзера автоиризированого  'nonce' => wp_create_nonce('wp_rest') */
                },
                body: JSON.stringify({ wishlist: ids }),
            });

            /* если юзер не авториизрован нажимает налайк в карточке  */
            if (user === 1) {
                if (response.status === 401) {
                    alert('Пожалуйста, войдите в аккаунт.');
                    return;
                }
            }


            const data = await response.json();

            const wishlist = data.products || [];



            if (wishlist.length !== 0) {
                wishlist.forEach((item) => {
                    ids.push(item.id);
                })

            }


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
        console.log(products);
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


    loadWishlist();
}

wishlis()
