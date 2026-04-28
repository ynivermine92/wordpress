

const burger = () => {
    const burgerBtn = document.querySelector(".burger");
    const navMenu = document.querySelector(".catalog");
    burgerBtn.addEventListener("click", () => {
        navMenu.classList.toggle("active");
        burgerBtn.classList.toggle("active");
        if (burgerBtn.classList.contains("active")) {
        }
    });
};

burger();

// Открытие/закрытие мобильного меню
const burgerMobileMenu = () => {
    const burgerBtn = document.querySelector(".burger__mobile-btn");
    const menuWrapper = document.querySelector(".burger-mobile");
    const headerDesktop = document.querySelector(".header__desktop");
    const headerMobile = document.querySelector(".header__mobile");
    const closeBtn = document.querySelector(".burger-mobile__close");

    // Открытие меню
    burgerBtn.addEventListener("click", () => {
        menuWrapper.classList.add("active");
        headerDesktop.classList.add("disabled");
        headerMobile.classList.add("disabled");
        document.body.classList.add("locked");
    });

    // Закрытие меню
    closeBtn.addEventListener("click", () => {
        menuWrapper.classList.remove("active");
        headerDesktop.classList.remove("disabled");
        headerMobile.classList.remove("disabled");
        document.body.classList.remove("locked");
    });

    // Закрытие при ресайзе десктоп
    window.addEventListener("resize", () => {
        if (window.innerWidth > 1000) {
            menuWrapper.classList.remove("active");
            headerDesktop.classList.remove("disabled");
            headerMobile.classList.remove("disabled");
            document.body.classList.remove("locked");
        }
    });
};

burgerMobileMenu();





/* megaMenu desktop выпадающее сторону */
const megaMenu = () => {
    const level1 = document.querySelectorAll('.megamenu__one > .megamenu__item');
    const level2 = document.querySelectorAll('.megamenu__two > .megamenu__item');
    const level3 = document.querySelectorAll('.megamenu__three > .megamenu__item');

    // helper для открытия UL
    const openWrapper = (selector, condition) => {
        document.querySelectorAll(selector).forEach(ul => {
            ul.classList.toggle('open', condition(ul));
        });
    };

    // ===== Уровень 1 =====
    let timeoutLevel1;
    level1.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(timeoutLevel1);

            timeoutLevel1 = setTimeout(() => {
                // Снимаем active со всех
                level1.forEach(el => el.classList.remove('active'));
                level2.forEach(el => el.classList.remove('active'));
                level3.forEach(el => el.classList.remove('active'));

                // Активируем текущий
                item.classList.add('active');

                // Открываем второй уровень только для этой категории
                openWrapper('.megamenu__two', ul => ul.querySelector(`.megamenu__item[data-cat-id="${item.dataset.catId}"]`));

                // Закрываем третий уровень
                openWrapper('.megamenu__three', () => false);
            }, 250); // Задержка 250ms
        });

        item.addEventListener('mouseleave', () => clearTimeout(timeoutLevel1));
    });

    // ===== Уровень 2 =====
    let timeoutLevel2;
    level2.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(timeoutLevel2);

            timeoutLevel2 = setTimeout(() => {
                level2.forEach(el => el.classList.remove('active'));
                level3.forEach(el => el.classList.remove('active'));

                item.classList.add('active');

                // Активируем родителя уровня 1
                level1.forEach(el => {
                    if (el.dataset.catId === item.dataset.catId) el.classList.add('active');
                });

                // Открываем третий уровень только для этой подкатегории
                openWrapper('.megamenu__three', ul => ul.querySelector(`.megamenu__item[data-subcat-id="${item.dataset.subcatId}"]`));
            }, 250); // Задержка 250ms
        });

        item.addEventListener('mouseleave', () => clearTimeout(timeoutLevel2));
    });

    // ===== Уровень 3 =====
    let timeoutLevel3;
    level3.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(timeoutLevel3);

            timeoutLevel3 = setTimeout(() => {
                level3.forEach(el => el.classList.remove('active'));
                item.classList.add('active');

                // Активируем родителя уровня 2
                level2.forEach(el => {
                    if (el.dataset.catId === item.dataset.catId && el.dataset.subcatId === item.dataset.subcatId) {
                        el.classList.add('active');
                    }
                });

                // Активируем родителя уровня 1
                level1.forEach(el => {
                    if (el.dataset.catId === item.dataset.catId) el.classList.add('active');
                });
            }, 250); // Задержка 250ms
        });

        item.addEventListener('mouseleave', () => clearTimeout(timeoutLevel3));
    });


}
megaMenu()


/*  acardion  mobMenu  выпадающее бок */

const menuMob = () => {
    const links = document.querySelectorAll('.mobilemenu__link');

    links.forEach((link) => {
        link.addEventListener('click', (e) => {
            const parentLi = link.closest('.mobilemenu__item');
            const submenu = parentLi.querySelector('.mobilemenu__two');


            if (parentLi.classList.contains('mobilemenu__item-one') && submenu) {
                e.preventDefault();

                if (link.classList.contains('active')) {

                    link.classList.remove('active');
                    submenu.classList.remove('open');
                } else {

                    links.forEach((l) => l.classList.remove('active'));
                    document.querySelectorAll('.mobilemenu__two').forEach((ul) => ul.classList.remove('open'));


                    link.classList.add('active');
                    submenu.classList.add('open');
                }
            }

        });
    });
};

menuMob();