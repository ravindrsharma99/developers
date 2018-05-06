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
                <li><a href="{{url('admin/appusers')}}"><i class="fa fa-dashboard"></i> Posts</a></li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('admin.forums.index')}}">Discussion</a> <i class="fa fa-caret-right" aria-hidden="true"></i> {{$discuss->getTitle()}} <i class="fa fa-caret-right" aria-hidden="true"></i> Posts</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="mainTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Posted By</th>
                            <th>Body</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($posts as $list)

                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>
                                    @if($list->user)
                                    <a href="{{$list->user->getAdminHref()}}">{{$list->user->getTitle()}}</a>
                                    @endif
                                </td>
                                <td>{!! $list->body !!}</td>
                                <td>
                                    <div class="btn-group-horizontal">
                                        {{--  <a class="btn btn-success" href="{{route('admin.forums.edit', ['id' => $list->id])}}"><i class="fa fa-edit"></i></a>  --}}

                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#myModal{{$list['id']}}"><i class="fa fa-trash"></i></button>

                                        {{--  <a href="{{url('admin/forums/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>  --}}

                                    </div>
                                </td>
                            </tr>

                            <div id="myModal{{$list['id']}}" class="fade modal modal-danger" role="dialog" >
                                {{ Form::open(array('url' => route('admin.posts.destroy', ['id' => $list->id]), 'method' => 'delete','style'=>'display:inline')) }}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete Post</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this Post ?</p>
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

<script>
    $(document).ready(function(){
        $('#mainTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0 ] }
            ]

        });
    });
</script>