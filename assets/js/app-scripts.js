(function($){
    $(document).ready(function() {
        const ajax = taiajax.ajaxurl;
        const burgerOpen = $('.header_burger_icon');
        const burgerClose = $('.header_close_icon');
        const header = $('#header');

        if (header.length && burgerOpen.length && burgerClose.length) {
            $(document).on('click', '.header_burger_icon, .header_close_icon', function () {
                $(header).toggleClass('active-menu');
            });
        }
    });
})(jQuery);