@extends('admin.layouts.app')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $menu }}
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/appusers')}}"><i class="fa fa-dashboard"></i> {{ $menu }}</a></li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                    {{--  <h3 class="box-title"><a href="{{ url('admin/payments/create/') }}" ><button class="btn bg-orange margin" type="button">Add Payment</button></a></h3>  --}}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="filter-panel">
                        <form method="GET" action="">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Filter Type: </label>
                                </div>
                                <div class="col-md-2">
                                    <select id="filter_type" name="filter_type" class="form-control input-sm" onchange="onFilterTypeChange(this)">
                                        <option value="all_time" {{$params['filter_type'] == 'all_time' ? 'selected' : ''}}>All Time</option>
                                        <option value="this_week" {{$params['filter_type'] == 'this_week' ? 'selected' : ''}}>This Week</option>
                                        <option value="today" {{$params['filter_type'] == 'today' ? 'selected' : ''}}>Today</option>
                                        <option value="this_month"  {{$params['filter_type'] == 'this_month' ? 'selected' : ''}}>This Month</option>
                                        <option value="range"  {{$params['filter_type'] == 'range' ? 'selected' : ''}}>Select Range</option>
                                    </select>
                                </div>
                                <div class="show-by-range col-md-1 hide">
                                    <label>From: </label>
                                </div>
                                <div class="show-by-range col-md-2 hide">
                                    <div class="input-append date">
                                        @php
                                            if(!isset($params['start_date'])){
                                                $today = strtotime('today');
                                                $startDate = strtotime("-7 days", $today);
                                                $sStartDate = date("Y-m-d", $startDate);
                                            }
                                            else{
                                                $sStartDate = $params['start_date'];
                                            }
                                            
                                            $sEndDate = isset($params['end_date']) ? $params['end_date'] : date("Y-m-d");
                                        @endphp
                                        <input name="start_date" id="start_date"  class="form-control input-sm" size="16" type="text" value="{{$sStartDate}}" data-date="{{$sStartDate}}" data-date-format="yyyy-mm-dd">
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="show-by-range col-md-1 hide">
                                    <label>To: </label>
                                </div>
                                <div class="show-by-range col-md-2 hide">
                                    <div class="input-append date">
                                        <input name="end_date" id="end_date"  class="form-control input-sm" size="16" type="text" value="{{$sEndDate}}" data-date="{{$sEndDate}}" data-date-format="yyyy-mm-dd">
                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Report</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table id="paymentTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>App Name</th>
                            <th>Developer</th>
                            <th>User name</th>
                            <th>Amount (${{$summary['total_amount']}})</th>
                            <th>Payment ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($payments as $list)
                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>
                                    @if($list->app)
                                    <img src="{{ url($list->app->apk_icon) }}" width="50">
                                    @endif
                                </td>
                                <td>
                                    @if($list->app)
                                    <a href="{{$list->app->getAdminHref()}}">{{$list->app->getTitle()}}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($list->owner)
                                    <a href="{{$list->owner->getAdminHref()}}">{{$list->owner->getTitle()}}</a>
                                    @endif
                                </td>
                                <td>
                                    @if($list->user)
                                    <a href="{{$list->user->getAdminHref()}}">{{$list->user->getTitle()}}</a>
                                    @endif
                                </td>
                                <td>{{ $list->amount ? '$' . $list->amount : '0' }}</td>
                                <td>{{ $list->transaction_id }}</td>
                                <td>{{ $list->status }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    <div class="btn-group-horizontal">
                                        <a href="{{url('admin/payments/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>

                                    </div>
                                </td>
                            </tr>
                     @endforeach
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

<script src="{{ URL::asset('assets/jquery.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>

<script>
    function onFilterTypeChange(ele){
        if(ele.value == 'range'){
            $('.show-by-range').removeClass('hide');
        }
        else{
            $('.show-by-range').addClass('hide');
        }
    }

    $(document).ready(function(){
        $('#paymentTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[ 9, "desc" ]],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 8 ] }
            ]

        });

        $('#start_date').datepicker();
        $('#end_date').datepicker();

        onFilterTypeChange(document.getElementById('filter_type'));
    });
</script>