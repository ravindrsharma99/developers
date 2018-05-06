@extends('website.layouts.app') @section('content')

<style>
    .s {
        height: 250px;
        margin: 0;
        overflow: hidden;
        padding: 0;
        position: relative;
        width: 250px;
    }

    .s1 {
        height: 160px;
        margin: 0;
        overflow: hidden;
        padding: 0;
        position: relative;
    }
</style>
<main class="site-main">
    <div class="container-inner">
        <div class="tab-shopping">
            <div class="tab-shoppping-cart">

                @include('website.sidemenu')

                <div class="tab-container" style="padding-top: 0px;">
                    <div id="tab-1" class="tab-panel active">

                        <div class="row">
                            <div class="col-main">
                                <div class="main-content">
                                    <div class="post-detail">
                                        <div class="post-item">
                                            <div class="product-item style-2" style="padding: 0px 0;margin: 0 0px;border-bottom: none;">
                                                <div class="product-inner">
                                                    <div class="product-thumb" style="padding: 0px 17px 10px 0;">
                                                        @if($app_detail['apk_icon'] !="" && file_exists($app_detail['apk_icon']))
                                                        <div class="thumb-inner s" style="background-image: url('{{url($app_detail['apk_icon']) }}');background-size: contain;background-repeat: no-repeat;background-position: center;border: 1px solid #a29c9c;">
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="product-innfo" style="padding: 0px 0 0 0;">
                                                        <h3 class="" style="color:orange">
                                                            <a href="javascript:;">{{$app_detail['app_name']}}</a>
                                                        </h3>
                                                        <span class="price">
                                                            <ins style="color:#a29c9c">{{$app_detail['Category']['name']}}</ins>
                                                        </span>

                                                        @if(count($app_detail['price'])>0) @if($app_detail['price'] == 'Free')
                                                        <span class="onnew" style="float: right;position: initial !important;background: #ff7f00">free</span>
                                                        @else
                                                        <span class="onnew" style="float: right;position: initial !important;background: #f24e3d">Paid</span>
                                                        @endif @endif
                                                        
                                                        @include('components.rating', ['rating' => $app_detail->average_rating])

                                                        <div class="inner" style="float: right;margin-top: 50px;">
                                                            <a href="{{url('step1/'.$app_detail['id'])}}" class="wishlist" style="background-color: #ff7f00;color: white">Update</a>
                                                            <a href="javascript:;" class="compare" data-toggle="modal" data-target="#myModal{{$app_detail['id']}}" style="background-color: #D73925;color: white">Delete</a>
                                                        </div>

                                                        <div id="myModal{{$app_detail['id']}}" class="fade modal modal-danger" role="dialog">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        <h4 class="modal-title">Delete App</h4>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to delete this App ?</p>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" style="background-color: #ff7f00">Close</button>
                                                                        <a href="{{ url('submitted_app/'.$app_detail['id'].'/destroy') }}" data-method="delete" name="delete_item">
                                                                            <button type="button" class="btn btn-outline" style="background-color: #ff7f00">Delete</button>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if(count($app_detail['price'])>0) @if($app_detail['price'] != 'Free')
                                                        <span class="star-rating" style="font-size: 25px;margin-top: 10px;">
                                                            {{$app_detail['amount']}}
                                                        </span>
                                                        @endif @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-product">
                                                <ul class="box-tabs style2">
                                                    <li>
                                                        <a href="#tab-1"></a>
                                                    </li>
                                                </ul>
                                                <div id="tab-1" class="tab-panel active">
                                                    <div class="owl-carousel nav-style6 equal-container" data-nav="true" data-autoplay="false" data-dots="false" data-loop="true"
                                                        data-margin="0" data-responsive='{"0":{"items":1},"480":{"items":2},"700":{"items":3},"1200":{"items":4},"1366":{"items":5}}'>
                                                        @foreach($image as $multi)
                                                        <div class="product-item style-1 equal-elem">
                                                            <div class="product-inner">
                                                                <div class="product-thumb">

                                                                    @if($multi['image'] !="" && file_exists($multi['image']))
                                                                    <div class="thumb-inner s1" style="background-image: url('{{url($multi['image']) }}');background-size: contain;background-repeat: no-repeat;background-position: center;">
                                                                    </div>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="post-metas" style="font-size: 18px;padding-top: 30px;padding-bottom: 0px;">
                                                <span class="icon icon-time">
                                                    <img src="{{ URL::asset('assets/website/images/blog/icon-calender.jpg') }}"
                                                        alt="icon">
                                                    <span>{{\Carbon\Carbon::parse($app_detail->create_at)->format('M,d,Y')}}</span>
                                                </span>
                                                <span class="icon icon-commment">
                                                    <img src="{{ URL::asset('assets/website/images/blog/icon-comment.jpg') }}"
                                                        alt="icon">
                                                    <span>{{$app_detail->total_comment}} comment</span>
                                                </span>
                                            </div>
                                            <div class="post-item-info" id="readmore">
                                                <div class="post-content">
                                                    <p>{{$app_detail->description}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="block-recently">
                                        <div class="title-top">
                                            <h3 class="title-block style2">ADDITIONAL INFORMATION</h3>
                                        </div>
                                        <div class="row">
                                            <div class="block-html">
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Package Name</h4>
                                                        <p class="html-info-p">{{$app_detail->package_id}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Version Name</h4>
                                                        <p class="html-info-p">{{$app_detail->version_number}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Version Code</h4>
                                                        <p class="html-info-p">{{$app_detail->version_code}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Support Email</h4>
                                                        <p class="html-info-p">{{$app_detail->support_email}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Company</h4>
                                                        <p class="html-info-p">{{$app_detail->company}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Contact Email</h4>
                                                        <p class="html-info-p">{{$app_detail->contact_email}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Total Download</h4>
                                                        <p class="html-info-p">{{$app_detail->total_download}}</p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-3 col-sm-6">
                                                    <div class="html-info">
                                                        <h4 class="html-info-h4">Category</h4>
                                                        <p class="html-info-p">{{$app_detail['Category']['name']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="post-comments">
                                        <div class="title-comment">Comments
                                            <span>({{$app_detail->total_comment}})</span>
                                        </div>
                                        <ol class="commments">
                                            @foreach($app_detail->getComments() as $comment)
                                            <li class="comment">
                                                <div class="comment-author">
                                                    <div class="avata">
                                                        <a href="#">
                                                            <img src="{{$comment->user ? $comment->user->getImage() : asset('assets/website/images/blog/admin1.jpg')}}" alt="{{$comment->user ? $comment->user->getTitle() : ''}}" style="width: 64px;height: 64px;border-radius:100%;">
                                                        </a>
                                                    </div>
                                                    <div class="des">
                                                        <span class="author-name">{{$comment->user ? $comment->user->getTitle() : ''}}
                                                            <span class="date-time">{{$comment->displayUpdatedAt()}}</span>
                                                        </span>
                                                        <p>{{$comment->comment}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sidebar">
                                <div class="sidebar-content">
                                    <div class="block-popular-post">
                                        <div class="block-title">Similar</div>
                                        <div class="block-popular-content">
                                            <ul class="popular-post">
                                                @foreach($releted_app as $list)
                                                <li class="has-post" style="padding: 18px 0">
                                                    <div class="item-photo">
                                                        <a href="{{url('app_detail/'.$list->id)}}">
                                                            <img src="{{url($list->apk_icon)}}" alt="p1" width="100" height="90">
                                                        </a>
                                                    </div>
                                                    <div class="item-detail" style="margin-top: 0px;">
                                                        <div class="item-name">
                                                            <a href="{{url('app_detail/'.$list->id)}}">{{$list->app_name}}</a>
                                                        </div>
                                                        <div class="item-athur" style="padding-top: 0px;">{{\Carbon\Carbon::parse($list->create_at)->format('M,d,Y')}}</div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-html-full-width" style=" border-top: none;display: inline-block;margin-top: 70px;padding: 0px 0;width: 100%;"></div>
</main>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="{{ URL::asset('assets/readmore.js') }}"></script>

<script>
    $("#readmore").readmore({
        speed: 500
    });
</script>

@endsection