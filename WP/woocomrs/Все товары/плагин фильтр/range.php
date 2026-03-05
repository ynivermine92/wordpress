Натяжка php реньж





<?php
global $wpdb;

// минимальная и максимальная цена из всех опубликованных товаров       тут нужно получить цену минамальную максимальную
$min_price = floor($wpdb->get_var("SELECT MIN(meta_value+0) FROM {$wpdb->postmeta} WHERE meta_key = '_price'"));
$max_price = ceil($wpdb->get_var("SELECT MAX(meta_value+0) FROM {$wpdb->postmeta} WHERE meta_key = '_price'"));
?>

<div class="filter__item filter-price">
    <h3 class="filter__title">ЦіНА</h3>
    <div class="fitler-price__form">
        <div class="wrapper">
            <fieldset class="filter-price">
                <div class="price-field">
                    <div class="slider-track"></div>
                    <input
                        type="range"
                        min="<?php echo $min_price; ?>"        
                        max="<?php echo $max_price; ?>"               
                        value="<?php echo $min_price; ?>"
                        id="lower"
                        name="min_price" />
                    <input
                        type="range"
                        min="<?php echo $min_price; ?>"
                        max="<?php echo $max_price; ?>"
                        value="<?php echo $max_price; ?>"
                        id="upper"
                        name="max_price" />
                </div>
            </fieldset>
        </div>
        <div class="price__box">
            ЦіНА :
            <div class="price__wrapper">
                <span class="price"><?php echo $min_price; ?></span>
                <span class="price__currency">Грн</span>
            </div>
            <div class="price__wrapper">
                <span class="price__max"><?php echo $max_price; ?></span>
                <span class="price__currency">Грн</span>
            </div>
        </div>
    </div>
</div>




<!-- и жс плагине  заменить айди  на :

     let minPrice = form.querySelector('#lower').value;
     let maxPrice = form.querySelector('#upper').value; -->