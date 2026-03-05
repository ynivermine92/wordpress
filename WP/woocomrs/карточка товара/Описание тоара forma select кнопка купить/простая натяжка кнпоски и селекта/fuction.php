

				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
				add_action('woocommerce_single_product_summary', 'productSelectBtnCastom', 30);


				function productSelectBtnCastom()
				{
					global $product; ?>
						<form class="cart slider-product__select" action="<?= esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">


							<button type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()); ?>" class="slider-product__btn">
								<?= esc_html($product->single_add_to_cart_text()); ?>
							</button>


							<div class="counter">
								<button class="counter__btn minus disabled" type="button">-</button>
								<input class="counter__input" name="quantity" value="1" min="1" maxlength="3">
								<button class="counter__btn plus" type="button">+</button>
							</div>

						</form>
				<?
				}