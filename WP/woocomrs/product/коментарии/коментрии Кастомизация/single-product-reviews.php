<?php

/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined('ABSPATH') || exit;

global $product;

if (! comments_open()) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			if ($count && wc_review_ratings_enabled()) {
				/* translators: 1: reviews count 2: product name */
				$reviews_title = sprintf(esc_html(_n('%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce')), esc_html($count), '<span>' . get_the_title() . '</span>');
				echo apply_filters('woocommerce_reviews_title', $reviews_title, $count, $product); // WPCS: XSS ok.
			} else {
				esc_html_e('Reviews', 'woocommerce');
			}
			?>
		</h2>


		<!--    коментарии -->
		<?php if (have_comments()) : ?>
			<ol class="commentlist">
				<?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array

				/* woocommerce_comments();  убираем функцию дефотную ставляем мою my_review*/('callback' => 'my_review'))); ?>
			</ol>

			<?php
			if (get_comment_pages_count() > 1 && get_option('page_comments')) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e('There are no reviews yet.', 'woocommerce'); ?></p>
		<?php endif; ?>


		<!-- кастом пагинация -->
		<?php
		if (get_comment_pages_count() > 1 && get_option('page_comments')) :

			$current = max(1, get_query_var('cpage'));
			$total   = get_comment_pages_count();
		?>

			<div class="wrapper">
				<div class="pagination">
					<ul class="pagination__items">

						<!-- Prev -->
						<?php
						$prev_page = $current - 1;
						$prev_class = 'pagination__item pagination__item-prev';

						if ($current <= 1) {
							$prev_class .= ' disabled';
						}
						?>

						<li class="<?php echo $prev_class; ?>">
							<?php if ($current > 1) : ?>
								<a class="pagination__link pagination__link-prev"
									href="<?php echo esc_url(get_comments_pagenum_link($prev_page)); ?>">
									&lt;
								</a>
							<?php else : ?>
								<span class="pagination__link pagination__link-prev">&lt;</span>
							<?php endif; ?>
						</li>

						<!-- Pages -->
						<?php
						$links = paginate_comments_links([
							'total'   => $total,
							'current' => $current,
							'type'    => 'array',
							'prev_next' => false,
						]);

						if (!empty($links)) {
							foreach ($links as $link) {

								$class = 'pagination__item';

								if (strpos($link, 'current') !== false) {
									$class .= ' active';
								}

								if (strpos($link, 'dots') !== false) {
									$class .= ' pagination__item-dots';
								}

								$link = str_replace('page-numbers', 'pagination__link', $link);

								echo '<li class="' . $class . '">' . $link . '</li>';
							}
						}
						?>

						<!-- Next -->
						<?php
						$next_page = $current + 1;
						$next_class = 'pagination__item pagination__item-next';

						if ($current >= $total) {
							$next_class .= ' disabled';
						}
						?>

						<li class="<?php echo $next_class; ?>">
							<?php if ($current < $total) : ?>
								<a class="pagination__link pagination__link-next"
									href="<?php echo esc_url(get_comments_pagenum_link($next_page)); ?>">
									&gt;
								</a>
							<?php else : ?>
								<span class="pagination__link pagination__link-next">&gt;</span>
							<?php endif; ?>
						</li>

					</ul>
				</div>
			</div>

		<?php endif; ?>
		<!-- кастом пагинация -->



	</div>

	<?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__('Add a review', 'woocommerce') : sprintf(esc_html__('Be the first to review &ldquo;%s&rdquo;', 'woocommerce'), get_the_title()),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__('Leave a Reply to %s', 'woocommerce'),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title" role="heading" aria-level="3">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__('Submit', 'woocommerce'),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option('require_name_email', 1);
				$fields              = array(
					'author' => array(
						'label'        => __('Name', 'woocommerce'),
						'type'         => 'text',
						'value'        => $commenter['comment_author'],
						'required'     => $name_email_required,
						'autocomplete' => 'name',
					),
					'email'  => array(
						'label'        => __('Email', 'woocommerce'),
						'type'         => 'email',
						'value'        => $commenter['comment_author_email'],
						'required'     => $name_email_required,
						'autocomplete' => 'email',
					),
				);

				$comment_form['fields'] = array();

				foreach ($fields as $key => $field) {
					$field_html  = '<p class="comment-form-' . esc_attr($key) . '">';
					$field_html .= '<label for="' . esc_attr($key) . '">' . esc_html($field['label']);

					if ($field['required']) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" autocomplete="' . esc_attr($field['autocomplete']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ($field['required'] ? 'required' : '') . ' /></p>';

					$comment_form['fields'][$key] = $field_html;
				}

				$account_page_url = wc_get_page_permalink('myaccount');
				if ($account_page_url) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'woocommerce'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
				}


				if (wc_review_ratings_enabled()) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating" id="comment-form-rating-label">' . esc_html__('Your rating', 'woocommerce') . (wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '') . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'woocommerce') . '</option>
						<option value="5">' . esc_html__('Perfect', 'woocommerce') . '</option>
						<option value="4">' . esc_html__('Good', 'woocommerce') . '</option>
						<option value="3">' . esc_html__('Average', 'woocommerce') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'woocommerce') . '</option>
						<option value="1">' . esc_html__('Very poor', 'woocommerce') . '</option>
					</select></div>';
				}



				/* Рейтиг кастом  Меняю только саму svg*/

				if (wc_review_ratings_enabled()) {

					$rating_required = wc_review_ratings_required();

					$stars = '<div class="comment-form-rating">';
					$stars .= '<label id="comment-form-rating-label">' . esc_html__('Your rating', 'woocommerce');

					if (wc_review_ratings_required()) {
						$stars .= '&nbsp;<span class="required">*</span>';
					}

					$stars .= '</label>';

					$stars .= '<div class="rating">';

					foreach (range(5, 1) as $i) {
						$stars .= '
							<input 
								type="radio" 
								name="rating" 
								id="rating-' . $i . '" 
								value="' . $i . '" 
								' . $rating_required . '
							>

					<label for="rating-' . $i . '">
					
						<svg class="rating__star" viewBox="0 0 26 25">
						<path d="M11.5204 1.9421C11.986 0.508953 14.0135 0.508955 14.4792 1.94211L16.2677 7.44656C16.476 8.08748 17.0732 8.52142 17.7471 8.52142H23.5349C25.0418 8.52142 25.6683 10.4497 24.4492 11.3354L19.7668 14.7374C19.2216 15.1335 18.9935 15.8356 19.2017 16.4765L20.9902 21.981C21.4559 23.4142 19.8156 24.6059 18.5965 23.7202L13.9141 20.3182C13.3689 19.9221 12.6307 19.9221 12.0855 20.3182L7.40308 23.7202C6.18397 24.6059 4.54367 23.4141 5.00933 21.981L6.79784 16.4765C7.00608 15.8356 6.77795 15.1335 6.23275 14.7374L1.55038 11.3354C0.331269 10.4497 0.95781 8.52142 2.46471 8.52142H8.25243C8.92634 8.52142 9.52361 8.08748 9.73186 7.44656L11.5204 1.9421Z"/>
						</svg>

					</label>
				   ';
					}

					$stars .= '</div></div>';

					$comment_form['comment_field'] = $stars;
				}

				/* Рейтиг кастом */


				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__('Your review', 'woocommerce') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'woocommerce'); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>