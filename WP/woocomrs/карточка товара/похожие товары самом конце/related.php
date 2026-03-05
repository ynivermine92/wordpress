


					<? foreach ($related_ids as $item) {   /* перебераю каждую карточку */
						$related_product = wc_get_product($item);  /*  получаю обьект продуктов  */
					?>
						<div class="swiper-slide  slide__item ">
                             <!--  натяжка картинки -->
							<a data-fancybox="related" href="<?= wp_get_attachment_url($related_product->get_image_id()); ?>">
								<img
									class="special__box-image"
									src="<?= wp_get_attachment_url($related_product->get_image_id()); ?>"
									loading="lazy"
									alt="<?= esc_attr($related_product->get_name()); ?>" />
							</a>
							<!--  натяжка картинки имя  -->
								<p class="swiper__text"><?= esc_html( $related_product->get_name() ); ?></p>
 							<!-- натяжка картинки имя  проверка на акцию есть или нет  -->
							<?php if ($related_product->is_on_sale()) : ?>
								<span class="categories__sale"><span>SALE</span></span>
								<div class="categories__info">
				<!-- 	цена перечернутая	 -->			<span class="categories__info-newprace"><?= wc_price($related_product->get_sale_price()); ?></span>
				<!-- 	цена акция	 -->			<div class="categories__info-prace">
										<?= wc_price($related_product->get_regular_price()); ?>
									</div>
								</div>
							<?php else : ?>
								<div class="categories__info">
						<!-- обычная цена	 -->		<span class="swiper__price"><?= wc_price($related_product->get_price()); ?></span>
								</div>
							<?php endif; ?>
							<a class="swiper__cart" href="#">у кошик</a>
						</div>
					<? } ?>