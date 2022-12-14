<?php /* <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style type="text/css" href="{{ asset('heigh-charts/css/style.css') }}"></style>
<script type="text/javascript" src="{{ asset('heigh-charts/heigh-charts-all.js') }}"></script>

<style type="text/css">
    table#highcharts-data-table-0 {
        width: 100%;
        border: 1px solid #ccc;
    }
    table#highcharts-data-table-0 th, table#highcharts-data-table-0 td {
        padding: 5px 20px;
        border: 1px solid #ccc;
    }
    text.highcharts-credits {
    display: none;
}
</style>
*/ ?>
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold" style="color: #00008B;">Payment Overview According to Payment Methods</h6>
    </div>
    <!-- Card Body -->
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="highchart_container"></div>
                <p class="highcharts-description">
                   <!-- highcharts-description .... -->
                </p>
            </figure>
        </div>
    </div>
</div>
<!-- <input type="button" name="" id="change_high_cart" value="hhhhh">  -->





<script type="text/javascript">

/*$("#change_high_cart").on('click', function(){ 
    alert('...');
    xAxis1 = ['A','B','C','FF','HH','OO'];
    yAxis_1 = [10,10,2,4,2,5];
    Highcharts_1(xAxis1, yAxis_1);
});*/


let Dates =  "{{ $dates }}";

let total_amounts = "{{ $total_amounts }}";
total_amounts = total_amounts.split(',');
total_amounts.forEach(stringToInt)


let card_amounts = "{{ $card_amounts }}";
card_amounts = card_amounts.split(',');
card_amounts.forEach(stringToInt)


let upi_amounts = "{{ $upi_amounts }}";
upi_amounts = upi_amounts.split(',');
upi_amounts.forEach(stringToInt)


let wallet_amounts = "{{ $wallet_amounts }}";
wallet_amounts = wallet_amounts.split(',');
wallet_amounts.forEach(stringToInt)

let netbanking_amounts = "{{ $netbanking_amounts }}";
netbanking_amounts = netbanking_amounts.split(',');
netbanking_amounts.forEach(stringToInt)

//console.log(xAxis1, total_amounts, upi_amounts, wallet_amounts, netbanking_amounts, card_amounts);

 var xAxis1 = Dates.split(',');  
    
let highchart_container_id = 'highchart_container';
let series_list = [{
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
                ];

Highcharts_1(xAxis1,series_list, highchart_container_id)

</script>
