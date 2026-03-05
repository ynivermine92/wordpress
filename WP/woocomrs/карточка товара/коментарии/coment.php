<?php

/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
    return;
}



// Сохраняем рейтинг при добавлении комментария
add_action('comment_post', function ($comment_id) {
    if (isset($_POST['rating'])) {
        add_comment_meta($comment_id, 'rating', intval($_POST['rating']), true);
    }
});


?>






<div class="tabs__content-item">
    <div class="сomments">

        <!-- обьект коментаря  -->
        <?php if (have_comments()) { ?>
            <ul class="comments__items">
                <?php
                wp_list_comments(array(
                    'style'       => 'ul',
                    'short_ping'  => true,
                    'avatar_size' => 50,
                    'callback'    => function ($comment, $args, $depth) {
                        $GLOBALS['comment'] = $comment;
                ?>


                    <!-- коментарий написаный   -->
                    <li class="comments__item" <?php comment_class('comments__item'); ?> id="comment-<?php comment_ID(); ?>">


                        <!-- текст коментария    -->
                        <p class="сomments__item-text">
                            <?php echo get_comment_text(get_comment_ID()); ?>
                        </p>



                        <!-- рейтинг который оставили    -->
                        <div class="form__rating"> <!-- количество звезд сколько будет-->
                            <div class="rating" data-rate-total="<?php echo intval($rating); ?>">
                                <?php
                                /* обьект который получает сколько нажали звезд скрытого импута */
                                $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));

                                /*  цикл звездочками */
                                for ($i = 5; $i >= 1; $i--) :
                                    // добавляем класс active  звездочки были жолтые (а не серые)
                                    $active_class = ($i <= $rating) ? ' active' : '';
                                ?> <!-- сколько будет выводиться звездочек  -->
                                    <svg class="rating__star rating__coment-star<?php echo $active_class; ?>" data-rate="<?php echo $i; ?>" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.85 10.44L11 6.06L9.13 10.44L4.39 10.86L7.99 13.98L6.92 18.62L11 16.17L15.08 18.62L14.01 13.98L17.6 10.85L12.85 10.44ZM16.59 20.69L11 17.33L5.41 20.69L6.88 14.34L1.95 10.06L8.45 9.5L11 3.5L13.54 9.49L20.04 10.06L15.12 14.34L16.59 20.69Z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- имя юзера -->
                        <div class="comments__item-name"><?php comment_author(); ?></div>
                        <!-- дата когда отправли -->
                        <div class="comments__item-date"><?php comment_date(); ?></div>



    </div>
    </li>
<?php
                    },
                ));
?>
</ul>
<?php } ?>









<!-- коментарий который отпарвляем форма 
                1 натяжку начинать лучше с формы
-->

<!-- форму так и оставляем  -->
<form method="post" class="comment-form form" id="commentform" action="<?php echo site_url('/wp-comments-post.php'); ?>">


    <div class="form__title">
        Залишіть свій відгук:
    </div>
    <p class="form__text">
        Ваша адреса email не буде опублікована. Обов'язкові поля
        позначені *
    </p>
    <span class="form__input-name">Ваша оцінка:</span>

    <!--  цикл который передает сколько звезд нажали  -->
    <div class="rating">
        <?php for ($i = 5; $i >= 1; $i--) : ?>
            <svg class="rating__star" data-rate="<?php echo $i; ?>" viewBox="0 0 24 24">
                <path d="M12.85 10.44L11 6.06L9.13 10.44L4.39 10.86L7.99 13.98L6.92 18.62L11 16.17L15.08 18.62L14.01 13.98L17.6 10.85L12.85 10.44ZM16.59 20.69L11 17.33L5.41 20.69L6.88 14.34L1.95 10.06L8.45 9.5L11 3.5L13.54 9.49L20.04 10.06L15.12 14.34L16.59 20.69Z" />
            </svg>
        <?php endfor; ?>
    </div>




    <!-- скрытй импут по по нем коментарий понимает сколько звездочек выбрал юзер поставил отзов
                             1 через value понимает скололько звезд нажали
                             2 свзян name='rating'  
                             3 отправляет   вехрний хук comment_post  
                             4 Без скрытого импута звезды не появяеться

                             5 Нужно через жс передать в импут сколько звёзд нажал юзер value
                                Как все сделать
                                1 Беру мои кастомные звезды количество какое я нажал 
                                2 передаю их количество звезд в resut__rating value ( и звезды появяться )
                                3 если нужно есть пример жс посмотерть stars !!!
                             -->
    <input class="resut__rating" type="hidden" name="rating" value="0" />


    <!--   условие если юзер авторизирован то вывожу -->
    <?php if (is_user_logged_in()) :
        $current_user = wp_get_current_user(); ?>
        <!--   имя юзера -->
        <input class="form__name" type="hidden" name="author" value="<?php echo esc_attr($current_user->display_name); ?>" />
        <!--   емейл юзера -->
        <input class="form__email" type="hidden" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" />
        <p class="logged__user">Ви зайшли як <span>"<?php echo esc_html($current_user->display_name); ?>"</span></p>
    <?php else : ?>
        <!--   нужно авторизоваться -->
        <input class="form__name" type="text" name="author" placeholder="Your name" required>
        <input class="form__email" type="email" name="email" placeholder="E-mail address" required>
    <?php endif; ?>

    <!--     коментрарий сюда пишу -->
    <textarea class="form__textarea" name="comment" placeholder="Введіть коментар" required></textarea>

    <!--    айди коментария служебный импут WP (скрытый) !нужен  -->
    <input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>" />


    <!--импут (новый коментарий) служебный  WP (скрытый)  !нужен -->
    <input type="hidden" name="comment_parent" value="0" />



    <!--кнопка -->
    <button type="submit" class="form__btn">Відпривити</button>

</form>




</div>
</div>