import {wprtSendApiRequest} from "./api-helper";
import {triggerPopup} from "./popup-helper";

(function ($) {
    $(document).ready(function () {
        $('.wprt_keyword_list_table').on('click', '.wprt_keyword_list_table_delete_icon', function (){
            const data = $(this).closest('.wprt_keyword_list_table_row')[0];
            const id = data.getAttribute("data-keyword-id");
            const keyword = data.getAttribute("data-keyword-name");

            const params = {
                id: id,
                keyword: keyword,
            };

            triggerPopup('delete', params)
        });
    });
})(jQuery);