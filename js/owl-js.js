jQuery(document).ready(function( $ ) {
    $(document).ready(function () {
        // jQuery code




        /////////////////  items slider. /plugins/slickslider/
        if ($('.slider-banner-slick').length > 0) { // check if element exists
            $('.slider-banner-slick').slick({
                infinite: true,
                autoplay: true,
                slidesToShow: 1,
                dots: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
            });
        } // end if

        /////////////////  items slider. /plugins/slickslider/
        if ($('.slider-custom-slick').length > 0) { // check if element exists
            $('.slider-custom-slick').slick({
                infinite: true,
                slidesToShow: 2,
                dots: true,
                prevArrow: $('.slick-prev-custom'),
                nextArrow: $('.slick-next-custom')
            });
        } // end if



        /////////////////  items slider. /plugins/slickslider/
        if ($('.slider-items-slick').length > 0) { // check if element exists
            $('.slider-items-slick').slick({
                infinite: true,
                swipeToSlide: true,
                slidesToShow: 4,
                dots: true,
                slidesToScroll: 2,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        } // end if



        /////////////////  items slider. /plugins/owlcarousel/
        if ($('.slider-banner-owl').length > 0) { // check if element exists
            $('.slider-banner-owl').owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                dots: false,
                nav: true,
                navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            });
        } // end if 

        /////////////////  items slider. /plugins/owlslider/
        if ($('.slider-items-owl').length > 0) { // check if element exists
            $('.slider-items-owl').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 3
                    },
                    1024: {
                        items: 4
                    }
                }
            })
        } // end if

        /////////////////  items slider. /plugins/owlcarousel/
        if ($('.slider-custom-owl').length > 0) { // check if element exists
            var slider_custom_owl = $('.slider-custom-owl');
            slider_custom_owl.owlCarousel({
                loop: true,
                margin: 15,
                items: 2,
                nav: false,
            });

            // for custom navigation
            $('.owl-prev-custom').click(function () {
                slider_custom_owl.trigger('prev.owl.carousel');
            });

            $('.owl-next-custom').click(function () {
                slider_custom_owl.trigger('next.owl.carousel');
            });

        } // end if 



    });

}); 