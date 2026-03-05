<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package marcho
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="page-404">
		<div class="container">
			<div class="page-404__inner">
				<div class="page-404__content">
					<h2 class="page-404__title">OPPS! Page Not Found !!</h2>
					<p class="page-404__text">We're sorry but we can’t seem to find the page you requested. This might be because you typed the web address incorrectly.</p>
					<a class="page-404__link" href="<?php echo home_url(); ?>">BACK TO HOME</a>
				</div>
				<img class="page-404__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/404.png" alt="404 image">
			</div>
		</div>
	</section>


	
</main>

<?php
get_footer();
?>