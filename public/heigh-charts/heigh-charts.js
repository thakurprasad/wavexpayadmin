// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
function Highcharts_1(xAxis1, yAxis_1){
    Highcharts.chart('highchart_container', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Monthly Payments Structure'
        },
        subtitle: {
            text: 'Subtitle...'
        },
        xAxis: {
            categories: xAxis1,  /* ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], */
            accessibility: {
                description: 'Months of the year'
            }
        },
        yAxis: {
            title: {
                text: 'Amounts'
            },
            labels: {
                formatter: function () {
                    return '₹ ' + this.value ;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Paymets',
            marker: {
                symbol: 'square'
            },
            data: yAxis_1 //[5.2, 5.7, 8.7, 13.9, 18.2, 21.4, 25.0, 22.8, 17.5, 12.1, 7.6]

        }/*, {
            name: 'Bergen',
            marker: {
                symbol: 'diamond'
            },
            data:  [1.6, 3.3, 5.9, 10.5, 13.5, 14.5, 231.4, 11.5, 11018.7, 4.7, 2.6]
        }*/
        ]
    });
}

Highcharts_1(xAxis1, yAxis_1);