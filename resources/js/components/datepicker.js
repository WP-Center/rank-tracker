import moment from 'moment';
import daterangepicker from 'daterangepicker';

(
    function ($) {
        $(document).ready(function () {
            const datePicker = $('.wprt_keyword_datepicker').daterangepicker({
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
                "startDate": moment().add(-7, 'days'),
                "endDate": moment(),
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
                const new_url = url.toString();
                
                window.location.href = new_url;
            });


            const urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('dateFrom') && urlParams.get('dateTo')) {
                const dateFrom = urlParams.get('dateFrom');
                const dateTo = urlParams.get('dateTo');

                datePicker.data('daterangepicker').setStartDate(moment( dateFrom, datePicker.data().daterangepicker.format )._d);
                datePicker.data('daterangepicker').setEndDate(moment( dateTo, datePicker.data().daterangepicker.format )._d);
            }
        });
    }
)(jQuery);