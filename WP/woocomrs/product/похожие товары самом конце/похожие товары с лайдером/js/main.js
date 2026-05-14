  const catalogsSwiper = new Swiper('.catalogs__slider', {
    loop: false,
    slidesPerView: '7',
    spaceBetween: 15,


    pagination: {
      el: '.catalogs__slider .swiper-pagination',
      type: 'bullets',
      clickable: true,
    },

    // Navigation arrows
    navigation: {
      nextEl: '.catalogs__slider .swiper-button-next',
      prevEl: '.catalogs__slider .swiper-button-prev',
    },




    breakpoints: {
      0: {
        slidesPerView: 2,
        spaceBetween: 10,
      },

      375: {
        slidesPerView: 3,
        spaceBetween: 10,
      },
      675: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
      930: {
        slidesPerView: 5,
        spaceBetween: 10,
      },

      1450: {
        slidesPerView: 7,
        spaceBetween: 15,
      }
    },

  });