<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraApp</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/css/app.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- SEARCH FORM -->
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" v-model="search" @keyup="searchit" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit" @click="searchit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="/img/logo.png" alt="LaraApp" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">LaraApp</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/admin.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> {{ Auth::user()->name }} </a>
                        <a href="#" class="d-block"> Type: {{ Auth::user()->type }} </a>
                    </div>

                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <router-link to="/dashboard" class="nav-link">
                                <i class=" nav-icon fas fa-tachometer-alt blue-icon"></i>
                                <p>Dashboard</p>
                            </router-link>
                        </li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog blue-icon"></i>
                                <p>
                                    Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link to="/users" class="nav-link active">
                                        <i class="fas fa-users"></i>
                                        <p>Users</p>
                                    </router-link>
                                </li>

                            </ul>
                        </li>
                        @can('isAdmin')
                        <li class="nav-item">
                            <router-link to="/developer" class="nav-link">
                                <i class="nav-icon fas fa-user-cog "></i>
                                <p>
                                    Developer
                                </p>
                            </router-link>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon fas fa-user-alt blue-icon"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            {{-- <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a> --}}
                            {{-- laravel logout --}}
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-power-off red-icon"></i>
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside> --}}
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @auth
    <script>
        window.user = @json(auth()->user())
    </script>
    @endauth

    <script src="/js/app.js"></script>

</body>

</html>
