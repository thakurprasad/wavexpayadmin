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