<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
 
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold" style="color: #00008B;">Payment Overview</h6>
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
<style type="text/css" href="{{ asset('heigh-charts/css/style.css') }}"></style>




<script type="text/javascript">

/*$("#change_high_cart").on('click', function(){ 
    alert('...');
    xAxis1 = ['A','B','C','FF','HH','OO'];
    yAxis_1 = [10,10,2,4,2,5];
    Highcharts_1(xAxis1, yAxis_1);
});*/


function stringToInt(item, index, arr) {
  arr[index] = parseInt(item);
}

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
    
Highcharts_1(xAxis1, total_amounts, upi_amounts, wallet_amounts, netbanking_amounts, card_amounts)
</script>
<script type="text/javascript" src="{{ asset('heigh-charts/heigh-charts-all.js') }}"></script>
<style type="text/css">
    table#highcharts-data-table-0 {
        width: 50%;
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