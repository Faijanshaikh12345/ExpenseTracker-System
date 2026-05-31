<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="ExpenseTracker Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ExpenseTracker Pro</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (auth()->user()->image)
                    <img src="{{ asset('uploads/avatars/' . auth()->user()->image) }}" class="img-circle elevation-2"
                        alt="User Image">
                @else
                    <img src="{{ asset('dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.index') }}" class="d-block">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Categories --}}
                <li class="nav-item {{ Request::is('categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Categories
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categories.create') }}"
                                class="nav-link {{ Request::is('categories/create') ? 'active' : '' }}">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Create Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}"
                                class="nav-link {{ Request::is('categories') ? 'active' : '' }}">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>Manage Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Payment Methods --}}
                <li class="nav-item {{ Request::is('payment-methods*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('payment-methods*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Payment Methods
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('payments.create') }}"
                                class="nav-link {{ Request::is('payment-methods/create') ? 'active' : '' }}">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Add Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payments.index') }}"
                                class="nav-link {{ Request::is('payment-methods') ? 'active' : '' }}">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>Manage Payments</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Transactions --}}
                <li class="nav-item {{ Request::is('transactions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Transactions
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transactions.create') }}"
                                class="nav-link {{ Request::is('transactions/create') ? 'active' : '' }}">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Add Transaction</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transactions.index') }}"
                                class="nav-link {{ Request::is('transactions') ? 'active' : '' }}">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>Manage Transactions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Reports --}}
                <li class="nav-item {{ Request::is('reports*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reports') }}"
                                class="nav-link {{ Request::is('reports/create') ? 'active' : '' }}">
                                <i class="far fa-file-alt nav-icon"></i>
                                <p>Generate Report</p>
                            </a>
                        </li>
                    </ul>
                </li>


                {{-- Profile --}}
                <li class="nav-item {{ Request::is('profile*') ? 'menu-open' : '' }}">
                    <a href="{{ route('profile.index') }}"
                        class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Your Profile</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>


                {{-- Logout --}}
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
