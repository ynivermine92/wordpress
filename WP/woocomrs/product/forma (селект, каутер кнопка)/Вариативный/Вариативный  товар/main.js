
const variationForm = () => {


    /* form */


    /* Если вариации только один выбер, он выберается  */
    function autoSelectSingleOption() {
        const selects = document.querySelectorAll('.variations select');

        selects.forEach(select => {
            const options = Array.from(select.options).filter(opt => opt.value !== '');

            if (options.length === 1) {
                select.value = options[0].value;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    }

    // первый запуск
    autoSelectSingleOption();

    /* кнопка удалить (reset) */
    const resetVariations = document.querySelector('.reset_variations');

    if (resetVariations) {
        resetVariations.addEventListener('click', () => {
            setTimeout(autoSelectSingleOption, 20);
        });
    }




    /* tabs */

    document.querySelectorAll('.product__tabs-item').forEach(item => {
        item.addEventListener('click', function () {

            const attr = this.dataset.attribute; // pa_size
            const value = this.dataset.value;     // 130-sm

            const select = document.querySelector(
                'select[name="attribute_' + attr + '"]'
            );

            if (!select) return;

            select.value = value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });

    /* redio */

    document.querySelectorAll('.product__radio input').forEach(radio => {
        radio.addEventListener('change', function () {

            const attr = this.dataset.attribute;
            const value = this.dataset.value;

            const select = document.querySelector(
                'select[name="attribute_' + attr + '"]'
            );

            if (!select) return;

            select.value = value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });


    /* select */
    document.querySelectorAll('.product__select-item').forEach(item => {
        item.addEventListener('click', function () {

            const attr = this.dataset.attribute;
            const value = this.dataset.value;

            const select = document.querySelector(
                'select[name="attribute_' + attr + '"]'
            );

            if (!select) return;

            select.value = value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });


    /* counter */

    document.querySelectorAll('.counter').forEach(counter => {
        const input = counter.querySelector('input');
        const minus = counter.querySelector('.minus');
        const plus = counter.querySelector('.plus');

        minus.addEventListener('click', () => {
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
        });

        plus.addEventListener('click', () => {
            input.value = parseInt(input.value) + 1;
        });
    });

    /* form */
}
variationForm();



