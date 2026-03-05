
document.addEventListener('DOMContentLoaded', () => {

  if (document.body.classList.contains("main__body") || document.body.classList.contains("body-contact")) {
    /*   маска подключене библиотека импут */
    const maskElement = document.querySelector('.phone__input');

    if (maskElement) {
      const maskOptions = { mask: '+{38}(000)000-00-00' };
      IMask(maskElement, maskOptions);

      const inputName = document.querySelector('.questions__input-name');
      const inputTell = document.querySelector('.questions__input-tell');
      const inputTextarea = document.querySelector('.questions__textarea');
      const btn = document.querySelector('.questions__form-btn');
      const model = document.querySelector('.questions___model-wrapper');
      const form = document.querySelector('.questions__form');

      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const nameValue = inputName.value.trim();
        const phoneValue = inputTell.value.trim();
        const commentValue = inputTextarea.value.trim();

        // Ваша валидация оставлена без изменений
        if (!isNaN(nameValue)) { alert('Ім\'я не повинно бути числом'); return; }
        if (nameValue === '' || nameValue.length < 2) { alert(`Ім'я повинно бути більше 2 букв і поле не повинно бути пустим`); return; }
        if (phoneValue.length < 13) { alert('Ви вказали не весь номер'); return; }
        if (commentValue.length < 10) { alert('коментарь повин бути бильше 10 літр'); return; }

        model.classList.add('active');
        form.classList.add('disabled');


        fetch(feedback_ajax_obj.ajax_url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },

          body: new URLSearchParams({
            action: 'send_feedback',
            nonce: feedback_ajax_obj.nonce,
            fb_name: nameValue,
            fb_phone: phoneValue,
            fb_comment: commentValue
          })
        })
          .then(response => response.json())
          .then(data => {
            alert(data.success ? data.data : data.data);
            if (data.success) form.reset();
            model.classList.remove('active');
            form.classList.remove('disabled');
          })
          .catch(() => {
            alert('Сталася помилка при відправці форми');
            model.classList.remove('active');
            form.classList.remove('disabled');
          });
      });
    }
  }
});

