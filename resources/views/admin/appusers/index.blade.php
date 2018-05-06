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
                    <h3 class="box-title"><a href="{{ url('admin/appusers/create/') }}" ><button class="btn bg-orange margin" type="button">Add AppUser</button></a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($appusers as $list)

                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>{{ $list['firstname'] }} </td>
                                <td>{{ $list['lastname'] }}</td>
                                <td>{{ $list['email'] }}</td>
                                <td>
                                    @if($list['image']!="" && file_exists($list['image']))
                                        <img src="{{ url($list->image) }}" width="50">
                                    @endif
                                </td>
                                <td>{{ $list['phone'] }}</td>

                                <td>{!!  $list['status']=='active'? '<span style="display: inline-block;padding: 8px;" class="label label-success">Active</span>' : '<span style="display: inline-block;padding: 8px;" class="label label-danger">In-active</span>' !!}</td>

                                <td>
                                    <div class="btn-group-horizontal">
                                        {{ Form::open(array('url' => 'admin/appusers/'.$list['id'].'/edit', 'method' => 'get','style'=>'display:inline')) }}
                                        <button class="btn btn-success" type="submit" ><i class="fa fa-edit"></i></button>
                                        {{ Form::close() }}

                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash"></i></button>

                                        <a href="{{url('admin/appusers/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>

                                    </div>
                                </td>
                            </tr>

                            <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                {{ Form::open(array('url' => 'admin/appusers/'.$list['id'], 'method' => 'delete','style'=>'display:inline')) }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete AppUser</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this AppUser ?</p>
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
        </section>
    </div>
@endsection

<script src="{{ URL::asset('assets/jquery.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>
