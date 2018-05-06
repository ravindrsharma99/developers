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
                <h1>
                    {{ $menu }}
                    <small>Edit</small>
                </h1>

            </h1>
            <ol class="breadcrumb">
                <li><a href="javascript:;"><i class="fa fa-dashboard"></i> Staticpage </a></li>
            </ol>
        </section>

        <section class="content">
            <br>
            @include ('admin.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                                <h3 class="box-title">Edit Terms & Con.</h3>
                        </div>

                        {!! Form::model($staticpage, ['url' => url('admin/staticpage/' . $staticpage->id), 'method' => 'patch', 'class' => 'form-horizontal','files'=>true]) !!}

                            <div class="box-body">
                                @include ('admin.staticpage.form')
                            </div>

                            <div class="box-footer">
                                <button class="btn btn-info pull-right" type="submit">Edit</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


