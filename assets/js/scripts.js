(function ($, window) {
    'use strict';
    $('.mcq-quiz-submission').on('submit', function (e) {
        e.preventDefault();
        const data = $(this).serialize();
        const ajax_data = {
            action: 'mcq_quiz_submission',
            data: data
        };

        $.post(mcq_quiz_submission.ajax_url, ajax_data, function (response) {
            $('.result').html("").append(response);
        });
    });
})(jQuery, window);