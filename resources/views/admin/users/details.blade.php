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
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{ $menu }}</li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{ url('admin/users/create/') }}" ><button class="btn bg-orange margin" type="button">Add User</button></a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($list as $list)

                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>{{ $list['name'] }}</td>
                                <td>{{ $list['email'] }}</td>
                                <td>{{ $list['role'] }}</td>
                                {{--<td>@if ($list['role']=="admin")   {!! '<a class="btn btn-success btn-flat btn-xs">Admin</a>' !!}  @elseif($list['role']=='event_admin') {!! '<a class="btn bg-purple btn-flat btn-xs">Event Admin</a>' !!} @elseif($list['role']=='operator') {!! '<a class="btn btn-danger btn-flat btn-xs">Operator</a>' !!} @endif  </td>--}}
                                {{--<td>{!!  $list['status']=='active'? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-active</span>' !!}</td>--}}

                                <td>{!!  $list['status']=='active'? '<span class="label label-success">Active</span>' : '<span class="label label-danger">In-active</span>' !!}</td>
                                <td><div class="btn-group-horizontal">

                                        {{ Form::open(array('route' => array('admin.users.show', $list['id']), 'method' => 'get','style'=>'display:inline')) }}
                                        <button class="btn btn-info" type="submit" ><i class="fa fa-eye"></i></button>
                                        {{ Form::close() }}

                                        {{ Form::open(array('url' => 'admin/users/'.$list['id'].'/edit', 'method' => 'get','style'=>'display:inline')) }}
                                        <button class="btn btn-success" type="submit" ><i class="fa fa-edit"></i></button>
                                        {{ Form::close() }}


                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash"></i></button>

                                    </div></td>
                            </tr>

                            <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                {{ Form::open(array('url' => 'admin/users/'.$list['id'], 'method' => 'delete','style'=>'display:inline')) }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete User</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this user ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-outline">Delete</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                {{ Form::close() }}
                            </div>
                        @endforeach
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>



        </section>

        <!-- Main content -->

        <!-- /.content -->
    </div>
@endsection

<script src="{{ URL::asset('assets/jquery.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>
