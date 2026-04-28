<?php
defined('ABSPATH') || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids();
$image_ids = array_merge([$post_thumbnail_id], $gallery_image_ids);
?>





<div class="slider__col">
	<div class="slider__prev">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/png/arrow.png" alt="" />
	</div>

	<div class="slider__thumbs">
		<div class="swiper-container thumbs-container">
			<div class="swiper-wrapper">
				<?php foreach ($image_ids as $image_id):
					$thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
					$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<div class="swiper-slide">
						<div class="slider__image">
							<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($alt); ?>" />
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="slider__next">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/png/arrow.png" alt="" />
	</div>
</div>

<div class="slider__images">
	<div class="swiper-container images-container">
		<div class="swiper-wrapper">
			<?php foreach ($image_ids as $image_id):
				$big_url = wp_get_attachment_image_url($image_id, 'product_cart');
				$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
			?>
				<div class="swiper-slide">
					<div class="slider__image">
						<a data-fancybox="product" href="<?php echo esc_url($big_url); ?>">
							<img class="special__box-image" src="<?php echo esc_url($big_url); ?>" alt="<?php echo esc_attr($alt); ?>" />
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
</div>