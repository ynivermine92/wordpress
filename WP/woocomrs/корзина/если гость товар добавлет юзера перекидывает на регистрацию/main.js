  if (!document.body.classList.contains('logged-in')) {
    document.querySelectorAll('.product-one__item-btn').forEach(function (btn) {
      // Запрещаем стандартное поведение (отправку формы)
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        // Редирект на страницу входа
        window.location.href = 'https://marsho/my-account/';
      });

      // Визуально делаем кнопку неактивной
      btn.style.opacity = '0.6';
    });


    document.querySelectorAll('form.product__item-form input, form.product__item-form select').forEach(function (input) {
      input.disabled = true;
    });
  }



