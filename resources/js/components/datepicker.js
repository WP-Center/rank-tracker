import moment from 'moment';
import daterangepicker from 'daterangepicker';

(
    function ($) {
        $(document).ready(function () {
            const urlParams = new URLSearchParams(window.location.search);
            let dateFrom = moment().add(-7, 'days');
            let dateTo = moment();
            if(urlParams.get('dateFrom') && urlParams.get('dateTo')) {
                dateFrom = moment( urlParams.get('dateFrom'));
                dateTo = moment( urlParams.get('dateTo'))._d;
            }

            const datePicker = new daterangepicker('.wprt_keyword_datepicker', {
                "autoApply": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "linkedCalendars": false,
                "showCustomRangeLabel": false,
                "alwaysShowCalendars": true,
                "startDate": dateFrom,
                "endDate": dateTo,
                "maxDate": moment(),
                "opens": "left",
                "drops": "auto",
                "locale": {
                    "format": 'D MMM Y'
                }
            }, function(start, end, label) {
                const url = new URL(window.location.href);
                const search_params = url.searchParams;
                search_params.set('dateFrom', start.format('YYYY-MM-DD'));
                search_params.set('dateTo', end.format('YYYY-MM-DD'));
                url.search = search_params.toString();
                window.location.href = url.toString();
            })
        });
    }
)(jQuery);