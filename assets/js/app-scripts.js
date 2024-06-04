(function ($) {
    $(document).ready(function () {
        const ajax = taiajax.ajaxurl;
        const burgerOpen = $('.header_burger_icon');
        const burgerClose = $('.header_close_icon');
        const header = $('#header');
        const isDesktop = $(window).width() > 1024;

        if (header.length && burgerOpen.length && burgerClose.length) {
            $(document).on('click', '.header_burger_icon, .header_close_icon', function () {
                $(header).toggleClass('active-menu');
            });
        }

        if (isDesktop) {
            const sectionHero = $('.hero_section');
            const heroBg = $('.hero__bg');
            if (sectionHero.length && heroBg.length) {
                const sectionHeroHeight = $(sectionHero).innerHeight();
                $(window).scroll(function () {
                    let scrollTop = $(this).scrollTop();
                    if (scrollTop < sectionHeroHeight) {
                        const baseX = -114;
                        const baseZ = -0.0006;
                        let x = scrollTop * 0.26;
                        let z = scrollTop * 0.0000005;
                        let scrollRight = baseX + x;
                        let scrollX = baseZ + z;
                        $(heroBg).css('transform', `matrix3d(1,0,0,${scrollX} ,0,1,0,.0001111,0,0,1,0,${scrollRight},0,0,1)`);
                    }
                });
            }
        }

        const selectHead = $('.select__head');
        if (selectHead.length) {
            selectHead.on('click', function (e) {
                const customSelect = $(this).closest('.custom_select');

                if (!customSelect) {
                    return false;
                }

                customSelect.toggleClass('select-show');
            });
        }
    });
})(jQuery);