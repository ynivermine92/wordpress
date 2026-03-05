<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

	<div class="u-columns col2-set" id="customer_login">

		<div class="u-column1 col-1">

		<?php endif; ?>

		<section class="account">
			<div class="container">
				<div class="col wrapper">
					<div class="row authorization active">

						<h2 class="title fw700 ts-40">Log into your account</h2>
						<div class="inner">
							<form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>

								<?php do_action('woocommerce_login_form_start'); ?>

								<p class=" woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide account-input">
									<!-- 	<label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label> -->
									<input placeholder="Your email" type="text" class="woocommerce-Input woocommerce-Input--text input-text fw400 ts-14" name="username" id="username" autocomplete="username" value="<?php echo (! empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																																														?>
								</p>
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide account-input">
									<!-- 	<label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label> -->
									<input placeholder="Your password" class="woocommerce-Input woocommerce-Input--text input-text fw400 ts-14" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
								</p>

								<?php do_action('woocommerce_login_form'); ?>
								<p class="woocommerce-LostPassword lost_password">
									<a class="restore fw400 ts-12" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Forgot Password?', 'woocommerce'); ?></a>
								</p>
								<p class="form-row login-wrapper">
									<!-- 	<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label> -->
									<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
									<button type="submit" class="woocommerce-button button woocommerce-form-login__submit fw500 ts-16<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>"><?php esc_html_e('Login', 'woocommerce'); ?></button>
								</p>


								<?php do_action('woocommerce_login_form_end'); ?>

							</form>



							<div class="registration fw400 ts-12">Don`t have an account?
								<a class="link fw400 ts-12" href="<?php echo esc_url(wc_get_page_permalink('myaccount') . '?action=register'); ?>">Create one</a>
							</div>
						</div>
					</div>
				</div>




				<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>




			</div>
			<div class="col wrapper recovery">
				<div class="u-column2 inner">

					<h2><?php esc_html_e('Create an account', 'woocommerce'); ?></h2>


					<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

						<?php do_action('woocommerce_register_form_start'); ?>

						<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																												?>
							</p>

						<?php endif; ?>

						<p class="account-input woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Email" name="email" id="reg_email" autocomplete="email" value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required aria-required="true" /><?php // @codingStandardsIgnoreLine 
																																																																													?>
						</p>

						<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

							<p class=" account-input woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide parole ">

								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" placeholder="Your password" />
							</p>

						<?php else : ?>

							<p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

						<?php endif; ?>

						<?php do_action('woocommerce_register_form'); ?>


						<div class="box">
							<div class="content">
								<input type="checkbox" name="receive" value="1">
								<span class="checkmark">I want to receive updates about products and promotions.</span>

							</div>
							<p class="error-message" style="color:red; display:none;">You must agree to receive updates.</p>

						</div>



						<p class="woocommerce-form-row form-row">
							<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>

							<button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?>

							</button>
						</p>

						<?php do_action('woocommerce_register_form_end'); ?>

					</form>
					<div class="registration fw400 ts-12">Already have an account?
						<a class="loglink fw400 ts-12" href="#"> Log in one</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>







<script src="/assets/js/main.js"></script>