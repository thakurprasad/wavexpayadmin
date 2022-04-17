<nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home')}}" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        @php 
        $get_all_merchants = Helpers::get_all_merchants();
        @endphp
        @if(!empty($get_all_merchants))
        <select class="form-control" id="header_merchant_id" onchange="get_table_data()">
        <option value="">Select Merchant</option>
        @foreach($get_all_merchants as $merchants)
        <option value="{{$merchants->id}}">{{$merchants->merchant_name}}</option>
        @endforeach
        </select>
        @endif
        
      </li>
      <!--li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li-->
    </ul>




  </nav>
