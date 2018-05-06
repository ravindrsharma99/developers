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
                            <h3 class="box-title">View AppUser Detail</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Id</th>
                                    <td>{{$appuser->id}}</td>
                                </tr>

                                <tr>
                                    <th>First Name</th>
                                    <td>{{$appuser->firstname}}</td>
                                </tr>

                                <tr>
                                    <th>Last Name</th>
                                    <td>{{$appuser->lastname}}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{$appuser->email}}</td>
                                </tr>

                                <tr>
                                    <th>Image</th>
                                    <td>
                                        @if($appuser['image']!="" && file_exists($appuser['image']))
                                            <img src="{{ url($appuser->image) }}" width="50">
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Phone</th>
                                    <td>{{$appuser->phone}}</td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td>{{$appuser->address}}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>{{$appuser->status}}</td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{$appuser->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{$appuser->updated_at}}</td>
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
