jQuery(document).ready(function ($) {
        //load
        $(window).on('load', function () {
            base_scroll_to_top();
            mobile_toggle_sidebar();

        });

        //normal


        //Mobile toggle for sidebar
        function mobile_toggle_sidebar(){
            if ($('.mobile-toggle-sidebar').length) {
                $('.mobile-toggle-sidebar').prepend('<a class="close-mobile-toggle-sidebar" href="#"><i class="fa fa-times" aria-hidden="true"></i></a>');
                $('.mobile-toggle-sidebar').prepend('<a class="show-mobile-toggle-sidebar" href="#"><i class="fa fa-filter" aria-hidden="true"></i></a>');

                $(document).on('click', '.close-mobile-toggle-sidebar', function (cmts){
                    cmts.preventDefault();
                    $('.mobile-toggle-sidebar').removeClass('show');
                    $('.show-mobile-toggle-sidebar').removeClass('hide');
                });
                $(document).on('click', '.show-mobile-toggle-sidebar', function (smts){
                    smts.preventDefault();
                    $('.mobile-toggle-sidebar').addClass('show');
                    $('.show-mobile-toggle-sidebar').addClass('hide');
                });
            }
           
        }

        //Scroll To Top
        function base_scroll_to_top(){
            if ($('#back-to-top').length) {
                var scrollTrigger = 100, // px
                    backToTop = function () {
                        var scrollTop = $(window).scrollTop();
                        if (scrollTop > scrollTrigger) {
                            $('#back-to-top').addClass('show');
                        } else {
                            $('#back-to-top').removeClass('show');
                        }
                    };
                backToTop();
                $(window).on('scroll', function () {
                    backToTop();
                });
                $('#back-to-top').on('click', function (e) {
                    e.preventDefault();
                    $('html,body').animate({
                        scrollTop: 0
                    }, 100);
                });
            }
        }
});

