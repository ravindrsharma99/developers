@extends('admin.layouts.app')


@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $menu }}
                <small>Edit</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->


        <section class="content">

            @include ('admin.error')
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">EDIT USERS </h3>
                        </div>

                        <div class="pad margin no-print">
                            <div style="margin-bottom: 0!important;" class="callout callout-info">
                                <h4><i class="fa fa-info"></i> Note:</h4>
                               Leave <strong>Password</strong> and <strong>Confirm Password</strong> empty if you are not going to change the password.
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::model($user, ['url' => url('admin/users/' . $user->id), 'method' => 'patch', 'files'=>true, 'class' => 'form-horizontal']) !!}
                            <div class="box-body">
                                @include ('admin.users.form')
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-info pull-right" type="submit">Edit</button>
                            </div>
                            <!-- /.box-footer -->
                        {{ Form::close() }}
                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
