@php 
    $get = app('request')->input();
@endphp

 {!! Form::model($get, ['method' => $method , 'id' => $form_id , 'url'=> $action ]) !!}
    @csrf 
    <div class="row" style="padding-left: 10px;">
        <div class="col-sm-5">
            <div class="form-group">
                <label>Created Date Range</label>
                <x-date-range-picker id="daterangepicker" label="Select Date Range" />
            </div>
        </div>

        <x-merchant-key-component />
        <x-dropdown-component status="{{$status}}" />
    </div>
  
   <!--  <div class="col-md-12"> 
        <input type="button" onclick="show_hide('show')" name="advance-filters" class="btn btn-link btn-sm show-advance-filters" value="Show Advance Filters">
        <input type="button" onclick="show_hide('hide')" name="advance-filters" class="btn btn-link btn-sm hide-advance-filters" value="Hide Advance Filters" style="display: none;">
    </div>  -->
    <div class="advance-filters" style="display:none;" id="advance_filters_section">
        <div class="row col-md-12">                
            @yield('advance_filters')
        </div>
    </div>

    <div class="row col-md-12" style="padding-left: 10px;">
        <div class="col-md-8"> </div>
        <div class="col-md-2 col-sm-2">
            <div class="form-group pad-30">
                <button type="submit" class="btn btn-primary btn-block" id="filter_data_btn">Serach</button>
            </div>
        </div>
        <div class="col-md-2 col-sm-2">
            <div class="form-group pad-30">
                <button type="button" class="btn btn-secondary btn-block"  onclick="reset_page()" id="filter_reset_btn">Reset</button>
            </div>
        </div>
    </div> 

{!! Form::close() !!}

<script type="text/javascript">
    function show_hide(action){
        if(action == 'show'){
            $(".advance-filters").show(300);
            $(".show-advance-filters").hide(100);
            $(".hide-advance-filters").show(100);
        }else{
            $(".advance-filters").hide(300);
            $(".show-advance-filters").show(100);
            $(".hide-advance-filters").hide(100);
        }
    }

    function reset_page()
    {
        window.location = '{{url($action)}}';
    }

    // create js varibale which data in get request
    var get_data = [];
    <?php 
    foreach ($get as $name => $val) { ?>
        get_data['<?= $name ?>'] = '<?= $val ?>';
    <?php } ?>
    
   get_merchants();
    
    $("#{{ $form_id }} input[type=text]").each(function() {
        var  name = $(this).attr('name');
        $(this).val(get_data[name]);
    });

     $("#{{ $form_id }} select").each(function() {
        var  name = $(this).attr('name');
        $(this).val(get_data[name]);
    });

    $("#advance_filters_section input[type=text]").each(function() {
            var  name = $(this).attr('name');
            if((get_data[name]).length>0){
                show_hide('show');
            }
    });

    $("#advance_filters_section select").each(function() {
            var  name = $(this).attr('name');
            if((get_data[name]).length>0){
                show_hide('show');
            }
    });


$( document ).ready(function() {
     setTimeout( 
        function(){           
            $("#merchant_id").val(get_data['merchant_id']);
            $("#_daterangepicker").val(get_data['daterangepicker']);
         },     
        1000 
    );
});

</script>

<style type="text/css">
.pad-30{
    padding-top: 30px;
}
 
#search_form{
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px 0px;
    background: #e3e6f0;

}
</style>