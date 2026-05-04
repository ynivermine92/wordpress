    /* кастом прайс (выводится в cout__sum ) */
    function variationCounterSum() {


      /* форма  варитивного товара  дефотная вокомерса*/
      const form = document.querySelector('form.variations_form');
      /* обертка отображения цены*/
      const wrapper = document.querySelector('.cout__sum');
      /* кастомный класс куда отображения цены*/
      const priceBlock = document.querySelector('.cout__product-sum');


      if (!form || !priceBlock || !wrapper) return;

      let variations = [];

      /* получаем список всех вариаций товара из data-product_variations формы вариативного товара */

      try {
        variations = JSON.parse(form.dataset.product_variations || '[]');
      } catch (e) {
        variations = [];
        console.error('[product_variations] parse error:', e);
      }

      /* скрываем обертку суммы кастомной */
      wrapper.style.display = 'none';



      /* Берет из cout общое количество */
      function getQty() {
        const qty = document.querySelector('.qty');
        if (!qty) {
          return 1;
        }
        return parseInt(qty.value);
      }


      /* получаем выбранную вариацию товара по атрибутам  (select) */
      function findVariation() {
        const attrs = {};

        form.querySelectorAll('select').forEach(select => {
          attrs[select.name] = select.value;
        });

        return variations.find(v =>
          Object.keys(v.attributes).every(key =>
            v.attributes[key] === attrs[key] || v.attributes[key] === ''
          )
        );
      }




      /* получаем выбраную вариацию  перещитываем цену */
      function updatePrice() {
        const variation = findVariation();

        if (!variation) {
          priceBlock.textContent = '0';
          wrapper.style.display = 'none';
          return;
        }




        const price = Number(variation.display_price);
        const total = price * getQty();

        priceBlock.textContent = total.toFixed(2);
        wrapper.style.display = total > 0 ? '' : 'none';
      }


      let lastQty = null;


      /* следит за изменением количества товара */
      setInterval(() => {
        const qty = getQty();

        if (qty !== lastQty) {
          lastQty = qty;
          updatePrice();
        }
      }, 150);


      /* каждый раз, когда что-то меняется в форме — пересчитывай цену */
      form.addEventListener('change', updatePrice);
      form.addEventListener('reset', () => {
        priceBlock.textContent = '0';
        wrapper.style.display = 'none';
      });

      updatePrice();
    }
    variationCounterSum();