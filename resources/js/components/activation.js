import {wprtSendApiRequest} from './api-helper.js';

(function ($) {
        $(document).ready(function () {
            $('.wprt_activation_license_submit').click(function (e){
                e.preventDefault();

                const licenseCode = $('.wprt_activation_license_input');
                const params = {
                    license: licenseCode.val(),
                };
                
                if(licenseCode.val().length > 0) {
                    wprtSendApiRequest('activation', params);
                }
            })
        })
    })(jQuery);