@extends('layouts.admin')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.select2-selection__rendered {
    line-height: 31px;
}
.select2-selection .select2-selection--single {
    height: 35px;
}
.select2-selection__arrow {
    height: 34px;
}
</style>
@endsection


@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
        <x-filter-component form_id="search_form" action="home" method="GET" status="payments" advancefilters="hide" /> 
    </div>

    <div class="card">
     <!--    <div class="card-header">
          <div class="row">

            <div class="col-md-4">              
              @php 
              $get_all_merchants = Helpers::get_all_merchants();
              @endphp
              <label for="first_name">Select Merchant</label>
              <x-Merchants/>
              <select class="select2" id="merchant">
                @if(!empty($get_all_merchants))
                @foreach($get_all_merchants as $merchants)
                  <option value="{{$merchants->id}}">{{$merchants->merchant_name .' | ' . $merchants->contact_phone }}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-4">
              <label for="first_name"><strong>Payment Date Range</strong><For></For></label>
              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
              </div>
            </div>
            <div class="col-md-4">
              <label for="first_name"><strong>Transaction Filter</strong><For></For></label>
              <select class="form-control" id="status_filter">
                <option value="authorized">Successful</option>
                <option value="failed">Failed</option>
                <option value="pending">Pending</option>
                <option value="all">All</option>
              </select>
            </div>
          </div>
        </div>
 -->
        <div class="card-body">
          <!-- Small boxes (Stat box) -->
          <div class="row">            
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
              <div class="inner">
                <h3 id="order_count">{{count($orders)}}</h3>
                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
              <div class="inner">
                @php
                $total_amount=0;
                if(!empty($payments))
                {
                    foreach($payments as $payment)
                    {
                        $total_amount+=$payment->amount;
                    }
                }
                @endphp
                <h3 id="total_payment_amount">₹{{number_format($total_amount,2)}}</h3>
                <p>Total Payments Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ url('payments') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
              <div class="inner">
                <h3 id="success_rate_container">{{$success_perc}}<sup style="font-size: 20px">%</sup></h3>
                <p>Success Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- /.row -->

          <div class="row">
            <x-heigh-chart get="{{ json_encode(Request::all()) }}" />
          </div>

          <div class="row" style="margin-top: 30px;">            
            <div class="col-lg-6 col-6">
              <div class="row">
                <div class="col-lg-5">
                  
                </div>
                <div class="col-lg-2">
                  <!--<button id="btn-download1" class="btn btn-sm btn-info">Download</button>-->
                </div>
              </div>
              <canvas id="chart-line" style="width:100%; height: 400px; max-width:500px"></canvas>
            </div>
            <div class="col-lg-6 col-6">
              <div class="row">
                <div class="col-lg-5">
                  
                </div>
                <div class="col-lg-2">
                  <!--<button id="btn-download3" class="btn btn-sm btn-warning">Download</button>-->
                </div>
              </div>
              <canvas id="chart-line2" style="width:100%; height: 400px;max-width:500px"></canvas>
            </div>
          </div>



          <!--<div class="row" style="margin-top: 30px;">
            <div class="col-lg-6 col-6">
              <div id="myPlot" style="width:100%;max-width:700px"></div>
            </div>
            <div class="col-lg-6 col-6">
              <div id="piechart"></div>
            </div>
          </div>-->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  <div>
</section>

<input type="hidden" id="datepicker_start_date" name="datepicker_start_date" />
<input type="hidden" id="datepicker_end_date" name="datepicker_end_date" />
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script type="text/javascript">
$(function() {
  /*var start = moment().subtract(29, 'days');
  var end = moment();
  var start = moment().startOf('month');*/
  var start = moment();
  var end = moment();

  

  function cb(start, end) {
      $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  }

  $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb);
  cb(start, end);
});
</script>


<script>
$(document).ready(function() {

  $('.select2').select2();
  $("#merchant").select2({ width: '300px', dropdownCssClass: "bigdrop" });

  var start = moment();
  var end = moment();
  $("#datepicker_start_date").val(start.format('MMMM D, YYYY'));
  $("#datepicker_end_date").val(end.format('MMMM D, YYYY'));


  var ctx = $("#chart-line");
  var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: {!! $paymentxvalue1 !!},
          datasets: [{
              data: {{$paymentyvalue1}},
              label: "Monthly Payment Data",
              borderColor: "#"+Math.floor((Math.random() * 100) + 1)+"8af7",
              backgroundColor:'#'+Math.floor((Math.random() * 100) + 1)+'458af7',
              fill: false
          }]
      },
      options: {
          title: {
              display: true,
              text: 'Daily wise Monthly Payment (in INR)'
          }
      }
  });




  var ctx = $("#chart-line2");
  var myLineChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: {!! $orderxvalue1 !!},
          datasets: [{
              data: {{$orderyvalue1}},
              label: "Monthly Order Data",
              borderColor: "#"+Math.floor((Math.random() * 100) + 1)+"8af7",
              backgroundColor:'#'+Math.floor((Math.random() * 100) + 1)+'458af7',
              fill: false
          }]
      },
      options: {
          title: {
              display: true,
              text: 'Daily wise Monthly Order (in INR)'
          }
      }
  });
});
</script>


<script>
  var data = [{
  x: {!! $xValue !!},
  y: {{$yValue}},
  type: "bar"  }];
  var layout = {title:"Monthly Payment Data"};
  Plotly.newPlot("myPlot", data, layout);
</script>

<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
    ['Task', 'Transaction data Volume'],
    {!! $new_pie_chart_volume_data !!}
  ]);
    var options = {'title':'Transaction data Volume', 'width':550, 'height':400};
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }




  $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    var start_date = picker.startDate.format('YYYY-MM-DD');
    var end_date = picker.endDate.format('YYYY-MM-DD');

    $("#datepicker_start_date").val(picker.startDate.format('YYYY-MM-DD'));
    $("#datepicker_end_date").val(picker.endDate.format('YYYY-MM-DD'));


	  var status_filter = $("#status_filter").val();
    var merchant_id = $("#merchant").val();
	
	  $.ajax({
        url: '{{url("getsuccesstransactiongraphdata")}}',
        data: {start_date : start_date, end_date: end_date, status_filter: status_filter, merchant_id: merchant_id},
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){      
			console.log(data);    
			create_ajax_payment_chart(data.paymentxvalue1,data.paymentyvalue1);
			create_ajax_order_chart(data.orderxvalue1,data.orderyvalue1);
			$("#order_count").html(data.total_order);
			$("#total_payment_amount").html('₹'+(data.total_payment_amount).toFixed(2));
			$("#success_rate_container").html(data.success_perc+'<sup style="font-size: 20px">%</sup>');
        }
    });
});


$('#merchant').on('change', function(ev, picker) {
    var start_date = $("#datepicker_start_date").val();
    var end_date = $("#datepicker_end_date").val();
	  var status_filter = $("#status_filter").val();
    var merchant_id = $("#merchant").val();
	  $.ajax({
        url: '{{url("getsuccesstransactiongraphdata")}}',
        data: {start_date : start_date, end_date: end_date, status_filter: status_filter, merchant_id: merchant_id},
        type: "POST",
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(data){      
			console.log(data);    
			create_ajax_payment_chart(data.paymentxvalue1,data.paymentyvalue1);
			create_ajax_order_chart(data.orderxvalue1,data.orderyvalue1);
			$("#order_count").html(data.total_order);
			$("#total_payment_amount").html('₹'+(data.total_payment_amount).toFixed(2));
			$("#success_rate_container").html(data.success_perc+'<sup style="font-size: 20px">%</sup>');
        }
    });
});




function create_ajax_payment_chart(xValues,yValues){
	console.log(xValues);
	var canv = document.createElement("canvas");
	canv.width = 200;
	canv.height = 200;
	canv.setAttribute('id', 'chart-line');
	document.body.appendChild(canv);
	var C = document.getElementById(canv.getAttribute('id'));
	if (C.getContext) 
	{              
    	if (C.getContext) 
		{
			var ctx = $("#chart-line");
			var myLineChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: (xValues.trim()).split(','),
					datasets: [{
						data: (yValues.trim()).split(','),
						label: "Monthly Payment Data",
						borderColor: "#"+Math.floor((Math.random() * 100) + 1)+"8af7",
						backgroundColor:'#'+Math.floor((Math.random() * 100) + 1)+'458af7',
						fill: false
					}]
				},
				options: {
					title: {
						display: true,
						text: 'Daily wise Monthly Payment (in INR)'
					}
				}
			});
		}
	}
}


function create_ajax_order_chart(oxValues,oyValues){
	console.log(oxValues);
	var canv = document.createElement("canvas");
	canv.width = 200;
	canv.height = 200;
	canv.setAttribute('id', 'chart-line2');
	document.body.appendChild(canv);
	var C = document.getElementById(canv.getAttribute('id'));
	if (C.getContext) 
	{              
    	if (C.getContext) 
		{
			var ctx = $("#chart-line2");
			var myLineChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: (oxValues.trim()).split(','),
					datasets: [{
						data: (oyValues.trim()).split(','),
						label: "Order Payment Data",
						borderColor: "#"+Math.floor((Math.random() * 100) + 1)+"8af7",
						backgroundColor:'#'+Math.floor((Math.random() * 100) + 1)+'458af7',
						fill: false
					}]
				},
				options: {
					title: {
						display: true,
						text: 'Daily wise Monthly Order (in INR)'
					}
				}
			});
		}
	}

}
</script>

<script>
    $(function(){
      $('#status_filter').on('change', function () {
          var merchant = $("#merchant").val();
          var url = $(this).val(); 
          if (url) { 
              //window.location = '{{ url("/") }}/transactions/payments/status?status='+url; // redirect
			        window.open('{{ url("/") }}/transactions/payments/status?status='+url+'&merchant='+merchant, '_blank');
          }
          return false;
      });
    });
</script>
@endsection
