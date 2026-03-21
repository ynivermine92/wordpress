<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package test
 */

get_header();
?>

<main id="primary" class="post">




	<section class="blog">
		<div class="wrapper">
			<?php while (have_posts()) {

				the_post();


				$categories = get_the_category();

				$cats_names = [];
				if (!empty($categories)) {
					foreach ($categories as $item) {
						$cats_names[] = $item->name;
					}
				} ?>



				<div class="row blog__inner">
					<div class="col-auto">
						<div class="blog__category"><?php echo esc_html($cats_names[0]); ?></div>
					</div>
					<div class="col-auto">
						<div class="blog__data"><?php echo get_the_date('M d, Y'); ?></div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<h1 class="blog__title title"><?php the_title(); ?></h1>
					</div>
					<div class="col-12">
						<div class="blog__image"><?php the_post_thumbnail(''); ?></div>
					</div>
				</div>




			<?php



				global $post;

				$blocks = parse_blocks($post->post_content);

				foreach ($blocks as $block) {

					/* 	строеная функци ворпреса который берет блок гутенберга и  возращает html */
					$html = render_block($block);

					echo '</pre>';
					print_r($html);
					echo '</pre>';

					if ($block['blockName'] === 'core/paragraph') {
						// удаляем id Gutenberg
						$html = preg_replace('/id="block-[^"]+"/', '', $html);
						// добавляем свой класс
						$html = str_replace('<p', '<p class="blog-text"', $html);
					}

					if ($block['blockName'] === 'core/heading') {
						// добавляем свой класс
						$html = str_replace('<h2', '<h2 class="title"', $html);
					}
				}
			}


			?>

		</div>
		
	</section>
	<div class="wrapper">
		<?php get_template_part('section/education'); ?>
	</div>
</main>

<?php

get_footer();
