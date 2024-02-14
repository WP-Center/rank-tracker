import DataTable from 'datatables.net-dt';
import {wprtSendApiRequest} from "./api-helper";

(function ($) {
    $(document).ready(function () {
        if ($('#wprt_keyword_list_table').length > 0) {
            const datatable = new DataTable('#wprt_keyword_list_table', {
                dom: '<"wprt_keyword_list_table_title"><"wprt_keyword_datepicker_wrapper">frtBip',
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                },
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        text: 'PDF',
                        customize: function (doc) {
                            doc.content[1].table.body.forEach(row => {
                                row.splice(4);
                            });

                            for (let i = 0; i < doc.content[1].table.body.length; i++) {
                                if (i !== 0) {
                                    doc.content[1].table.body[i][2] = {
                                        text: doc.content[1].table.body[i][2].text.split(' ')[0] === 'Not' ? 'Not Exist' : doc.content[1].table.body[i][2].text.split(' ')[0],
                                        alignment: 'center',
                                        fillColor: doc.content[1].table.body[i][2].style === 'tableBodyOdd' ? '#f3f3f3' : null,
                                    };
                                }
                            }
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: {
                            columns: [0, 1, 2],
                        },
                        customize: function (csv) {
                            const rows = csv.split('\n');

                            const header = rows[0].split(',');
                            header.splice(4, 1);
                            rows[0] = header.join(',');

                            for (let i = 1; i < rows.length; i++) {
                                const columns = rows[i].split(',');

                                columns.splice(4, 1);

                                if (i !== 0) {
                                    columns[2] = columns[2].split(' ')[0].replace(/"/g, '') === 'Not' ? 'Not Exist' : columns[2].split(' ')[0].replace(/"/g, '')
                                }

                                rows[i] = columns.join(',');
                            }

                            csv = rows.join('\n');
                            return csv;
                        }
                    },
                ],
            });

            document.querySelector('div.wprt_keyword_datepicker_wrapper').innerHTML = '<input class="wprt_keyword_datepicker">';
            document.querySelector('div.wprt_keyword_list_table_title').innerHTML = 'Keyword List';

            // Show actions submenu
            datatable.on('click', '.wprt_keyword_list_table_buttons', function () {
                const submenu = $(this).parent('td').find('.wprt_keyword_list_table_submenu');

                if (submenu.hasClass('active')) {
                    $('.wprt_keyword_list_table_submenu').removeClass('active');
                } else {
                    $('.wprt_keyword_list_table_submenu').removeClass('active');
                    submenu.toggleClass('active')
                }
            });
        }
    });

    $(document).click(function (event) {
        if (!$(event.target).closest('.wprt_keyword_list_table_submenu, .wprt_keyword_list_table_buttons').length) {
            $('.wprt_keyword_list_table_submenu').removeClass('active');
        }
    });
})(jQuery);

