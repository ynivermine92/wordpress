1 закидываю плагины
2 через админу активирую 
3 через шорт код куда нужно выввести вывожу   	<? echo do_shortcode('[woo_ajax_filter]'); ?>
4 делаю натяжку  product-filter.php
5 обертка айтемс айтем и ли натяивается  product-filter.php конце 
6 что бы не выводилось 2 каталога товаров убрать в  archive-product.php 
  1 луп loopstart
  2 if (wc_get_loop_prop('total')) {}			
  3 луп loopend

7 не забыть создать товар и  атрибут ( бо фильтр не появиться )