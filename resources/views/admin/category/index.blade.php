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
                <li><a href="{{url('admin/category')}}"><i class="fa fa-dashboard"></i> {{ $menu }}</a></li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{ url('admin/category/create/') }}" ><button class="btn bg-orange margin" type="button">Add Category</button></a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example222" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($category as $list)

                            <tr>
                                <td style="display:none;">{{ $list['id'] }} </td>
                                <td>{{ $list['name'] }} </td>

                                <td>{!!  $list['status']=='active'? '<span style="display: inline-block;padding: 8px;" class="label label-success">Active</span>' : '<span style="display: inline-block;padding: 8px;" class="label label-danger">In-active</span>' !!}</td>

                                <td>
                                    <div class="btn-group-horizontal">
                                        {{ Form::open(array('url' => 'admin/category/'.$list['id'].'/edit', 'method' => 'get','style'=>'display:inline')) }}
                                        <button class="btn btn-success" type="submit" ><i class="fa fa-edit"></i></button>
                                        {{ Form::close() }}

                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash"></i></button>

                                        <a href="{{url('admin/category/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>

                                    </div>
                                </td>
                            </tr>

                            <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                {{ Form::open(array('url' => 'admin/category/'.$list['id'], 'method' => 'delete','style'=>'display:inline')) }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete Category</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this Category ?</p>
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
