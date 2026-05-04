const coomentCastom = () => {
    const form = document.querySelector('#commentform');
    if (!form) return;

    const stars = form.querySelectorAll('.rating input[type="radio"]');
    const labels = form.querySelectorAll('.rating label');
    const textarea = form.querySelector('textarea[name="comment"]');

    const normalize = (str) =>
        str
            .replace(/<[^>]*>/g, '')
            .replace(/\s+/g, ' ')
            .trim()
            .toLowerCase();



    /* получаем кометари */
    const getExistingComments = () => {
        return Array.from(document.querySelectorAll('.description p'))
            .map(el => normalize(el.textContent));
    };


    /* форма когда евент в оставить коментарь */
    form.addEventListener('submit', function (e) {
        const checkedRating = form.querySelector('input[name="rating"]:checked');
        const newComment = normalize(textarea.value);

        /* проверка что бы оставли рейтинг */
        if (!checkedRating) {
            e.preventDefault();
            alert('Оберіть рейтинг');
            return;
        }

        const existingComments = getExistingComments();

        /* проверка что бы небыла дубля такого же кометаря */
        if (existingComments.includes(newComment)) {
            e.preventDefault();
            alert('Ви вже залишали такий коментар');
            return;
        }
    });


    /* Рейтинг  */
    stars.forEach(star => {
        star.addEventListener('change', function () {
            const value = Number(this.value);

            labels.forEach(label => {
                const input = document.getElementById(label.getAttribute('for'));
                const inputValue = Number(input.value);

                label.classList.toggle('active', inputValue <= value);
            });
        });
    });
};

coomentCastom();