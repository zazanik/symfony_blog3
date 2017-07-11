(function ($) {

    $(document).ready(function () {

        var body = $('body');

        body.on('click', '.js-register', function () {

            body.find('.js-popup-register-overlay').removeClass('hidden');

        });

        body.on('click', '.js-popup-register-overlay', function () {

            body.find('.js-popup-register-overlay').addClass('hidden');

        });

        body.on('click', '#js-register-popup', function (e) {
            e.stopPropagation();
        })

    });

})(jQuery);