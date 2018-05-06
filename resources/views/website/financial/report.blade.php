@extends('website.layouts.app') 

@section('content')
<style>
    .filter-panel{
        padding:16px;
    }
    .filter-panel .col-md-2,
    .filter-panel .col-md-1{
        height: 48px;
        line-height: 48px;
    }
    .filter-panel button{
        line-height: initial;
        height: 34px;
    }
    .filter-panel input[type=text]{
        height: 48px;
    }
    @media (max-width: 1366px){
        .tab-shoppping-cart {
            width: calc(100% - 240px) !important;
        }
    }
</style>
<main class="site-main">
    <div class="container-inner">
        <div class="tab-shopping">
            <div class="tab-shoppping-cart">
                @include('website.sidemenu')

                <div class="tab-container">
                    <div id="tab-1" class="tab-panel active">
                        @if(\Session::has('success'))
                        <br>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ \Session::get('success') }}
                        </div>
                        @endif

                        @if(\Session::has('error'))
                        <br>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ \Session::get('error') }}
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div>
                                <h4 class="title-primary">Reports</h4>
                                <div class="filter-panel">
                                    <form method="GET" action="">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label>Filter: </label>
                                            </div>
                                            <div class="col-md-3">
                                                <select id="filter_type" name="filter_type" class="select2 select-detail" onchange="onFilterTypeChange(this)" style="width: 100%;">
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
                                                    <input name="start_date" id="start_date"  class="input-text" size="16" type="text" value="{{$sStartDate}}" data-date="{{$sStartDate}}" data-date-format="yyyy-mm-dd">
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="show-by-range col-md-1 hide">
                                                <label>To: </label>
                                            </div>
                                            <div class="show-by-range col-md-2 hide">
                                                <div class="input-append date">
                                                    <input name="end_date" id="end_date"  class="input-text" size="16" type="text" value="{{$sEndDate}}" data-date="{{$sEndDate}}" data-date-format="yyyy-mm-dd">
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="button">Report</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <p><em>Current commission rate: {{$commissionRate}}% (developer: {{$commissionRate}}%, site: {{100 - $commissionRate}}%)</em><p>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>App Id</th>
                                            <th>Image</th>
                                            <th>App Name</th>
                                            <th>Total Download ({{$summary->total_download}})</th>
                                            <th>Price</th>
                                            <th>Earned (${{number_format($summary->total_earned, 2)}})</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($reports as $list)
                                        <tr>
                                            <td>{{ $list->id }}</td>
                                            <td><img src="{{ url($list->apk_icon) }}" width="50"></td>
                                            <td><a href="{{route('webusers.apps.detail' , ['id' => $list->id])}}">{{$list->app_name}}</a></td>
                                            <td>{{$list->total_download}}</td>
                                            <td>{{$list->amount}}</td>
                                            <td>${{number_format($list->total_earned, 2)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-html-full-width" style=" border-top: none;display: inline-block;margin-top: 70px;padding: 0px 0;width: 100%;"></div>
</main>
@endsection

@push('scripts')
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
        $('#start_date').datepicker();
        $('#end_date').datepicker();


        onFilterTypeChange(document.getElementById('filter_type'));
    });
</script>
@endpush