@extends('admin.layouts.app')
<style>

    .select2-container .select2-selection--single {
        height: 34px !important;
    }

</style>

@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $menu }}
                <small>Edit</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/forums')}}"><i class="fa fa-dashboard"></i> {{ $menu }}</a></li>
                <li class="active">Edit</li>
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
                            <h3 class="box-title">Edit a Discuss </h3>
                        </div>

                        {{--  <div class="pad margin no-print">
                            <div style="margin-bottom: 0!important;" class="callout callout-info">
                                <h4><i class="fa fa-info"></i> Note:</h4>
                               Leave <strong>Password</strong> and <strong>Confirm Password</strong> empty if you are not going to change the password.
                            </div>
                        </div>  --}}
                        <!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::model($discuss, ['url' => url('admin/forums/' . $discuss->id), 'method' => 'patch', 'class' => 'form-horizontal']) !!}
                            <div class="box-body">
                                @include ('admin.forums.discussions.form')
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url('admin/forums') }}" ><button class="btn btn-default" type="button">Back</button></a>
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
