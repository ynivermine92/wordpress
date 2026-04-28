
/* count */
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