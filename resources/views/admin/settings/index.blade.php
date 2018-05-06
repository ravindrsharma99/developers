@extends('admin.layouts.app') @section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $menu }}
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{url('admin/appusers')}}">
                    <i class="fa fa-dashboard"></i> {{ $menu }}</a>
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                    <div>@include ('admin.error')</div>
                    <div class="box">
                        <form method="POST" action="{{url('admin/update-settings')}}">
                            @foreach($groups as $group) @if(isset($group['settings']) && !empty($group['settings']))
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{$group['title']}}</h3>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="row">
                                        @foreach($group['settings'] as $item)
                                        <div class="col-md-12">
                                            @if($item->setting_type == 'text')
                                            <div class="form-group">
                                                <label class="control-label">{{ucfirst($item->title)}} ({{$item->setting_key}})</label>
                                                @if($item->description)<p style="color: #666; font-style:italic;">{!! $item->description !!}</p>@endif
                                                <input type="text" name="{{$item->setting_key}}" class="form-control" value="{{$item->setting_value}}">
                                            </div>
                                            @elseif($item->setting_type == 'select')
                                            <div class="form-group">
                                                <label class="control-label">{{ucfirst($item->title)}} ({{$item->setting_key}})</label>
                                                @if($item->description)<p style="color: #666; font-style:italic;">{!! $item->description !!}</p>@endif
                                                <select class="form-control" name="{{$item->setting_key}}">
                                                    @foreach($item->options as $option)
                                                    <option value="{{$option->option_value}}" {{$option->option_value == $item->setting_value ? 'selected' : ''}}>{{$option->option_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endif @endforeach
                            <div class="box no-border">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                
            </div>
        </div>
    </section>
</div>
@endsection

<script src="{{ URL::asset('assets/jquery.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>
    Ladda.bind('input[type=submit]');
</script>