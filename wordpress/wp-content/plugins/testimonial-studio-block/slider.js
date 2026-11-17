document.addEventListener("DOMContentLoaded", function () {

    var sliders = document.querySelectorAll(".tsb-slider");

    sliders.forEach(function (slider) {

        var desktop = parseInt(slider.dataset.desktop) || 3;
        var tablet = parseInt(slider.dataset.tablet) || 2;
        var mobile = parseInt(slider.dataset.mobile) || 1;

        var autoplay = slider.dataset.autoplay === "true";
        var speed = parseInt(slider.dataset.speed) || 3000;

        var slides = slider.querySelectorAll(".swiper-slide").length;

        new Swiper(slider, {

            slidesPerView: desktop,
            spaceBetween: 30,

            /* Fix loop issue if slides are less */
            loop: slides > desktop,

            autoplay: autoplay ? {
                delay: speed,
                disableOnInteraction: false
            } : false,

            pagination: {
                el: slider.querySelector('.swiper-pagination'),
                clickable: true
            },

            navigation: {
                nextEl: slider.querySelector('.swiper-button-next'),
                prevEl: slider.querySelector('.swiper-button-prev')
            },

            breakpoints: {

                0: {
                    slidesPerView: mobile
                },

                768: {
                    slidesPerView: tablet
                },

                1024: {
                    slidesPerView: desktop
                }

            }

        });

    });

});