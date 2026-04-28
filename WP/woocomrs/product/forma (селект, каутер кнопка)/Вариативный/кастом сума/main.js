    function variationCounterSum() {



      const form = document.querySelector('form.variations_form');
      const priceBlock = document.querySelector('.cout__product-sum');
      const wrapper = document.querySelector('.cout__sum');



      if (!form || !priceBlock || !wrapper) return;

      let variations = [];

      try {
        variations = JSON.parse(form.dataset.product_variations || '[]');
      } catch (e) {
        variations = [];
      }

      wrapper.style.display = 'none';

      function getQty() {
        const qty = document.querySelector('.qty');
        return parseInt(qty?.value || 1);
      }

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

      setInterval(() => {
        const qty = getQty();

        if (qty !== lastQty) {
          lastQty = qty;
          updatePrice();
        }
      }, 150);

      form.addEventListener('change', updatePrice);
      form.addEventListener('reset', () => {
        priceBlock.textContent = '0';
        wrapper.style.display = 'none';
      });

      updatePrice();
    }
    variationCounterSum();