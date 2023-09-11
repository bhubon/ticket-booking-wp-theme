jQuery(document).ready(function ($) {
    $('.sponsor-logo-wrapper').on('click', function () {
        // ajax call
        $.ajax({
            url: $(this).data('ajax_url'),
            type: 'POST',
            data: {
                action: 'get_sponsor_details',
                id: $(this).data('id'),
            },
            success: function (response) {

                // console.log(response);

                $("#bem-popup-content").append(response);

                $('.bem-popup-wrapper').fadeIn();
            }
        });
    });

    $('.speaker-category').on('click', function () {
        // ajax call
        $.ajax({
            url: $(this).data('ajax_url'),
            type: 'POST',
            data: {
                action: 'get_categorized_speakers',
                id: $(this).data('id'),
            },
            success: function (response) {
                $("#speakers").empty().append(response);
            }
        });
    });

    $('.popup-close-btn, .popup-close-div').on('click', function () {

        $('.bem-popup-wrapper').fadeOut(500);

        setTimeout(function () {
            $("#bem-popup-content").empty();
        }, 500);
    });
});