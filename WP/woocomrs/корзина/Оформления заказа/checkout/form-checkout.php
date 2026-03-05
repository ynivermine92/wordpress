<?php

/**
 * test
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if (! defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

?>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-8 ftco-animate">
				<?php
				$checkout = WC()->checkout();
				$fields = $checkout->get_checkout_fields();
				?>

				<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

					<?php if ($fields) : ?>

						<?php do_action('woocommerce_checkout_before_customer_details'); ?>

						<div class="billing-form bg-light p-3 p-md-5">
							<!-- Убрали хук <?php do_action('woocommerce_checkout_billing'); ?> -->

							<div class="checkout__box-wrapper">
								<div class="checkout__box">

									<?php
									$fields['billing']['billing_first_name']['input_class'][] = 'checkout__nput-name';
									woocommerce_form_field('billing_first_name', $fields['billing']['billing_first_name'], $checkout->get_value('billing_first_name'));
									?>
								</div>

								<div class="checkout__box">

									<?php
									$fields['billing']['billing_last_name']['input_class'][] = 'checkout__nput-lastname';
									woocommerce_form_field('billing_last_name', $fields['billing']['billing_last_name'], $checkout->get_value('billing_last_name'));
									?>
								</div>
							</div>

							<div class="checkout__box">

								<?php
								$fields['billing']['billing_country']['input_class'][] = 'checkout__nput-state';
								woocommerce_form_field('billing_country', $fields['billing']['billing_country'], $checkout->get_value('billing_country'));
								?>
							</div>


							<div class="checkout__box-wrapper">
								<div class="checkout__box">

									<?php
									$fields['billing']['billing_address_1']['input_class'][] = 'checkout__nput-adress';
									woocommerce_form_field('billing_address_1', $fields['billing']['billing_address_1'], $checkout->get_value('billing_address_1'));
									?>
								</div>
							</div>
							<div class="checkout__box">

								<?php
								$fields['billing']['billing_address_2']['input_class'][] = 'checkout__nput-apartment';
								woocommerce_form_field('billing_address_2', $fields['billing']['billing_address_2'], $checkout->get_value('billing_address_2'));
								?>
							</div>


							<div class="checkout__box-wrapper">
								<div class="checkout__box">

									<?php
									$fields['billing']['billing_city']['input_class'][] = 'checkout__nput-city';
									woocommerce_form_field('billing_city', $fields['billing']['billing_city'], $checkout->get_value('billing_city'));
									?>
								</div>

								<div class="checkout__box">

									<?php
									$fields['billing']['billing_postcode']['input_class'][] = 'checkout__nput-zip';
									woocommerce_form_field('billing_postcode', $fields['billing']['billing_postcode'], $checkout->get_value('billing_postcode'));
									?>
								</div>
							</div>

							<div class="checkout__box-wrapper">
								<div class="checkout__box">

									<?php
									$fields['billing']['billing_phone']['input_class'][] = 'checkout__nput-tell';
									woocommerce_form_field('billing_phone', $fields['billing']['billing_phone'], $checkout->get_value('billing_phone'));
									?>
								</div>

								<div class="checkout__box">

									<?php
									$fields['billing']['billing_email']['input_class'][] = 'checkout__nput-emaill';
									woocommerce_form_field('billing_email', $fields['billing']['billing_email'], $checkout->get_value('billing_email'));
									?>
								</div>
							</div>

						</div>

						<?php do_action('woocommerce_checkout_shipping'); ?>
						<?php do_action('woocommerce_checkout_after_customer_details'); ?>

					<?php endif; ?>

					<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
					<?php do_action('woocommerce_checkout_before_order_review'); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action('woocommerce_checkout_order_review'); ?>
						<?php do_action('woocommerce_checkout_after_order_review'); ?>
					</div>

				</form>



				<?php do_action('woocommerce_after_checkout_form', $checkout); ?>


			</div>
		</div>
	</div>
</section>