<?php
defined('ABSPATH') || exit;

global $product;


$post_thumbnail_id = $product->get_image_id();


$gallery_image_ids = $product->get_gallery_image_ids();


$image_ids = array_merge([$post_thumbnail_id], $gallery_image_ids);
?>

<div class="product-one__slide product-slide">
	<div class="product-slide__thunb">
		<?php foreach ($image_ids as $image_id):

			$thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
		?>
			<div  class="product-slide__thunb-item">
				<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', true)); ?>">
			</div>
		<?php endforeach; ?>
	</div>
	<div class="product-slide__big">
		<?php foreach ($image_ids as $index => $image_id):
			$big_url = wp_get_attachment_image_url($image_id, 'full'); // можно использовать 'full' для лучшего качества
			$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		?>
			<div class="product-slide__big-item" data-slick-index="<?php echo $index; ?>">
				<a href="<?php echo esc_url($big_url); ?>" data-fancybox="product-gallery">
					<img src="<?php echo esc_url($big_url); ?>" alt="<?php echo esc_attr($alt); ?>">
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>