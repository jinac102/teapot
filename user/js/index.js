/* mainbanner */
let swiper_banner = new Swiper(".swiper_banner", {
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: true,
    autoplayDisableOnInteraction: true,
  },
  pagination: {
    el: ".swiper-pagination",
    type: "fraction",
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

/* best 강의 */
let swiper_best_main = new Swiper(".swiper_best_main", {
  spaceBetween: 10,
  effect: "fade",
  fadeEffect: {
    crossFade: true,
  },
  loop: true,
  slidesPerView: 1,
});

let swiper_best_thumb = new Swiper(".swiper_best_thumb", {
  spaceBetween: 20,
  loop: true,
  loopedSlides: 3,
  slidesPerView: 4,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

swiper_best_main.controller.control = swiper_best_thumb;
swiper_best_thumb.controller.control = swiper_best_main;

/* time */
let swiper_time = new Swiper(".swiper_time", {
  pagination: {
    el: ".swiper-pagination",
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
