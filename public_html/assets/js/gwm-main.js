/**
 * GWM Main JS
 * Custom scripts for the new frontend UI
 * ponytail: uses native IntersectionObserver instead of AOS library
 */

(function($) {
    "use strict";

    $(document).ready(function() {
        
        // 1. Custom Scroll Animation Observer (replaces AOS)
        var animatedElements = document.querySelectorAll('[data-gwm-anim]');
        
        if (animatedElements.length > 0 && 'IntersectionObserver' in window) {
            // Pre-set animation delays from data attributes
            animatedElements.forEach(function(el) {
                var delay = el.getAttribute('data-gwm-delay');
                if (delay) {
                    el.style.animationDelay = delay + 'ms';
                }
            });

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('gwm-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15,
                rootMargin: '0px 0px -40px 0px'
            });

            animatedElements.forEach(function(el) {
                observer.observe(el);
            });
        } else {
            animatedElements.forEach(function(el) {
                el.classList.add('gwm-visible');
            });
        }

        // 2. Also init AOS if present (backward compat for pages not yet migrated)
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 50,
                delay: 100
            });
        }

        // 3. Navbar Scroll Behavior
        var $navbar = $('.gwm-navbar');
        var stickyThreshold = 50;
        
        function handleNavbarScroll() {
            if ($(window).scrollTop() > stickyThreshold) {
                $navbar.removeClass('gwm-navbar-transparent').addClass('gwm-navbar-solid');
            } else {
                $navbar.removeClass('gwm-navbar-solid').addClass('gwm-navbar-transparent');
            }
        }

        if ($navbar.length && $navbar.hasClass('gwm-navbar-transparent-start')) {
            handleNavbarScroll();
            $(window).on('scroll', function() {
                handleNavbarScroll();
            });
        }

        // 4. Smooth Scroll for Anchor Links
        $('a.gwm-smooth-scroll').on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                var offset = 80;
                
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - offset
                }, 800, function(){});
            }
        });

        // 5. Counter Up Initialization
        if ($.fn.counterUp) {
            $('.gwm-counter-number').counterUp({
                delay: 10,
                time: 1500
            });
        } else {
            $('.gwm-counter-number').each(function () {
                var $this = $(this);
                $({ Counter: 0 }).animate({ Counter: $this.text() }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
        }
        
    });

    // 6. Preloader fade out
    $(window).on('load', function() {
        var $preloader = $('.gwm-preloader');
        if ($preloader.length) {
            $preloader.fadeOut('slow', function() {
                $(this).remove();
            });
        }
    });

})(jQuery);
