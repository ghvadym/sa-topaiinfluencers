(function ($) {
    $(document).ready(function () {
        const ajax = taiajax.ajaxurl;
        const nonce = taiajax.nonce;
        const burgerOpen = $('.header_burger_icon');
        const burgerClose = $('.header_close_icon');
        const header = $('#header');
        const isDesktop = $(window).width() > 1024;

        if ($(window).width() < 1320) {
            const morePostsSlider = new Swiper('.articles_slider', {
                slidesPerView: 'auto'
            });
        }
        
        if ($(window).width() < 1250) {
            const headerMenu = $('#header');
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    headerMenu.addClass('_scrolled');
                } else {
                    headerMenu.removeClass('_scrolled');
                }
            });
        }

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
                const form = $(this).closest('form.archive__filter_wrap');
                if (form.length) {
                    ajaxPosts($(form));
                    setFormStatus();
                }
            });
        }

        const articlesLoadBtn = $('#articles_load');
        if (articlesLoadBtn.length) {
            articlesLoadBtn.on('click', function (e) {
                const form = $('form.archive__filter_wrap');
                let pageNumber = $(this).attr('data-page');
                pageNumber = parseInt(pageNumber) + 1;

                if (form.length) {
                    ajaxPosts($(form), pageNumber);
                } else {
                    ajaxPosts(false, pageNumber);
                }
            });
        }

        const resetFilterBtn = $('.archive__filter_reset');
        if (resetFilterBtn.length) {
            resetFilterBtn.on('click', function (e) {
                const form = $(this).closest('form.archive__filter_wrap');
                if (form.length) {
                    resetFilter($(form));
                    ajaxPosts($(form));
                }
            });
        }

        function resetFilter(form)
        {
            if (!form) {
                return;
            }

            $(form).trigger('reset');

            const selectList = $('.archive__filter_item .custom_select');
            const formWrap = $('.archive__filter_wrap');

            if (selectList.length) {
                $(selectList).removeClass('select-show');
            }

            if (formWrap.length) {
                $(formWrap).removeClass('form-active');
            }
        }

        function setFormStatus()
        {
            const formWrap = $('.archive__filter_wrap');

            if (!formWrap.length) {
                return;
            }

            const filterInputs = $('.archive__filter_list input');

            if (!filterInputs.length) {
                return;
            }

            let formActive = false;

            jQuery.each(filterInputs, function (key, val) {
                if ($(val).is(':checked')) {
                    formActive = true;
                    return false;
                }
            });

            if (formActive) {
                $(formWrap).addClass('form-active');
            } else {
                $(formWrap).removeClass('form-active');
            }
        }

        function ajaxPosts(form, pageNumber)
        {
            let formData;

            if (form) {
                formData = new FormData($(form)[0]);
            } else {
                formData = new FormData();
            }

            const wrap = $('.archive__wrap');
            const posts = $('.archive__posts .articles');
            const loadMoreBtn = $('#articles_load');

            formData.append('action', 'archive_filter');
            formData.append('nonce', nonce);

            if (pageNumber) {
                formData.append('page', pageNumber);
            }

            if (loadMoreBtn.length) {
                const postType = $(loadMoreBtn).attr('data-type');
                if (postType) {
                    formData.append('post_type', postType);
                }
            }

            jQuery.ajax({
                type       : 'POST',
                url        : ajax,
                data       : formData,
                dataType   : 'json',
                processData: false,
                contentType: false,
                beforeSend : function () {
                    if (pageNumber) {
                        $(loadMoreBtn).addClass('btn-loading');
                    } else {
                        $(wrap).addClass('_spinner');
                    }
                },
                success    : function (response) {
                    if (pageNumber) {
                        $(loadMoreBtn).removeClass('btn-loading');
                    } else {
                        $(wrap).removeClass('_spinner');
                    }

                    if (response.posts) {
                        if (response.append) {
                            $(posts).append(response.posts);
                        } else {
                            $(posts).html(response.posts);
                        }

                        if (response.max_pages) {
                            if ((pageNumber && response.max_pages === pageNumber) || response.max_pages < 2) {
                                $(loadMoreBtn).hide();
                            } else {
                                $(loadMoreBtn).show();
                            }
                        }

                        $(loadMoreBtn).attr('data-page', pageNumber);
                    }
                },
                error      : function (err) {
                    console.log('error', err);
                }
            });
        }
    });
})(jQuery);