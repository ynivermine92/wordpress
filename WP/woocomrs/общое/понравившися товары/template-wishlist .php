<?php
/*
Template Name: wishlist
*/
get_header();
breadcrumbs();
?>

<section class="wishlist">
    <div class="container">
        <h2 class="wishlist__title">Понравившиеся товары</h2>
        <div class="wishlist__grid" id="wishlist-container">
            <p>Загрузка избранного списка...</p>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("wishlist-container");

        let favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];

        if (favorites.length === 0) {
            container.innerHTML = "<p>Вы ещё не добавили товары в избранное.</p>";
        } else {
            fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "action=get_wishlist_products&ids=" + favorites.join(",")
                })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                });
        }
    });

    // Обработка удаления
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("wishlist__item-remove")) {
            const id = event.target.dataset.id;
            let favorites = JSON.parse(localStorage.getItem("wishlist_ids")) || [];
            favorites = favorites.filter(favId => favId !== id);
            localStorage.setItem("wishlist_ids", JSON.stringify(favorites));
            location.reload();
        }
    });
</script>

<?php get_footer(); ?>