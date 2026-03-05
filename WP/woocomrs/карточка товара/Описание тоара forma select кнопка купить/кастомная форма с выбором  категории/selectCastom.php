<?php 
/*   product select castom */

    function custom_add_to_cart_form()
    {
        global $product;

        if (!$product || !$product->is_type('variable')) return;

        $product_id = $product->get_id();
        $available_variations = $product->get_available_variations();
        $attributes = $product->get_attributes();

        $color_size_map = [];
        foreach ($available_variations as $variation) {
            $color = $variation['attributes']['attribute_pa_color'] ?? '';
            $size = $variation['attributes']['attribute_pa_size'] ?? '';
            if ($color && $size) {
                $color_size_map[$color][] = $size;
            }
        }

        $sizes_in_variations = array_unique(array_merge(...array_values($color_size_map)));

        $color_terms = wc_get_product_terms($product_id, 'pa_color', ['fields' => 'all']);
        $size_terms = wc_get_product_terms($product_id, 'pa_size', ['fields' => 'all']);

        $default_color = array_keys($color_size_map)[0] ?? '';
        $default_size = $color_size_map[$default_color][0] ?? '';

        $default_variation_id = '';
        foreach ($available_variations as $variation) {
            if (
                ($variation['attributes']['attribute_pa_color'] ?? '') === $default_color &&
                ($variation['attributes']['attribute_pa_size'] ?? '') === $default_size
            ) {
                $default_variation_id = $variation['variation_id'];
                break;
            }
        }
        ?>

            <form class="product__item-form product-filter" method="post" enctype="multipart/form-data">
                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>">
                <input type="hidden" name="variation_id" class="variation_id" value="<?php echo esc_attr($default_variation_id); ?>">

                <!-- 📌 Добавлен блок для описания вариации -->
                <div class="variation-description product-one__item-text"></div>

                
                <?php if (!empty($color_terms)) : ?>
                    <div class="product-filter__color">
                        <div class="product-filter__color-title">Color:</div>
                        <?php
                        $real_colors = array_keys($color_size_map);
                        foreach ($color_terms as $term) :
                            $slug = $term->slug;
                            if (!in_array($slug, $real_colors)) continue;
                        ?>
                            <label>
                                <input
                                    class="product-filter__color-input"
                                    type="radio"
                                    name="attribute_pa_color"
                                    value="<?php echo esc_attr($slug); ?>"
                                    <?php checked($slug, $default_color); ?>>
                                <span class="product-filter__color-checkbox">
                                    <span class="filter-color__checbox--<?php echo esc_attr($slug); ?>"></span>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($size_terms)) : ?>
                    <div class="product-filter__size">
                        <div class="product-filter__size-title">Size:</div>
                        <?php foreach ($size_terms as $term) :
                            $slug = $term->slug;
                            if (!in_array($slug, $sizes_in_variations)) continue;
                        ?>
                            <label>
                                <input
                                    class="product-filter__size-input"
                                    type="radio"
                                    name="attribute_pa_size"
                                    value="<?php echo esc_attr($slug); ?>"
                                    <?php checked($slug, $default_size); ?>>
                                <span class="product-filter__size-checkbox"><?php echo esc_html($term->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="jq-number produc-one__item-num">
                    <div class="jq-number__field">
                        <input class="produc-one__item-num" type="number" name="quantity" value="1" min="1">
                    </div>
                    <div class="jq-number__spin-minus"></div>
                    <div class="jq-number__spin-plus"></div>
                </div>

                <button class="product-one__item-btn" type="submit">Add to cart</button>


            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('.product-filter');
                    const variations = <?php echo json_encode($available_variations); ?>;
                    const colorSizeMap = <?php echo json_encode($color_size_map); ?>;
                    const variationInput = form.querySelector('.variation_id');
                    const descriptionDiv = form.querySelector('.variation-description');
                    const sizeLabels = form.querySelectorAll('.product-filter__size label');

                    function updateVariationId() {
                        const color = form.querySelector('input[name="attribute_pa_color"]:checked')?.value;
                        const size = form.querySelector('input[name="attribute_pa_size"]:checked')?.value;

                        const match = variations.find(v =>
                            v.attributes.attribute_pa_color === color &&
                            v.attributes.attribute_pa_size === size
                        );

                        variationInput.value = match ? match.variation_id : '';

                        if (match && match.variation_description) {
                            descriptionDiv.innerHTML = match.variation_description;
                        } else {
                            descriptionDiv.innerHTML = '';
                        }

                        form.querySelector('button[type="submit"]').disabled = !match;
                    }

                    function filterSizesByColor(selectedColor) {
                        const availableSizes = colorSizeMap[selectedColor] || [];
                        const currentlySelected = form.querySelector('input[name="attribute_pa_size"]:checked')?.value;
                        let newSelected = null;

                        sizeLabels.forEach(label => {
                            const input = label.querySelector('input');
                            if (availableSizes.includes(input.value)) {
                                label.style.display = 'inline-block';
                                input.disabled = false;
                                if (input.value === currentlySelected) {
                                    newSelected = currentlySelected;
                                }
                            } else {
                                label.style.display = 'none';
                                input.checked = false;
                                input.disabled = true;
                            }
                        });

                        if (!newSelected && availableSizes.length) {
                            newSelected = availableSizes[0];
                        }

                        if (newSelected) {
                            const input = form.querySelector(`input[name="attribute_pa_size"][value="${newSelected}"]`);
                            if (input) input.checked = true;
                        }

                        updateVariationId();
                    }

                    const initialColorInput = form.querySelector(`input[name="attribute_pa_color"][value="<?php echo esc_js($default_color); ?>"]`);
                    if (initialColorInput) {
                        initialColorInput.checked = true;
                        filterSizesByColor(initialColorInput.value);
                    } else {
                        updateVariationId();
                    }

                    form.querySelectorAll('input[name="attribute_pa_color"]').forEach(input =>
                        input.addEventListener('change', () => filterSizesByColor(input.value))
                    );

                    form.querySelectorAll('input[name="attribute_pa_size"]').forEach(input =>
                        input.addEventListener('change', updateVariationId)
                    );
                });
            </script>

    <?php
    }