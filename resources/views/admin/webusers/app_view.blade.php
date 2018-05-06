@extends('admin.layouts.app') @section('content')

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            App Detail
            <small>View</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="{{url('admin/webusers')}}">
                    <i class="fa fa-dashboard"></i> Manage Developers</a>
            </li>
            <li class="active">View</li>
        </ol>
    </section>

    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include ('admin.error')
                
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#information" aria-controls="home" role="tab" data-toggle="tab">Information</a>
                        </li>
                        <li role="presentation">
                            <a href="#reviews" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        
                        <div role="tabpanel" class="tab-pane active" id="information">

                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">View App Detail</h3>
                                </div>

                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>User Name</th>
                                                <td>{{$app['WebUser']['name']}}</td>
                                            </tr>

                                            <tr>
                                                <th>Apk File</th>
                                                <td>
                                                    <a href="{{url($app->file)}}" target="_blank"> APK link </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>App Image</th>
                                                <td>
                                                    @if($app['apk_icon']!="" && file_exists($app['apk_icon']))
                                                    <image src="{{url($app->apk_icon)}}" width="80px" /> @else
                                                    <img src="{{ url('assets/thum.png') }}" width="80px"> @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>App Name</th>
                                                <td>{{$app->app_name}}</td>
                                            </tr>

                                            <tr>
                                                <th>Package Name</th>
                                                <td>{{$app->package_id}}</td>
                                            </tr>

                                            <tr>
                                                <th>Version Name</th>
                                                <td>{{$app->version_number}}</td>
                                            </tr>

                                            <tr>
                                                <th>Version Code</th>
                                                <td>{{$app->version_code}}</td>
                                            </tr>

                                            <tr>
                                                <th>Category</th>
                                                <td>{{$app['Category']['name']}}</td>
                                            </tr>

                                            <tr>
                                                <th>Price</th>
                                                <td>{{$app->price}}</td>
                                            </tr>

                                            @if($app['price'] == "Price")
                                            <tr>
                                                <th>Amount</th>
                                                <td>{{$app->amount}}</td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th>Support Email</th>
                                                <td>{{$app->support_email}}</td>
                                            </tr>

                                            <tr>
                                                <th>Company</th>
                                                <td>{{$app->company}}</td>
                                            </tr>

                                            <tr>
                                                <th>Contact Email</th>
                                                <td>{{$app->contact_email}}</td>
                                            </tr>

                                            <tr>
                                                <th>Description</th>
                                                <td>{{$app->description}}</td>
                                            </tr>

                                            <tr>
                                                <th>Terms & Agree</th>
                                                <td>{{$app->terms_agree}}</td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>{!! $app['status']=='active'? '
                                                    <span class="label label-success">Active</span>' : '
                                                    <span class="label label-danger">In-active</span>' !!}</td>
                                            </tr>

                                            <tr>
                                                <th>App Status</th>
                                                <td>{{$app['app_status']}}</td>
                                            </tr>

                                            <tr>
                                                <th>Created At</th>
                                                <td>{{$app->created_at}}</td>
                                            </tr>

                                            <tr>
                                                <th>Updated At</th>
                                                <td>{{$app->updated_at}}</td>
                                            </tr>

                                            <tr>
                                                <th>Screenshot</th>
                                                <td>
                                                    @foreach($app['screenshot'] as $k=>$v)
                                                    <img src="{{url($v->image)}}" width="100"> @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Total Download</th>
                                                <td>{{$app->total_download}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- app reviews -->
                        <div role="tabpanel" class="tab-pane" id="reviews">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">App Reviews</h3>
                                </div>

                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>User name</th>
                                                <th>Comment</th>
                                                <th>Rating</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($app->getComments() as $comment)
                                            <tr>
                                                <td>
                                                    <img src="{{$comment->user ? $comment->user->getImage() : '' }}" alt="{{$comment->user ? $comment->user->getTitle() : ''}}" style="width: 64px;">
                                                </td>
                                                <td>{{$comment->user ? $comment->user->getTitle() : ''}}</td>
                                                <td>{{$comment->comment}}</td>
                                                <td>{{$comment->rating}} star(s)</td>
                                                <td>
                                                    {{$comment->displayUpdatedAt()}}
                                                </td>
                                                <td>
                                                    <div class="btn-group-horizontal">
                                                        <a class="btn btn-success" href="{{route('admin.reviews.edit', ['reviews' => $comment])}}"><i class="fa fa-edit"></i></a>
                           
                                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$comment['id']}}"><i class="fa fa-trash"></i></button>

                                                    </div>
                                                <td>
                                            </tr>

                                            <div id="myModal{{$comment['id']}}" class="fade modal modal-danger" role="dialog" >
                                                {{ Form::open(array('url' => 'admin/reviews/'.$comment['id'], 'method' => 'delete','style'=>'display:inline')) }}
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Delete Review</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this Review ?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-outline">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection