<div class="col-md-2">
	 <div class="form-group">
	    <label>WaveXpay Account</label>
		{!! Form::select('wavexpay_api_key_id', App\Models\WavexpayApiKey::get_api_key_categories_arr() , null, array('class' => 'form-control', 'id'=>'key_id', 'onchange'=>'get_merchants()' )) !!}
	</div>

</div>
<div class="col-md-2">
	<label>Merchant</label>
    <select class="form-control" id="merchant_id" name="merchant_id">
        <option value="">-- Select Merchant --</option>
        <option value="all">All</option>
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