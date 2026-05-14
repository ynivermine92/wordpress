
/* select */
document.querySelectorAll('.counter').forEach(counter => {
  const input = counter.querySelector('input');
  const minus = counter.querySelector('.minus');
  const plus = counter.querySelector('.plus');

  function updateState() {
    minus.classList.toggle('disabled', parseInt(input.value) <= 1);
  }

  minus.addEventListener('click', () => {
    let val = parseInt(input.value);
    if (val > 1) {
      input.value = val - 1;
      updateState();
    }
  });

  plus.addEventListener('click', () => {
    input.value = parseInt(input.value) + 1;
    updateState();
  });

  updateState();
});










/* prace product  приизменении товара цена меняется */
function updateProductSum() {
  const priceEl = document.querySelector('.woocommerce-Price-amount bdi');

  if (!priceEl) return;

  const priceText = priceEl.childNodes[0].nodeValue.trim();
  const price = parseFloat(priceText.replace(',', '.'));

  const qtyInput = document.querySelector('.qty');
  /* кнопка куда записывать сумму */
  const sumEl = document.querySelector('.cout__simple-sum');

  if (!qtyInput || !sumEl) return;

  const qty = parseInt(qtyInput.value) || 1;

  const total = price * qty;

  sumEl.textContent = total.toFixed(2);
}

// events

const qtyInput = document.querySelector('.qty');
const plusBtn = document.querySelector('.counter__btn.plus');
const minusBtn = document.querySelector('.counter__btn.minus');

updateProductSum();

if (qtyInput) {
  qtyInput.addEventListener('input', updateProductSum);
}

if (plusBtn) {
  plusBtn.addEventListener('click', function () {
    qtyInput.value = parseInt(qtyInput.value || 1) + 1;
    updateProductSum();
  });
}

if (minusBtn) {
  minusBtn.addEventListener('click', function () {
    qtyInput.value = Math.max(1, parseInt(qtyInput.value || 1) - 1);
    updateProductSum();
  });
}

