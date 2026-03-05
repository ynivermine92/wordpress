const paginationBtn = () => {
    const paginAll = document.querySelectorAll('.pagination__item');

    paginAll.forEach((item, index) => {
        // Проверяем, если второй элемент активен
        if (index === 1 && item.classList.contains('active')) {
            paginAll[0].classList.add('disabled'); // Добавляем класс disabled первому элементу
        }

        // Проверяем, если предпоследний элемент активен
        if (index === paginAll.length - 2 && item.classList.contains('active')) {
            paginAll[paginAll.length - 1].classList.add('disabled'); // Добавляем класс disabled последнему элементу
        }

        const childWithClass = item.querySelector('.page-numbers.dots');
        if (childWithClass) {
            item.classList.add('item__dots');
        }
    });
};

paginationBtn();