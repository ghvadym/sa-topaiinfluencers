(function($){
    $(document).ready(function() {
        const ajax = admintaiajax.ajaxurl;
        const nonce = admintaiajax.nonce;

        const btn = $('#subscribers-get-by-api');
        if (btn.length) {
            $(document).on('click', '#subscribers-get-by-api', function () {
                const btn = $(this);
                const postId = $(this).data('id');

                jQuery.ajax({
                    type       : 'POST',
                    url        : ajax,
                    data       : {
                        'action' : 'update_subscribers',
                        'nonce'  : nonce,
                        'post_id': postId
                    },
                    beforeSend : function () {
                        $(btn).addClass('_spinner');
                    },
                    success    : function (response) {
                        $(btn).removeClass('_spinner');

                        if (response.success) {
                            location.reload();
                        }
                    },
                    error      : function (err) {
                        console.log('error', err);
                    }
                });
            });
        }
    });
})(jQuery);