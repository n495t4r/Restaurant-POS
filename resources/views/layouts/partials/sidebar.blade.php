<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-purple elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset('images/pevalogo.png') }}" alt="PEVA Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
	<!-- Log on to codeastro.com for more projects -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->getAvatar() }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('users.edit', auth()->user()->getID()) }}" class="d-block">{{ auth()->user()->getFullname() }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    <a href="{{route('home')}}" class="nav-link {{ activeSegment('') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('product-list'))
                    <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Products</p>
                    </a>
                    @endif
                </li>
                
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('customer-list'))
                    <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                @endif
                </li>
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('pos-system'))
                    <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>POS System</p>
                    </a>
                @endif
                </li>
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('order-list'))
                    <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Orders</p>
                    </a>
                @endif
                </li>
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('kitchen-display'))
                    <a href="{{ route('kitchen.index') }}" class="nav-link {{ activeSegment('kitchen') }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Kitchen Display</p>
                    </a>
                @endif
                </li>
                <li class="nav-item has-treeview">
                
                    <a href="{{ route('expenses.index') }}" class="nav-link {{ activeSegment('expenses') }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Expenses</p>
                    </a>
                
                </li>
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('settings'))
                    <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                @endif
                </li> 
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('user-list'))
                    <a href="{{ route('users.index') }}" class="nav-link {{ activeSegment('users') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                @endif
                </li>
                <li class="nav-item has-treeview">
                @if(auth()->user()->hasPermission('role-list'))
                    <a href="{{ route('roles.index') }}" class="nav-link {{ activeSegment('roles') }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Roles</p>
                    </a>
                @endif
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                        <form action="{{route('logout')}}" method="POST" id="logout-form">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div><!-- Log on to codeastro.com for more projects -->
    <!-- /.sidebar -->
</aside>
