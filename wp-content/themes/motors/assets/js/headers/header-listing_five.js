(function ($) {
    $(document).ready(function () {

        var $this = $('.header-main.header-listing-fixed');
        var isAbsolute = $this.css('position') === 'absolute';

        $('.stm-menu-trigger').on('click', function(){
            $('.stm-opened-menu-listing').toggleClass('opened');
            $(this).toggleClass('opened');
            if($(this).hasClass('opened') && $(this).hasClass('stm-body-fixed')) {
                $('body').addClass('body-noscroll');
                $('html').addClass('no-scroll');
            } else {
                $('body').removeClass('body-noscroll');
                $('html').removeClass('no-scroll');
            }
        });

        stm_listing_fixed_header();
        $(window).on('load', stm_listing_fixed_header);
        $(window).on('resize', stm_listing_fixed_header);
        $(window).on('scroll', stm_listing_fixed_header);

        function stm_listing_fixed_header() {
            let header_main = $('.header-main'),
                header = $('#header')
            if (header_main.hasClass('header-listing-fixed')) {
                var currentScrollPos = $(window).scrollTop();
                var headerPos = header.offset().top;

                if (currentScrollPos > headerPos + 200) {
                    if( !isAbsolute ) header.attr('style', 'min-height: ' + header.outerHeight() + 'px;');
                    $this.addClass('stm-fixed-invisible');
                } else {
                    header.removeAttr('style');
                    $this.removeClass('stm-fixed-invisible');
                }

                if (currentScrollPos > headerPos + 400) {
                    header_main.addClass('stm-fixed');
                } else {
                    header_main.removeClass('stm-fixed');
                }
            }
        }

    });
})(jQuery)