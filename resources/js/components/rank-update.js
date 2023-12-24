import {wprtSendApiRequest} from './api-helper.js';
import {triggerPopup} from "./popup-helper";

(function ($) {
    $(document).ready(function () {

        // When the update button is pressed, it prints the keyword sequence to the screen.
        $('.wprt_keyword_list_table').on('click', 'td .wprt_update_icon', function (){
            const row = $(this).closest('.wprt_keyword_list_table_row');
            const id = row[0].getAttribute("data-keyword-id");
            const data = {
                'id': id,
            }
            triggerPopup('update', data)
        })
    });
})(jQuery);