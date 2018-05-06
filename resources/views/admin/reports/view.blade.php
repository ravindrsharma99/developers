@extends('admin.layouts.app')
@section('content')


    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                {{ $menu }}
                <small>View</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/appusers')}}"><i class="fa fa-dashboard"></i> {{ $menu }}</a></li>
                <li class="active">View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Payment Detail</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Id</th>
                                    <td>{{$payment->id}}</td>
                                </tr>

                                <tr>
                                    <th>App Image</th>
                                    <td>
                                        @if($payment->app)
                                        <img src="{{ url($payment->app->apk_icon) }}" width="50">
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>App Name</th>
                                    <td>
                                        @if($payment->app)
                                        {{$payment->app->getTitle()}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Developer Name</th>
                                    <td>
                                        @if($payment->owner)
                                        {{$payment->owner->getTitle()}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>User Name</th>
                                    <td>
                                        @if($payment->user)
                                        {{$payment->user->getTitle()}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Amount</th>
                                    <td>
                                        {{$payment->amount}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>{{$payment->status}}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{$payment->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{$payment->updated_at}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
