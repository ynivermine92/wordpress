


loop-start.php файл 

<section class="ftco-section bg-light">
	<div class="container-fluid">
	<!-- 	фильтр -->
		<?php do_action('woocommerce_before_shop_loop')?>

		<ul class="row products columns" style="display: grid; grid-template-columns: repeat(<?php echo esc_attr(wc_get_loop_prop('columns')); ?>, 4fr);">


-------------------------------------------------
content-product.php  файл

	<li class="productcustom">



-------------------------------------------------
css
/* Базовый стиль для списка продуктов */

/* ul */
.products{
  gap: 50px;
}

/* li */
.productcustom img{
  width: 100%;
}
