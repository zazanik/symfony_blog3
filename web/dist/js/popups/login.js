(function ($) {

    $(document).ready(function () {

        var body = $('body');

        body.on('click', '.js-login', function () {

            body.find('.js-popup-login-overlay').removeClass('hidden');

        });

        body.on('click', '.js-popup-login-overlay', function () {

            body.find('.js-popup-login-overlay').addClass('hidden');

        });

        body.on('click', '#js-login-popup', function (e) {
            e.stopPropagation();
        })

    });

})(jQuery);