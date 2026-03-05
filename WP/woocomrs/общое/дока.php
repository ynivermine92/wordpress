1 woocommerce.php - создаем папке inc
2 подключаем вокомерс к  funtion.php
require get_template_directory() . '/inc/woocommerce.php';
3 подключаем хук бес которого не возможно кастомизировать woocommerce в function.php  ( уже в файле woocommerce.php) 

function marcho_add_woocommerce_support()
{
  add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'marcho_add_woocommerce_support');


4 woocommerce - папку создаем там будет все файлы для кастомизиции вокомерса


5 Ирархия файлов  
    Все продукты (главная страница с хуками)         archive-product.php 
    одельная карточка товара                        content-product.php			            						
    карточка товара на странице категории           content-product_cart.php  (общая)
    страница открытого продукта                     content-single-product.php
    Вся траница страница продукта                   single-product.php


    Корзина  папке     -    cart
    оформления заказа  -    checkout
    имейл за отссылку  -    emails

    папка глобал
          хлебные крошки    -  breadcrumb.php
          авторизация        -  form-login.php
          иптут( select )  сколько товара выбрать количество - находиться карточке товара  - quantity-input.php
          сайдбар           - sidebar.php
          контейнер начало   -  wrapper-start.php
          контейнер конец    -  wrapper-end.php


   myaccount -  профиль пользователя
          
          
    
