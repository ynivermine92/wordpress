<?php /* Template Name: searsh */ ?>



<?php get_header(); ?>



<!-- глобальный Get  а q передали из формы -->

<? $query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';


/* фильтрация по имени что мы сохранили  query */
$args = [
    'post_type' => 'product',
    'posts_per_page' => -1,
    's' => $query,
];

$products = new WP_Query($args);

?>


<body class="body-searsh">

    <main class="main__searsh">

        <section data-aos="fade-left" data-aos-duration="2000" class="sersh__shop">

            <div class="container">
                <div class="sersh__product"> <span class="sersh__product-sersh">Результати пошуку:</span><span class="sersh__product-content"><?= esc_html($_GET['q']) ?></span>
                </div>


                <div class="categories__content">
                    <ul class="categories__items searsh__items">
                        <?php if ($products->have_posts()): ?>
                            <?php while ($products->have_posts()): $products->the_post();
                                global $product; ?>
                                <li class="categories__item">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        // Выводим миниатюру товара (thumbnail) с размером 'woocommerce_thumbnail'
                                        echo get_the_post_thumbnail(get_the_ID(), 'woocommerce_thumbnail', ['class' => 'product-image']);
                                        ?>

                                        <h3 class="categories__name"><?php the_title(); ?></h3>
                                        <div class="price"><?php echo $product->get_price_html(); ?></div>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php else: ?>
                            <li class="categories__item">
                                <p class="sersh__content-text">По данному запросу ничего не найдено.<br>
                                    Попробуйте еще раз или перейдите в каталог</p>
                                <a class="sersh__link home__link" href="/catalog/">В каталог</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </section>
    </main>
</body>

<?php get_footer(); ?>










<a href="https://loverflower/product/%d0%bb%d1%96%d0%bb%d1%96%d1%8f-%d0%b1%d1%96%d0%bb%d0%b0/" class="categories__cart"><img width="300" height="300" src="https://loverflower/wp-content/uploads/2025/10/stich-2-1-300x300.webp" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="ЛІЛІЯ БІЛА" decoding="async" fetchpriority="high" srcset="https://loverflower/wp-content/uploads/2025/10/stich-2-1-300x300.webp 300w, https://loverflower/wp-content/uploads/2025/10/stich-2-1-100x100.webp 100w" sizes="(max-width: 300px) 100vw, 300px">
    <h2 class="categories__name">ЛІЛІЯ БІЛА</h2>
    <span class="price"><span class="woocommerce-Price-amount amount"><bdi>650,00&nbsp;<span class="woocommerce-Price-currencySymbol">₴</span></bdi></span></span>
</a><a href="https://loverflower/product/%d0%bb%d1%96%d0%bb%d1%96%d1%8f-%d0%b1%d1%96%d0%bb%d0%b0/" class="categories__link">В КОШИК</a>