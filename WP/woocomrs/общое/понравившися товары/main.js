pdateWishlistCounter();

  const heartButtons = document.querySelectorAll(".product-item__link-heart");

  heartButtons.forEach(function (btn) {
    btn.addEventListener("click", function (event) {
      event.preventDefault();

      const parentLi = btn.closest("li");
      const classList = parentLi.className.split(" ");
      let productId = null;

      classList.forEach(function (cls) {
        if (cls.startsWith("post-")) {
          productId = cls.replace("post-", "");
        }
      });

      localHartd(productId);
    });
  });

  function updateWishlistCounter() {
    const favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];
    document.querySelectorAll('.user-nav__like').forEach(counter => {
      counter.textContent = favorites.length;
    });
  }

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