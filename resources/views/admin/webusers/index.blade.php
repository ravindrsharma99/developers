@extends('admin.layouts.app')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Developers
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/webusers')}}"><i class="fa fa-dashboard"></i> Manage Developers</a></li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{ url('admin/webusers/create/') }}" ><button class="btn bg-orange margin" type="button">Add Manage Developers</button></a></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
							<th style="display:none;">Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Company Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($webusers as $list)

                            <tr>
                                <td style="display:none;">{{ $list['id'] }} </td>
                                <td>{{ $list['name'] }} </td>
                                <td>{{ $list['email'] }}</td>
                                <?php $country = \App\Countrie::where('id',$list['country'])->first(); ?>
                                <td>{{ $country['name'] }}</td>
                                <?php $state = \App\State::where('id',$list['state'])->first(); ?>
                                <td>{{ $state['name'] }}</td>
                                <?php $city = \App\Citie::where('id',$list['city'])->first(); ?>
                                <td>{{ $city['name'] }}</td>
                                <td>{{ $list['companyname'] }}</td>

                                <td>{!!  $list['status']=='active'? '<span style="display: inline-block;padding: 8px;" class="label label-success">Active</span>' : '<span style="display: inline-block;padding: 8px;" class="label label-danger">In-active</span>' !!}</td>

                                <td>
                                    <div class="btn-group-horizontal">
                                        {{ Form::open(array('url' => 'admin/webusers/'.$list['id'].'/edit', 'method' => 'get','style'=>'display:inline')) }}
                                        <button class="btn btn-success" type="submit" ><i class="fa fa-edit"></i></button>
                                        {{ Form::close() }}

                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash"></i></button>

                                        <a href="{{url('admin/webusers/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>

                                    </div>
                                </td>
                            </tr>

                            <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                {{ Form::open(array('url' => 'admin/webusers/'.$list['id'], 'method' => 'delete','style'=>'display:inline')) }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete Manage Developers</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this Manage Developers ?</p>
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
