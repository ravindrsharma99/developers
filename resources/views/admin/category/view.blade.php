@extends('admin.layouts.app')
@section('content')


    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                {{ $menu }}
                <small>View</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/category')}}"><i class="fa fa-dashboard"></i> {{ $menu }}</a></li>
                <li class="active">View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Category Detail</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>Id</th>
                                    <td>{{$category->id}}</td>
                                </tr>

                                <tr>
                                    <th>Category Name</th>
                                    <td>{{$category->name}}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>{{$category->status}}</td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{$category->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{$category->updated_at}}</td>
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
