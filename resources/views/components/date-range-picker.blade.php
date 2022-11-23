<div class="form-group">
    <div id="{{$daterangepicker_id}}">&nbsp;
        <group>
        <i class="fa fa-calendar"></i>&nbsp;
        <span class="selected_filter"></span>&nbsp; 
        <i class="fa fa-caret-down"></i> &nbsp;
        </group>
        <span class="selected_date"></span>
        <input type="text" name="{{$daterangepicker_id}}" id="_{{$daterangepicker_id}}" style="display: none;">
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    var start = moment();
    var end = moment();
    var ranges = 'None';

    function cb(start, end, ranges) {
        if(ranges == 'None'){
            $('#{{$daterangepicker_id}} span.selected_date').html('');    

            $('#_{{$daterangepicker_id}}').val('');
        }else{
            $('#{{$daterangepicker_id}} span.selected_date').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));    

        $('#_{{$daterangepicker_id}}').val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        }
        

        $('#{{$daterangepicker_id}} .selected_filter').html(ranges);    
       // console.log(ranges) ;
    }

    $('#{{$daterangepicker_id}}').daterangepicker({
        startDate: start,
        endDate: end,
        autoUpdateInput:false,
        ranges: {
           'None': [],
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end, ranges);
});


</script>

<style type="text/css">

#{{$daterangepicker_id}} group {
    background-color: #F69321;
    padding: 6px 14px;
    color: white;
    margin-left: -13px;
    border-radius: 8px 0px 0px 7px;
    margin-right: 14px;
}
#{{$daterangepicker_id}} {
    cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;padding-left: 0px;
}
 
</style>