// Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
function Highcharts_1(xAxis1, total_amounts, upi_amounts, wallet_amounts, netbanking_amounts, card_amounts){
    Highcharts.chart('highchart_container', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Monthly Payments Structure'
        },
        subtitle: {
            text: '' //'Subtitle...'
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
            name: 'Totals',
            marker: {
                symbol: 'square'
            },
            data: total_amounts //[5.2, 5.7, 8.7, 13.9, 18.2, 21.4, 25.0, 22.8, 17.5, 12.1, 7.6]

        }, 
        {
            name: 'UPI',
            marker: {
                symbol: 'diamond'
            },
            data:  upi_amounts
        }, 
        {
            name: 'Wallet',
            marker: {
                symbol: 'diamond'
            },
            data:  wallet_amounts
        }, 
        {
            name: 'Net Barnking',
            marker: {
                symbol: 'diamond'
            },
            data: netbanking_amounts
        }, 
        {
            name: 'Card',
            marker: {
                symbol: 'diamond'
            },
            data:  card_amounts
        }




        ]
    });
}

Highcharts_1(xAxis1, total_amounts, upi_amounts, wallet_amounts, netbanking_amounts, card_amounts)