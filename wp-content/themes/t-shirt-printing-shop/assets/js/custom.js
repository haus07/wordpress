jQuery(document).ready(function () {
  var t_shirt_printing_shop_swiper_testimonials = new Swiper(".testimonial-swiper-slider.mySwiper", {
    slidesPerView: 3,
      spaceBetween: 15,
      speed: 1000,
      autoplay: {
        delay: 3000,
        disableOnPoppinsaction: false,
      },
      navigation: {
        nextEl: ".testimonial-swiper-button-next",
        prevEl: ".testimonial-swiper-button-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView: 2,
        },
        1023: {
          slidesPerView: 3,
        }
    },
  });
  var t_shirt_printing_shop_swiper_banner = new Swiper(".banner-right-col.mySwiper", {
    slidesPerView: 1,
    autoplay: {
      delay: 3000,
      disableOnPoppinsaction: false,
    },
    pagination: {
      el: ".banner-swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      300: {
        slidesPerView: 1,
      },
      901: {
        slidesPerView: 1,
      }
    },
  });

  var t_shirt_printing_shop_static_product = new Swiper(".product-static-carousel.mySwiper", {
    direction: 'horizontal',
    slidesPerView: 2.7,
    speed : 1000,
    spaceBetween: 20,
      autoplay: {
        delay: 2000,
        disableOnPoppinsaction: false,
      },
      pagination: {
        el: ".product-swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        900: {
          slidesPerView: 2,
        },
        1025: {
          slidesPerView: 2.7,
        }
    },
  });
});

