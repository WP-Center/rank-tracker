import $ from 'jquery'
import 'datatables.net-buttons/js/buttons.html5.min'

import Chart from 'chart.js/auto';

window.jQuery = window.$ = $

$(document).ready(function () {
    
    $('#wprt_keyword_list_detail_table').DataTable({
        dom: 'rtBip',
        order: [[0, 'desc']],
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                exportOptions: {
                    columns: [0, 1],
                }
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                exportOptions: {
                    columns: [0, 1],
                }
            },
        ]
    })

    const chartElement = $('#rankChart')[0];
    if (chartElement) {
        const rankXValues = chartElement.getAttribute("data-rank-x-value");
        const rankYValues = chartElement.getAttribute("data-rank-y-value");

        const xValues = rankXValues.split(',');
        const yValues = rankYValues.split(',');

        new Chart("rankChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: 'Position',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(26,131,193)",
                    borderColor: "rgba(26,131,193)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    y: {
                        reverse: true,
                        ticks: {
                            precision: 0,
                            stepSize: 50
                        }
                    }
                }
            }
        });
    }
});
