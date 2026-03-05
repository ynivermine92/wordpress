


вывод acf поля 

1 вывод всех полей мамасивов   get_fields
	$global_data = get_fields();

	echo '<pre>';
            print_r($global_data);
        echo '</pre>';
	

2 когда узнал какой масив нужно вывести вывожу отдельный масив  get_field
   $hero_data = get_field('hero'); // возвращает массив группы 

		echo '<pre>';
                   print_r($hero_data);
                echo '</pre>'


3 если глобальная страница то поиск через 2 параметр (типо глобел страницы ) 
   1 узнать глобальную страницу что что нужно вывети  
   
     $services_data = get_fields('option');

     	echo '<pre>';
                   print_r($services_data);
        echo '</pre>'
    2 вывести блок  нужно указывать 2 параметр option
        $partners_data = get_field('partners', 'option');

    		echo '<pre>';
                   print_r($partners_data);
                echo '</pre>'




Стандартный вывод информации из ACF (текст, ссылка на картинку и т.п.):
 <?php $delivery_data = get_field('main__delivery');   выводи масива поля акф
        print_r($delivery_data); ?>






1 <?php the_field('название_ярлыка_поля'); ?>



Вывод повторителя:
<?php if(get_field('название_ярлыка_повторителя')): ?>
<?php while(has_sub_field('название_ярлыка_повторителя')) : ?>
   <div class="slide">
      <img src="<?php the_sub_field('название_ярлыка_поля'); ?>">
   </div>
<?php endwhile; ?>
<?php endif; ?>



Повторитель в повторителе:

<?php if(get_field('название_ярлыка_повторителя_1')): ?>
<?php while(has_sub_field('название_ярлыка_повторителя_1')) : ?>
   <div class="slide">
      <img src="<?php the_sub_field('название_ярлыка_поля_повторителя_1'); ?>">
      <ul class="list">
         <?php if(get_sub_field('название_ярлыка_повторителя_2')): ?>
         <?php while(has_sub_field('название_ярлыка_повторителя_2')) : ?>
            <li><?php the_sub_field('название_ярлыка_поля_повторителя_2'); ?></li>
         <?php endwhile; ?>
         <?php endif; ?>
      </ul>
   </div>
<?php endwhile; ?>
<?php endif; ?>


Вывод группы полей:

<?php if( have_rows('название_ярлыка_группы') ): ?>
<?php while( have_rows('название_ярлыка_группы') ): the_row(); ?>
   <a href="<?php the_sub_field('название_ярлыка_поля_группы'); ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>
   <a href="<?php the_sub_field('название_ярлыка_поля_группы'); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
<?php endwhile; ?>
<?php endif; ?> 


Тип поля “Галерея”

<?php if ($img_gallery = get_field("название_ярлыка_галереи")) : ?>
    <?php foreach ($img_gallery as $img) : ?>
        <?php if ($img) : ?>
            <?= "<img 
                src="<?= esc_url($img['sizes']['thumbnail']) ?>" 
                alt="<?= esc_attr($img['alt']) ?>"
                loading="lazy"
                width="<?= esc_attr($image_array['width']) ?>"
                height="<?= esc_attr($image_array['height']) ?>"
            />" ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>


Тип поля “Объект записи”

<?php if ($post_objects = get_field("название_ярлыка_объекта_записи")) : ?>
    <?php 
    foreach ($post_objects as $post) : setup_postdata($post); ?>
        <?php if ($post) : ?>
 
            <?php the_title(); ?>
            <?php the_excerpt(); ?>
            <?php the_field("название_ярлыка_поля_объекта_записи"); ?>
            <?php the_permalink(); ?>
 
        <?php endif; ?>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>





Тип поля “Гибкое содержание”


<?php if (have_rows('название_ярлыка_гибкого_содержания')) : ?>
    <?php while (have_rows('название_ярлыка_гибкого_содержания')) : the_row(); ?>
 
        <?php if (get_row_layout() == 'hero') : ?>
            <?php get_template_part("template-parts/hero-section") ?>
        <?php elseif (get_row_layout() == 'about') : ?>
            <?php get_template_part("template-parts/about-section") ?>
        <?php elseif (get_row_layout() == 'contacts') : ?>
            <?php get_template_part("template-parts/contacts-section") ?>
        <?php endif; ?>
 
    <?php endwhile; ?>
<?php endif; ?>

Тип поля “Ссылка”
<?php if (get_field('название_ярлыка_ссылки')) : ?>
    <a href="<?= get_field('название_ярлыка_ссылки')['url'] ?>" target="<?= get_field('название_ярлыка_ссылки')['target'] ?>"><?= get_field('название_ярлыка_ссылки')['title'] ?></a>
<?php endif; ?>



Вывод поля ACF только если оно заполнено
<?php if (get_field("имя_ярлыка_поля")) { ?>
    <?php the_field("имя_ярлыка_поля"); ?>
<?php } ?>


Страница опций ACF

if (function_exists("acf_add_options_page")) {
    acf_add_options_page(array(
        "page_title" => "Опции темы",
        "menu_title" => "Опции темы",
        "menu_slug"  => "theme_settings",
    ));
}

Вывод полей из страницы с опций

<?php the_field("имя_ярлыка_поля", "option"); ?>



картинку выбрать как мисив изображение в админке 
 <?php
     $image = get_field('main_sliderImage');
     if ($image):
     ?>
     <img class="top-slider__img" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
     <?php endif; ?>









отладка вывода всех полей (масив совсеми полями)

<?php if (have_rows('home__popap')): ?>
    
<?php while (have_rows('home__popap')): the_row(); ?>
        
<h2 class="mb-4"><?php the_field('home__popap-title'); ?></h2>
        
<?php
            // Для отладки выводим все данные группы
            
echo '<pre>';
            print_r(get_sub_field('home__popap-title'));
            
echo '</pre>';
        ?>
    <?php endwhile; ?>
<?php else: ?>
    
<p>Данных нет</p>
<?php endif; ?>










ифа  https://verstach.ru/shpargalka-dlya-acf-gotovye-primery-dlya-vyvoda-polej/

видо работ акф     https://www.youtube.com/watch?v=JJ2ONuxAYRo       



































