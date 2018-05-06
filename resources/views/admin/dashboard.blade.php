@extends('admin.layouts.app')
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>

        <ol class="breadcrumb">
            <li class="active"><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       </ol>
    </section>


    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_web_user}}</h3>
                        <p>Total Developers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('admin/webusers') }}" class="small-box-footer">View Developers <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_approved_app}}</h3>
                        <p>Approved App</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumbs-o-up"></i>
                    </div>
                    <a href="{{ url('admin/approvedapp') }}" class="small-box-footer">View Approved App <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_pending_app}}</h3>
                        <p>Pending App</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pencil-square-o"></i>
                    </div>
                    <a href="{{ url('admin/pendingapp') }}" class="small-box-footer">View Pending App <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_rejected_app }}</h3>
                        <p>Rejected App</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-thumbs-o-down"></i>
                    </div>
                    <a href="{{ url('admin/rejectedapp') }}" class="small-box-footer">View Rejected App <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_app_user}}</h3>
                        <p>Total App Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('admin/appusers') }}" class="small-box-footer">View App Users <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $total_download_app}}</h3>
                        <p>Total Download App</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('admin/reports') }}" class="small-box-footer">View Reports <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>${{number_format($current_balance, 2) }}</h3>
                        <p>Balance</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('admin/payments') }}" class="small-box-footer">View Payments <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection