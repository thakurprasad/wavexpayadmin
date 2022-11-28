@php 
$status = app('request')->input('status');
@endphp
<div class="col-md-2">
    <select name="status" id="status" class="form-control">
        <option value="">Select Status</option>
        <option value="all">All</option>
        @foreach($options as $key=>$val)
            <option value="{{$key}}" <?php if(isset($status) && $status==$key) { echo 'selected="selected"'; } ?>>{{$val}}</option>
        @endforeach
    </select>
</div>