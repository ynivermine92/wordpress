<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating custom-product-rating">

		<?php 
		$stars_total = 5;
		$stars_filled = round( $average );

		for ( $i = 1; $i <= $stars_total; $i++ ) {
			if ( $i <= $stars_filled ) {
				// Заполненная звезда — жёлтая (#FFD700)
				?>
				<svg width="20px" height="20px" viewBox="0 -0.5 33 33" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
					<polygon fill="#FFD700" points="27.865 31.83 17.615 26.209 7.462 32.009 9.553 20.362 0.99 12.335 12.532 10.758 17.394 0 22.436 10.672 34 12.047 25.574 20.22"></polygon>
				</svg>
				<?php
			} else {
				// Пустая звезда — серый цвет (#cccccc)
				?>
				<svg width="20px" height="20px" viewBox="0 -0.5 33 33" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
					<polygon fill="#cccccc" points="27.865 31.83 17.615 26.209 7.462 32.009 9.553 20.362 0.99 12.335 12.532 10.758 17.394 0 22.436 10.672 34 12.047 25.574 20.22"></polygon>
				</svg>
				<?php
			}
		}
		?>

		<?php if ( comments_open() ) : ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)
			</a>
		<?php endif; ?>

	</div>

<?php endif; ?>
