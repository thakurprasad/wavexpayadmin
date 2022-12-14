<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold" style="color: #00008B;">Payments Overview According to WaveXpay Accounts</h6>
    </div>
    <!-- Card Body -->
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="highchart_container_2"></div>
                <p class="highcharts-description">
                </p>
            </figure>
        </div>
    </div>
</div>
<?php $series = json_decode($series, true); 

?>
<script type="text/javascript">
let sss;
var loadJsonFromPHP = function(json) {
    sss = json;
    //console.log(json);
}

loadJsonFromPHP(<?php echo json_encode($series) ?>);


let dates_2 =  "{{ $dates }}";

<?php 
/*
let thakur = "{{ $thakur }}";
thakur = thakur.split(',');
thakur.forEach(stringToInt);

let manoj = "{{ $manoj }}";
manoj = manoj.split(',');
manoj.forEach(stringToInt);*/ ?>

 var x_axis_2 = dates_2.split(',');  
    
Highcharts.chart('highchart_container_2', {
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
            categories: x_axis_2,  /* ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], */
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
        series: sss /*[{
                        name: 'Thakur',
                        marker: {
                            symbol: 'diamond'
                        },
                        data: [100,22]
                    }, 
                    {
                        name: 'Manoj',
                        marker: {
                            symbol: 'diamond'
                        },
                        data: [22,12]
                    }
                ]*/

    });

</script>
