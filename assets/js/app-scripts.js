(function ($) {
    $(document).ready(function () {
        const ajax = taiajax.ajaxurl;
        const nonce = taiajax.nonce;
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

        const selectItems = $('.select__item input');
        if (selectItems.length) {
            selectItems.on('change', function (e) {
                ajaxPosts($(this).closest('form.archive__filter_wrap'));
            });
        }

        function ajaxPosts(form)
        {
            if (!form) {
                return;
            }

            const formData = new FormData($(form)[0]);
            const wrap = $('.archive__posts');

            formData.append('action', 'archive_filter');
            formData.append('nonce', nonce);

            jQuery.ajax({
                type       : 'POST',
                url        : ajax,
                data       : formData,
                dataType   : 'json',
                processData: false,
                contentType: false,
                beforeSend : function () {
                    $(wrap).addClass('_spinner');
                },
                success    : function (response) {
                    $(wrap).removeClass('_spinner');

                    if (response) {

                    }
                },
                error      : function (err) {
                    console.log('error', err);
                }
            });
        }
    });
})(jQuery);