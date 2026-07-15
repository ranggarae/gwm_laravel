;(function($){
    "use strict";

    $(document).ready(function(){

        /*--------------------
        *  language change
        * ------------------*/

        $(document).on('click','.selected-language',function (e){
           e.preventDefault();
           $(this).next('ul').toggleClass('show');

        });

        var rtlEnable = $('html').attr('dir');
        var sliderRtlValue = typeof rtlEnable === 'undefined' ||  rtlEnable === 'ltr' ? false : true ;
        /**-----------------------------
         *  Navbar fix
         * ---------------------------*/
      
        if($(window).width() < 992){
            $(document).on('click','.navbar-area .navbar-nav li.menu-item-has-children>a',function(e){
                e.preventDefault();
            });
        }
        /*--------------------
           wow js init
       ---------------------*/
        new WOW().init();

        /*-------------------------
            magnific popup activation
        -------------------------*/
        $('.video-play-btn,.video-popup,.small-vide-play-btn').magnificPopup({
            type: 'video'
        });
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: true
        });
        /*------------------
           back to top
       ------------------*/
        $(document).on('click', '.back-to-top', function () {
            $("html,body").animate({
                scrollTop: 0
            }, 2000);
        });
        /*------------------------------
           counter section activation
       -------------------------------*/
        var counternumber = $('.count-num');
        if (counternumber.length > 1){
            counternumber.rCounter();
        }

        /*-------------------------------
            Portfolio filter 
        ---------------------------------*/
        var $Container = $('.portfolio-masonry,.gallery-masonry,.latest-product-masonry');
        if ($Container.length > 0) {
            $('.portfolio-masonry').imagesLoaded(function () {
                var festivarMasonry = $Container.isotope({
                    itemSelector: '.masonry-item', // use a separate class for itemSelector, other than .col-
                    masonry: {
                        gutter: 0
                    }
                });
                $(document).on('click', '.portfolio-menu li,.gallery-masonry-nav li,.latest-product-filter-nav li', function () {
                    var filterValue = $(this).attr('data-filter');
                    festivarMasonry.isotope({
                        filter: filterValue
                    });
                });
            });
            $(document).on('click','.portfolio-menu li,.gallery-masonry-nav li,.latest-product-filter-nav li' , function () {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            });
        }

        /*----------------------------------------
             jobs category carousel
         ----------------------------------------*/
        var $galleryCarousel = $('.case-study-gallery-carousel');

        if ($galleryCarousel.length > 0) {
            $galleryCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 1,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }
        /*----------------------------------------
             jobs category carousel
         ----------------------------------------*/
        var $jobsCategoryCarousel = $('.jobs-category-slider');

        if ($jobsCategoryCarousel.length > 0) {
            $jobsCategoryCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 3,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 4
                    },
                    1920: {
                        items: 4
                    }
                }
            });
        }
        /*----------------------------------------
             Testimonial carousel 08
         ----------------------------------------*/
        var $testimonialCarouselEight = $('.testimonial-carousel-08');

        if ($testimonialCarouselEight.length > 0) {
            $testimonialCarouselEight.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-long-arrow-alt-left"></i>','<i class="fas fa-long-arrow-alt-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }
        /*----------------------------------------
             Testimonial carousel 08
         ----------------------------------------*/
        var $gigCategoryCarousel = $('.gigs-category-carousel');

        if ($gigCategoryCarousel.length > 0) {
            $gigCategoryCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-long-arrow-alt-left"></i>','<i class="fas fa-long-arrow-alt-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    },
                    1920: {
                        items: 5
                    }
                }
            });
        }
        /*----------------------------------------
             featured job carousel
         ----------------------------------------*/
        var $featuredJobCarousel = $('.featured-job-carousel');

        if ($featuredJobCarousel.length > 0) {
            $featuredJobCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 2,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*----------------------------------------
            event carousel carousel
         ----------------------------------------*/
        var $eventCarousel = $('.event-carousel');

        if ($eventCarousel.length > 0) {
            $eventCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                smartSpeed:1000,
                rtl:sliderRtlValue,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    414: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 2,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*----------------------------------------
           Header Slider 01 carousel
       ----------------------------------------*/
        var $headerCarousel = $('.header-carousel-two');

        if ($headerCarousel.length > 0) {
            $headerCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 0,
                dots: true,
                nav: false,
                lazyLoad:true,
                smartSpeed:1000,
                animateIn:'fadeIn',
                animateOut:'fadeOut',
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 1,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }

        /*----------------------------------------
           Header Slider 01 carousel
       ----------------------------------------*/
        var $productCategoryCarousel = $('.product-category-carousel');

        if ($productCategoryCarousel.length > 0) {
            $productCategoryCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                smartSpeed:1000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 3,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 3,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 6
                    },
                    1920: {
                        items: 6
                    }
                }
            });
        }

        /*----------------------------------------
           Featured Product carousel
       ----------------------------------------*/
        var $featuredProductCarousel = $('.feature-product-slider');

        if ($featuredProductCarousel.length > 0) {
            $featuredProductCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                smartSpeed:1000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots:false
                    },
                    767: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    768: {
                        items: 2,
                        nav: false,
                        dots:false
                    },
                    960: {
                        items: 2,
                        nav:false,
                        dots:false
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }

        /*---------------------------
            Testimonial carousel
        ---------------------------*/
        var $testimonialCarousel = $('.testimonial-carousel');
        if ($testimonialCarousel.length > 0) {
            $testimonialCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: false,
                lazyLoad:true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    960: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }

        /*---------------------------
            Testimonial carousel
        ---------------------------*/
        var $testimonialJobHomeCarousel = $('.testimonial-carousel-job-home,.testimonial-carousel-wrapper');
        if ($testimonialJobHomeCarousel.length > 0) {
            $testimonialJobHomeCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: true,
                lazyLoad:true,
                rtl:sliderRtlValue,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                navText: ['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        margin: 0,
                    },
                    460: {
                        items: 1,
                        nav: false,
                        margin: 0
                    },
                    599: {
                        items: 1,
                        nav: false,
                        margin: 0
                    },
                    768: {
                        items: 1
                    },
                    960: {
                        items: 1
                    },
                    1200: {
                        items: 1
                    },
                    1920: {
                        items: 1
                    }
                }
            });
        }
        /*---------------------------
            Our Work carousel
        ---------------------------*/
        var $OurWorkCarousel = $('.our-work-carousel');
        if ($OurWorkCarousel.length > 0) {
            $OurWorkCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*---------------------------
           event carousel
        ---------------------------*/
        var $eventHomeEventCausesCarousel = $('.event-carousel');
        if ($eventHomeEventCausesCarousel.length > 0) {
            $eventHomeEventCausesCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }

        /*---------------------------
            Recent Causes carousel
        ---------------------------*/
        var $recentCausesCarousel = $('.recent-cause-carousel');
        if ($recentCausesCarousel.length > 0) {
            $recentCausesCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*---------------------------
            Related Post carousel
        ---------------------------*/
        var $RelatedPostCarousel = $('.related-news-carousel');
        if ($RelatedPostCarousel.length > 0) {
            $RelatedPostCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    },
                    1920: {
                        items: 2
                    }
                }
            });
        }
        /*---------------------------
           Event Team carousel
        ---------------------------*/
        var $EvenTeamCarousel = $('.event-team-carousel');
        if ($EvenTeamCarousel.length > 0) {
            $EvenTeamCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    },
                    1920: {
                        items: 6
                    }
                }
            });
        }

        /*---------------------------
            Latest News carousel
        ---------------------------*/
        var $latestNewsCarousel = $('.latest-news-carousel');
        if ($latestNewsCarousel.length > 0) {
            $latestNewsCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*---------------------------
           Price Plan carousel
        ---------------------------*/
        var $pricePlanCarousel = $('.price-carousel');
        if ($pricePlanCarousel.length > 0) {
            $pricePlanCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: true,
                nav: true,
                lazyLoad:true,
                navText:['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }
        /*---------------------------
            Brand carousel
        ---------------------------*/
        var $BrandCarousel = $('.brand-carousel');
        if ($BrandCarousel.length > 0) {
            $BrandCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: false,
                lazyLoad:true,
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    360: {
                        items: 1
                    },
                    460: {
                        items: 2
                    },
                    599: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    960: {
                        items: 4
                    },
                    1200: {
                        items: 5
                    },
                    1920: {
                        items: 5
                    }
                }
            });
        }
        /*---------------------------
           Team carousel
        ---------------------------*/
        var $teamCarousel = $('.team-carousel,.team-member-carousel');
        if ($teamCarousel.length > 0) {
            $teamCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: false,
                lazyLoad:true,
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 4
                    },
                    1920: {
                        items: 4
                    }
                }
            });
        }

        /*---------------------------
           Team carousel
        ---------------------------*/
        var $teamCharityHomeCarousel = $('.team-member-carousel-09');
        if ($teamCharityHomeCarousel.length > 0) {
            $teamCharityHomeCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: false,
                lazyLoad:true,
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }

        /*---------------------------
           Testimonial Two carousel
        ---------------------------*/
        var $testimonialTwoCarousel = $('.testimonial-carousel-two');
        if ($testimonialTwoCarousel.length > 0) {
            $testimonialTwoCarousel.owlCarousel({
                loop: false,
                autoplay: true, //true if you want enable autoplay
                autoPlayTimeout: 1000,
                margin: 30,
                dots: false,
                nav: false,
                lazyLoad:true,
                smartSpeed: 2000,
                rtl:sliderRtlValue,
                responsive: {
                    0: {
                        items: 1
                    },
                    460: {
                        items: 1
                    },
                    599: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    960: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    },
                    1920: {
                        items: 3
                    }
                }
            });
        }

    });


    //define variable for store last scrolltop
    var lastScrollTop = '';

    $(window).on('scroll', function () {

        //back to top show/hide
        var ScrollTop = $('.back-to-top');
        if ($(window).scrollTop() > 1000) {
            ScrollTop.fadeIn(1000);
        } else {
            ScrollTop.fadeOut(1000);
        }

        /*--------------------------
         sticky menu activation
        -------------------------*/
        var mainMenuTop = $('.navbar-area');
        if ($(window).scrollTop() > 1000 && $(window).width() > 991) {
            mainMenuTop.addClass('nav-fixed');
        } else {
            mainMenuTop.removeClass('nav-fixed ');
        }


    });


    $(window).on('load',function(){
        $('.navbar-nav li > ul.sub-menu').parent().addClass('menu-item-has-children');
        /*-----------------
            preloader
        ------------------*/
        var preLoder = $("#preloader");
        preLoder.fadeOut(1000);

        /*-----------------
            back to top
        ------------------*/
        var backtoTop = $('.back-to-top')
        backtoTop.fadeOut();

    });


})(jQuery);