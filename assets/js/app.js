(function ($) {
    $(document).ready(function () {

        var filter_btn = $('#filter-btn');
        if ($(filter_btn).length > 0) {
            $(document).on('click', '#filter_btn', function () {
                var form = $(this).closest('form');
                var form_data = new FormData(jQuery(form)[0]);

                form_data.append('action', 'get_posts_request');

                $.ajax({
                    type       : 'POST',
                    url        : wopajax.ajaxurl,
                    contentType: false,
                    cache      : false,
                    processData: false,
                    data       : form_data,
                    beforeSend : function () {
                        //preloader show
                    },
                    success    : function (response) {
                        if (response) {
                            $('#posts').html(response.result);
                        }

                        //preloader hide
                    },
                    error      : function (err) {
                        console.log('error', err);
                    }
                });
            });
        }

    });
})($);