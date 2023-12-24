import TomSelect from 'tom-select';
import {wprtSendApiRequest} from './api-helper.js';
import {triggerPopup, hidePopup, showLoadingStep} from './popup-helper.js';

(
    function ($) {
        $(document).ready(function () {
            $('.wprt_header_add_keyword').on('click', function () {
                triggerPopup('add')
            });

            $('.wprt_keyword_popup_form').on('submit', sendValue);

            $('.wprt_rank_result .wprt_keyword_popup_close_link').on('click', function () {
                hidePopup();

                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            $('.wprt_keyword_popup_form .wprt_keyword_popup_close_link, .wprt_rank_delete .wprt_keyword_popup_close_link, .wprt_rank_delete_cancel').on('click', function () {
                hidePopup();
            });
            
            if($('.wprt_keyword_popup_country_select').length > 0) {
                new TomSelect(".wprt_keyword_popup_country_select", {
                    maxOptions: 500,
                    create: true,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                });
            }

            function sendValue(e) {
                e.preventDefault();

                const submitButton = $(this).find('input[type="submit"]');
                submitButton.prop('disabled', true);

                const country = $('.wprt_keyword_popup_country_select');
                const keyword = $('.wprt_keyword_popup_content_keyword_tags');

                const params = {
                    keyword: keyword.val(),
                    country: country.val(),
                };

                showLoadingStep();
                wprtSendApiRequest('add', params)
            }
        });
    }
)(jQuery);