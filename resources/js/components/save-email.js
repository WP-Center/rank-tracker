import {wprtSendApiRequest} from './api-helper.js';

(function ($) {
    $(document).ready(function () {
        $('.wprt_settings_mail_submit').click(function (e){
            e.preventDefault();

            const email = $('.wprt_settings_mail_input');
            const params = {
                email: email.val(),
            };

            if(email.val().length > 0) {
                wprtSendApiRequest('save-email', params);
            }
        })
    })
})(jQuery);