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
                            <h3 class="box-title">View Discuss Detail</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Id</th>
                                    <td>{{$discuss->id}}</td>
                                </tr>

                                <tr>
                                    <th>Title</th>
                                    <td>{{$discuss->title}}</td>
                                </tr>
                                @if($discuss->user)
                                <tr>
                                    <th>Posted By</th>
                                    <td>{{$discuss->user->getTitle()}}</td>
                                </tr>
                                @endif

                                @if($discuss->category)
                                <tr>
                                    <th>Category</th>
                                    <td>{{$discuss->category->getTitle()}}</td>
                                </tr>
                                @endif

                                <tr>
                                    <th>Created At</th>
                                    <td>{{$discuss->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{$discuss->updated_at}}</td>
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
