
  function setEqualImageHeight() {
    const imgs = document.querySelectorAll('.categories__item img');
    let max = 0;

    imgs.forEach(img => {
      img.style.height = 'auto';
      if (img.complete && img.offsetHeight > max) max = img.offsetHeight;
      else img.addEventListener('load', setEqualImageHeight, { once: true });
    });

    imgs.forEach(img => img.style.height = max + 'px');
  }

  // запуск при загрузке DOM
  document.addEventListener('DOMContentLoaded', setEqualImageHeight);

  // следим за новыми элементами через AJAX
  new MutationObserver(() => setEqualImageHeight())
    .observe(document.querySelector('.categories'), { childList: true, subtree: true });

  // пересчёт при ресайзе
  window.addEventListener('resize', setEqualImageHeight);
