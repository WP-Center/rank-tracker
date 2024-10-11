import {wprtSendApiRequest} from './api-helper.js';
import Swal from 'sweetalert2';

(function ($) {
    $(document).ready(function () {
        $('.wprt_settings_form').on('submit', function (e) {
            e.preventDefault();

            let self = $(this), data = new FormData(self[0]);

            const email = data.get('email');
            const frequency = data.get('frequency')
            const params = {
                email,
                frequency
            };
            const headers = {
                'X-WP-Nonce': wprtObject.apiNonce
            }

            if (params.frequency.length > 0) {
                Swal.fire({
                    title: wprtObject.locales.processing + '...',
                    didOpen: ()=> Swal.showLoading(),
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    heightAuto: false
                })

                wprtSendApiRequest('save-settings', params, headers);
            }
        })
    })
})(jQuery);