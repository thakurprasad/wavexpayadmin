
<aside class="main-sidebar sidebar-dark-primary elevation-4 overflow-auto">
    <!-- Brand Logo -->

    <a href="{{ route('home')}}" class="brand-link">
      <img src="{{ asset('/images/logo/materialize-logo.png')}}"
           alt="{{ config('app.name') }}"
           style="width:40%;border:0;align:center; margin:0 13px;">
           <span class="brand-text">WaveXPay</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/bower_components/admin-lte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-compact text-sm nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ in_array(Request::segment(1),array('home')) ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt" style="color: #f41811;"></i> <p>Dashboard</p> </a>
            </li>
            

            <li class="nav-item {{ in_array(Request::segment(1),array('payments','refunds','batch-refunds','orders','disputes')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('payments','refunds','batch-refunds','orders','disputes')) ? 'active' : '' }}"> <i class="nav-icon fas fa-users" style="color:#82a6e4;"></i> <p>Transactions <i class="right fas fa-angle-left" style="color:#82a6e4;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('payments.index') }}" class="nav-link {{ Request::segment(1) === 'payments' ? 'active' : null }}"><i class="nav-icon far fa-circle text-success"></i><p>Payments</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('refunds.index') }}" class="nav-link {{ Request::segment(1) === 'refunds' ? 'active' : null }}"><i class="nav-icon far fa-circle text-warning"></i><p>Refunds</p> </a></li>
                    <li class="nav-item"><a href="{{ route('batch-refunds.index') }}" class="nav-link {{ Request::segment(1) === 'batch-refunds' ? 'active' : null }}"><i class="nav-icon far fa-circle text-info"></i><p>Batch Refunds</p> </a></li>
                    <li class="nav-item"><a href="{{ route('orders.index') }}" class="nav-link {{ Request::segment(1) === 'orders' ? 'active' : null }}"><i class="nav-icon far fa-circle text-primary"></i><p>Orders</p> </a></li>
                    <li class="nav-item"><a href="{{ route('disputes.index') }}" class="nav-link {{ Request::segment(1) === 'disputes' ? 'active' : null }}"><i class="nav-icon far fa-circle text-danger"></i><p>Disputes</p> </a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('settlements.index') }}" class="nav-link {{ in_array(Request::segment(1),array('settlements')) ? 'active' : '' }}"> <i class="nav-icon far fa-plus-square" style="color: #f411c7;"></i> <p>Settlements</p> </a>
            </li>
            <li class="nav-item {{ in_array(Request::segment(1),array('invoice','item')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('invoice','item')) ? 'active' : '' }}"> <i class="nav-icon fas fa-users" style="color: #40f75f;"></i> <p>Invoice <i class="right fas fa-angle-left" style="color: #40f75f;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('invoice.index') }}" class="nav-link {{ Request::segment(1) === 'invoice' ? 'active' : null }}"><i class="nav-icon far fa-circle text-success"></i><p>Invoice</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('item.index') }}" class="nav-link {{ Request::segment(1) === 'item' ? 'active' : null }}"><i class="nav-icon far fa-circle text-warning"></i><p>Item</p> </a></li>
                </ul>
            </li>
            <li class="nav-header">Management</li>
            <li class="nav-item {{ in_array(Request::segment(1),array('users','roles')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('users','roles')) ? 'active' : '' }}"> <i class="nav-icon fas fa-users" style="color: #12e7fc;"></i> <p>Users & Role <i class="right fas fa-angle-left" style="color: #12e7fc;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link {{ Request::segment(1) === 'users' ? 'active' : null }}"><i class="nav-icon far fa-circle text-success"></i><p>Users</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link {{ Request::segment(1) === 'roles' ? 'active' : null }}"><i class="nav-icon far fa-circle text-warning"></i><p>Roles</p> </a></li>
                </ul>
            </li>
            <li class="nav-item {{ in_array(Request::segment(1),array('merchants','merchant-keys')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('merchants','merchant-keys')) ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt" style="color: #1106f6;"></i> <p>Merchants <i class="right fas fa-angle-left" style="color: #1106f6;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('merchants.index') }}" class="nav-link {{ in_array(Request::segment(1),array('merchants')) ? 'active' : '' }}"><i class="nav-icon far fa-circle text-success"></i> <p>Merchants</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('merchant-keys.index') }}" class="nav-link {{ in_array(Request::segment(1),array('merchant-keys')) ? 'active' : '' }}"><i class="nav-icon far fa-circle text-warning"></i> <p>Merchant Keys</p> </a> </li>
                </ul>
            </li>
            <li class="nav-item {{ in_array(Request::segment(1),array('settings','countries','states','payment-templates','email-templates','pages','dashboardheader')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('settings','countries','states')) ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt" style="color: #39fc12;"></i> <p>Settings <i class="right fas fa-angle-left" style="color: #39fc12;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('payment-templates.index') }}" class="nav-link {{ Request::segment(1) === 'payment-templates' ? 'active' : null }}"><i class="nav-icon far fa-circle text-success"></i><p>Payment Templates</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('email-templates.index') }}" class="nav-link {{ Request::segment(1) === 'email-templates' ? 'active' : null }}"><i class="nav-icon far fa-circle text-warning"></i><p>Email Templates</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('countries.index') }}" class="nav-link {{ Request::segment(1) === 'countries' ? 'active' : null }}"><i class="nav-icon far fa-circle text-info"></i><p>Countries</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('states.index') }}" class="nav-link {{ Request::segment(1) === 'states' ? 'active' : null }}"><i class="nav-icon far fa-circle text-primary"></i><p>States</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('pages.index') }}" class="nav-link {{ Request::segment(1) === 'pages' ? 'active' : null }}"><i class="nav-icon far fa-circle text-danger"></i><p>Pages</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('dashboardheader.index') }}" class="nav-link {{ Request::segment(1) === 'dashboardheader' ? 'active' : null }}"><i class="nav-icon far fa-circle text-danger"></i><p>Dashboard Header</p> </a> </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link {{ in_array(Request::segment(1),array('reports')) ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt" style="color: #f1fc12;"></i> <p>Reports <i class="right fas fa-angle-left" style="color: #f1fc12;"></i></p> </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-success"></i><p>Report A</p> </a> </li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Report B</p> </a> </li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-info"></i><p>Report C</p> </a> </li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-primary"></i><p>Report D</p> </a> </li>
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-danger"></i><p>Report E</p> </a> </li>
                </ul>
            </li>
            <li class="nav-header">Account</li>
            <li class="nav-item has-treeview {{ in_array(Request::segment(1),array('profile_update','change-password')) ? 'menu-open' : null }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user-circle" style="color: #f22323;"></i> <p>My Account <i class="right fas fa-angle-left" style="color: #f22323;"></i> </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ route('user.profile') }}" class="nav-link {{ Request::segment(1) === 'profile_update' ? 'active' : null }}"><i class="nav-icon far fa-circle text-success"></i><p>Profile Update</p> </a> </li>
                    <li class="nav-item"><a href="{{ route('change.password') }}" class="nav-link {{ Request::segment(1) === 'profile_update' ? 'active' : null }}"><i class="nav-icon far fa-circle text-warning"></i><p>Change Password B</p> </a> </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();    document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt nav-icon"></i> <p>Logout</p> </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </li>
        </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
