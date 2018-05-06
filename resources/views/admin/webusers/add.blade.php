@extends('admin.layouts.app')
<style>

    .select2-container .select2-selection--single {
        height: 34px !important;
    }

</style>

@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                Manage Developers
                <small>Add</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/webusers')}}"><i class="fa fa-dashboard"></i> Manage Developers</a></li>
                <li class="active">Add</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Manage Developers </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::open(['url' => url('admin/webusers'), 'files'=>true, 'method' => 'post', 'class' => 'form-horizontal']) !!}

                            <div class="box-body">

                                @include ('admin.webusers.form')

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url('admin/webusers') }}" ><button class="btn btn-default" type="button">Back</button></a>
                                <button class="btn btn-info pull-right" type="submit">Add</button>
                            </div>
                            <!-- /.box-footer -->

                        {!! Form::close() !!}
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
