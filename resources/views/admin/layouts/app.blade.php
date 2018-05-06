<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thirdeye | {{ $menu }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker-bs3.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datepicker/datepicker3.css')}}">
    <!-- Icheck radio -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css')}}">
    <!-- SELECT  -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">

    <style type="text/css">
        .select2-container .select2-selection--single {
            height: 34px !important;
        }
    </style>
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- Bootstrap datatable -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap.css')}}">

    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="{{ url('admin/dashboard') }}" class="logo">
            <span class="logo-mini"><b>TE</b></span>
            <span class="logo-lg"><b>Thirdeye</b> Admin</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ URL::asset('assets/dist/img/avatar.png') }}" class="user-image"
                                 alt="User Image">
                            <span class="hidden-xs">{{ $user = Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ URL::asset('assets/dist/img/avatar.png') }}" class="img-circle"
                                     alt="User Image">
                                <p>
                                    {{ $user = Auth::user()->name }} <br>
                                    <small></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('admin/users/'.$user = Auth::user()->id).'/edit' }}"
                                       class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="@if($menu=='Dashboard') active  @endif treeview">
                    <a href="{{ url('admin/dashboard') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="treeview @if($mainmenu=='WebUser') active  @endif">
                    <a href="#">
                        <i class="fa fa-user"></i> <span>Manage Developers</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="@if(isset($menu) && $menu=='WebUser') active @endif">
                            <a href="{{ url('admin/webusers') }}"><i class="fa fa-circle-o"></i>Manage Developers </a></li>
                        <li class="@if(isset($menu) && $menu=='Approved') active @endif">
                            <a href="{{ url('admin/approvedapp') }}"><i class="fa fa-circle-o"></i>Approved App</a></li>
                        <li class="@if(isset($menu) && $menu=='Pending') active @endif">
                            <a href="{{ url('admin/pendingapp') }}"><i class="fa fa-circle-o"></i>Pending App</a></li>
                        <li class="@if(isset($menu) && $menu=='Rejected') active @endif">
                            <a href="{{ url('admin/rejectedapp') }}"><i class="fa fa-circle-o"></i>Rejected App</a></li>
                    </ul>
                </li>

                {{--<li class="@if($menu=='WebUser') active  @endif treeview">--}}
                    {{--<a href="{{ url('admin/webusers') }}">--}}
                        {{--<i class="fa fa-user"></i> <span>WebUser</span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                <li class="@if($menu=='Category') active  @endif treeview">
                    <a href="{{ url('admin/category') }}">
                        <i class="fa fa-clone"></i> <span>Category</span>
                    </a>
                </li>


                <li class="treeview @if($menu=='Staticpage') active  @endif">
                    <a href="#">
                        <i class="fa fa-file-text-o"></i> <span>Static Page</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="@if(isset($id) && $id=='1') active @endif">
                            <a href="{{ url('admin/staticpage/1/edit') }}"><i class="fa fa-circle-o"></i>Terms & Con.</a></li>
                    </ul>
                </li>

                <li class="@if($menu=='AppUser') active  @endif treeview">
                    <a href="{{ url('admin/appusers') }}">
                        <i class="fa fa-user"></i> <span>Manage App Users</span>
                    </a>
                </li>

                <li class="@if($menu == 'Forum Discussions') active  @endif treeview">
                    <a href="{{ url('admin/forums') }}">
                        <i class="fa fa-user"></i> <span>Manage Forum</span>
                    </a>
                </li>

                <li class="@if($menu=='reports') active  @endif treeview">
                    <a href="{{ url('admin/reports') }}">
                        <i class="fa fa-user"></i> <span>Reports</span>
                    </a>
                </li>

                <li class="@if($menu=='payments') active  @endif treeview">
                    <a href="{{ url('admin/payments') }}">
                        <i class="fa fa-user"></i> <span>Manage Payments</span>
                    </a>
                </li>

                <li class="@if($menu=='withdraw-requests') active  @endif treeview">
                    <a href="{{ url('admin/withdraw-requests') }}">
                        <i class="fa fa-user"></i> <span>Withdraw Requests</span>
                    </a>
                </li>

                <li class="@if($menu=='settings') active  @endif treeview">
                    <a href="{{ url('admin/settings') }}">
                        <i class="fa fa-user"></i> <span>Settings</span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    @yield('content')
    <footer class="main-footer">
        <strong>Thirdeye</strong>
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- jQuery 2.2.0 -->
<script src="{{ URL::asset('assets/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script type="text/javascript">
    $('.calltype').click(function () {
        alert(this.val());
    });
</script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap datatables -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<!-- Select2 -->
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>


<script>
    $(function () {

        $(".select2").select2();
//Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        $("#example11").DataTable();
        $("#example3").DataTable({"paging": false});
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 7 ] }
            ]

        });

        $('#example22').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 9 ] }
            ]

        });
        $('#example222').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 3 ] }
            ]

        });


        $('#example51').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true
        });

        $('#reservation').daterangepicker({
            format: 'YYYY/MM/DD'
        });

        $('#datepicker').datepicker({
            format: 'yyyy-m-d',
            autoclose: true
        });

//Timepicker
        $(".timepicker").timepicker({
            showInputs: false,
            showMeridian: false,
        });


    });
</script>
{{--@yield('jquery')--}}
        <!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>


<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
<!-- Morris.js charts -->

<!-- InputMask -->
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ URL::asset('assets/plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ URL::asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::asset('assets/plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{ URL::asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ URL::asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ URL::asset('assets/plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('assets/dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{ URL::asset('assets/dist/js/pages/dashboard.js')}}"></script>--}}

<script src="{{ URL::asset('assets/dist/js/demo.js')}}"></script>
@yield('jquery')
</body>
</html>
