import {wprtSendApiRequest} from './api-helper.js';

(function ($) {
        $(document).ready(function () {
            $('.wprt_remove_license_submit').click(function (e) {
                e.preventDefault();
                if (confirm('This action will remove your license, do you approve?')) {
                    wprtSendApiRequest('remove-license', {});
                }
            })
        })
})(jQuery);