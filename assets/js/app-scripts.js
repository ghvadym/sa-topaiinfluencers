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

        // let currentMousePos = {x: -1, y: -1};
        // const homeBg = $('.hero_section');
        // if (homeBg.length) {
        //     $(homeBg).mousemove(function (event) {
        //         console.log(currentMousePos.x);
        //         console.log(currentMousePos.y);
        //         currentMousePos.x = event.pageX;
        //         currentMousePos.y = event.pageY;
        //         let img = $(this).find('.hero__bg');
        //
        //         var getOffset = $(img).offset();
        //         var getWidth = $(img).width() / 2;
        //         var getHeight = $(img).height() / 2;
        //         var centerX = getOffset.left + getWidth;
        //         var centerY = getOffset.top + getHeight;
        //
        //         var rotateAmountX = (currentMousePos.x - centerX) * 0.000001;
        //         var rotateAmountY = (currentMousePos.y - centerY) * 0.000001;
        //
        //         if (rotateAmountX > 0.0002) {
        //             rotateAmountX = 0.0002;
        //         }
        //         if (rotateAmountX < -0.0002) {
        //             rotateAmountX = -0.0002;
        //         }
        //         if (rotateAmountY > 0.0003) {
        //             rotateAmountY = 0.0003;
        //         }
        //         if (rotateAmountY < -0.0003) {
        //             rotateAmountY = -0.0003;
        //         }
        //
        //         $(img).css('transform', 'matrix3d(1,0,0.00,' + rotateAmountX + ',0.00,1,0.00,' + rotateAmountY + ',0,0,1,0,0,0,0,1)');
        //     });
        // }

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
    });
})(jQuery);