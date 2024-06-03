(function ($) {
    $(document).ready(function () {
        const ajax = taiajax.ajaxurl;
        const burgerOpen = $('.header_burger_icon');
        const burgerClose = $('.header_close_icon');
        const header = $('#header');

        if (header.length && burgerOpen.length && burgerClose.length) {
            $(document).on('click', '.header_burger_icon, .header_close_icon', function () {
                $(header).toggleClass('active-menu');
            });
        }

        let currentMousePos = {x: -1, y: -1};
        const homeBg = $('.hero_section');
        if (homeBg.length) {
            $(homeBg).mousemove(function (event) {
                console.log(currentMousePos.x);
                console.log(currentMousePos.y);
                currentMousePos.x = event.pageX;
                currentMousePos.y = event.pageY;
                let img = $(this).find('img');

                var getOffset = $(img).offset();
                var getWidth = $(img).width() / 2;
                var getHeight = $(img).height() / 2;
                var centerX = getOffset.left + getWidth;
                var centerY = getOffset.top + getHeight;

                var rotateAmountX = (currentMousePos.x - centerX) * 0.000001;
                var rotateAmountY = (currentMousePos.y - centerY) * 0.000001;

                if (rotateAmountX > 0.0002) {
                    rotateAmountX = 0.0002;
                }
                if (rotateAmountX < -0.0002) {
                    rotateAmountX = -0.0002;
                }
                if (rotateAmountY > 0.0003) {
                    rotateAmountY = 0.0003;
                }
                if (rotateAmountY < -0.0003) {
                    rotateAmountY = -0.0003;
                }

                $(img).css('transform', 'matrix3d(1,0,0.00,' + rotateAmountX + ',0.00,1,0.00,' + rotateAmountY + ',0,0,1,0,0,0,0,1)');
            });   
        }
    });
})(jQuery);