<!-- 1 поиск по  name="q" -->






		<div class="search">
			<div class="conanter">
				<div class="search__wrarpper">
					<form class="search__form" action="/searsh/" method="get" id="header-search-form">
						<input class="search__input" type="text" name="q" placeholder="Пошук товарів" />
						<button class="search__btn" type="submit">
							<svg class="menu__search-svg">
								<use xlink:href="<?= get_template_directory_uri(); ?>/assets/img/header/searsh.svg#searsh"></use>
							</svg>
						</button>
					</form>

					<div class="search__btn-clouse">X</div>
				</div>
			</div>
		</div>