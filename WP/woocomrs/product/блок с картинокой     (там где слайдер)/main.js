 /*   slider product */
  const sliderThumbs = new Swiper(".thumbs-container", {
    direction: "vertical",
    slidesPerView: 8,
    spaceBetween: 10,
    watchSlidesProgress: true,
    navigation: {
      nextEl: ".slider__next",
      prevEl: ".slider__prev",
    },
    freeMode: true,
    breakpoints: {
      0: { direction: "horizontal", slidesPerView: 1.5 },
      360: { direction: "horizontal", slidesPerView: 2 },
      576: { direction: "horizontal", slidesPerView: 5 },
      992: { direction: "vertical" },
    },
  });

  const sliderImages = new Swiper(".images-container", {
    direction: "vertical",
    slidesPerView: 1,
    spaceBetween: 0,
    mousewheel: false,
    navigation: {
      nextEl: ".slider__next",
      prevEl: ".slider__prev",
    },
    grabCursor: false,
    simulateTouch: false,
    allowTouchMove: false,
    thumbs: {
      swiper: sliderThumbs,
    },
    breakpoints: {
      0: { direction: "vertical" },
      1000: { direction: "vertical" },
    },
  });

