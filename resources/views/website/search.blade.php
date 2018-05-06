@extends('website.layouts.app')

@section('content')

    <style>

        .s{

            height: 250px;

            margin: 0;

            overflow: hidden;

            padding: 0;

            position: relative;

            width: 250px;

        }

    </style>

    <main class="site-main">
        <div class="container-inner">
            <div class="tab-shopping">
                <div class="tab-shoppping-cart">
                    @include('website.sidemenu')

                    <div class="tab-container" style="padding-top: 0px;">
                        <div id="tab-1" class="tab-panel active">
                            <div class="box-content">
                                <div class="toolbar-products">

                                    @if(\Illuminate\Support\Facades\Session::has('success'))
                                        <br>
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                                        </div>
                                    @endif

                                    @if(\Illuminate\Support\Facades\Session::has('danger'))
                                        <br>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ \Illuminate\Support\Facades\Session::get('danger') }}
                                        </div>
                                    @endif

                                    <div class="toolbar-option toolbar-option-top" style="border-bottom: none;" >
                                        <h4 class="title-primary">Search Apps</h4>

                                        @if(count($app_search)>0)
                                            <div class="products auto-clear">
                                                @foreach($app_search as $list)
                                                    <div class="product-item style-3">
                                                        <div class="product-inner">

                                                            <div class="product-thumb">
                                                                @if($list['apk_icon'] !="" && file_exists($list['apk_icon']))
                                                                    <div class="thumb-inner s" style="background-image: url({{$list['apk_icon'] }});



                                                                            background-size: contain;



                                                                            background-repeat: no-repeat;



                                                                            background-position: center;">
                                                                    </div>
                                                                @endif
                                                                <a href="{{url('app_detail/'.$list->id)}}" class="quick-view"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            </div>

                                                            <div class="product-innfo">
                                                                <div class="product-name"><a href="{{url('app_detail/'.$list->id)}}">{{$list['app_name']}}</a></div>

                                                <span class="star-rating">
                                                    <i class="@if($list['rate'] == '1' || $list['rate'] == '2' || $list['rate'] == '3' || $list['rate'] == '4' || $list['rate'] == '5') fa fa-star @else fa fa-star-o none @endif" aria-hidden="true"></i>
                                                    <i class="@if($list['rate'] == '2' || $list['rate'] == '3' || $list['rate'] == '4' || $list['rate'] == '5') fa fa-star @else fa fa-star-o none @endif" aria-hidden="true"></i>
                                                    <i class="@if($list['rate'] == '3' || $list['rate'] == '4' || $list['rate'] == '5') fa fa-star @else fa fa-star-o none @endif" aria-hidden="true"></i>
                                                    <i class="@if($list['rate'] == '4' || $list['rate'] == '5') fa fa-star @else fa fa-star-o none @endif" aria-hidden="true"></i>
                                                    <i class="@if($list['rate'] == '5') fa fa-star @else fa fa-star-o none @endif" aria-hidden="true"></i>
                                                </span>

                                                                <div class="hover-hidden">
                                                                    <p class="product-des">{{substr($list['description'],0,280)}} @if(strlen($list['description']) > 280 ) ... @endif</p>

                                                                    <div class="post-metas">
                                                                    <span class="icon icon-time"><img src="{{ URL::asset('assets/website/images/blog/icon-calender.jpg') }}" alt="icon">
                                                                        <span>{{\Carbon\Carbon::parse($list->create_at)->format('M,d,Y')}}</span>
                                                                    </span>
                                                                    </div>

                                                                    <div class="inner">
                                                                        {{--<a href="{{url('step1/'.$list['id'])}}" class="wishlist"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>--}}
                                                                        <a href="{{url('step1/'.$list['id'])}}" class="wishlist" style="background-color: #ff7f00;color: white">Update</a>
                                                                        {{--<a href="javascript:;" class="compare" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>--}}
                                                                        <a href="javascript:;" class="compare" data-toggle="modal" data-target="#myModal{{$list['id']}}" style="background-color: #D73925;color: white">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title">Delete App</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete this App ?</p>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" style="background-color: #ff7f00">Close</button>
                                                                    <a href="{{ url('submitted_app/'.$list['id'].'/destroy') }}" data-method="delete" name="delete_item">
                                                                        <button type="button" class="btn btn-outline" style="background-color: #ff7f00">Delete</button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @else
                                            <hr>
                                            <h2 style="padding-top: 5px">No Apps Found</h2>
                                        @endif

                                        @if(count($app_search)>0)
                                            <div class="toolbar-products" style="border-bottom: none;">
                                                <div class="toolbar-option toolbar-option-bottom">
                                                    <div class="pagination pagination-bottom">
                                                        <ul class="nav-links">
                                                            <li> @include('website.pagination.limit_links', ['paginator' => $app_search])</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection