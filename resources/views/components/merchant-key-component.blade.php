<div class="col-lg-3">
    <div class="form-group">
        @if(!empty($all_api_keys))
        <select class="form-control" id="key_id" onchange="get_merchants()">
        <option value="">Select Api Key </option>
        @foreach($all_api_keys as $key)
        <option value="{{$key->id}}">{{$key->test_api_key}} - {{$key->test_api_description}}</option>
        @endforeach
        </select>
        @endif
    </div>
</div>
<div class="col-md-3">
    <select class="form-control" id="merchant_id" name="merchant_id">
        <option value="">Select Merchant</option>
    </select>
</div>

<script type="text/javascript">
    function get_merchants(){
	var key_id = $("#key_id").val();
	$("#merchant_id").html('<option value="all">Select All</option>');
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "{{url('/merchants/getmerchantsbykey')}}",
		data: {'key_id': key_id},
		headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
		success: function(resp){
			if(resp.success==true){
				$(resp.data).each(function(index,value) {
					$("#merchant_id").append('<option value="'+value.id+'">'+value.merchant_name+'</option>');
				});

			}
		}
	});
  }
</script>