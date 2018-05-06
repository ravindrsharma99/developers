@extends('admin.layouts.app')
@section('content')


    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                Manage Developers
                <small>View</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/webusers')}}"><i class="fa fa-dashboard"></i> Manage Developers</a></li>
                <li class="active">View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Manage Developers Detail</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>

                                <tr>
                                    <th>Name</th>
                                    <td>{{$webusers->name}}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{$webusers->email}}</td>
                                </tr>

                                <tr>
                                    <th>Country</th>
                                    <?php $country = \App\Countrie::where('id',$webusers->country)->first(); ?>
                                    <td>{{ $country['name']}}</td>
                                </tr>

                                <tr>
                                    <th>State</th>
                                    <?php $state = \App\State::where('id',$webusers->state)->first(); ?>
                                    <td>{{$state['name']}}</td>
                                </tr>

                                <tr>
                                    <th>City</th>
                                    <?php $city = \App\Citie::where('id',$webusers->city)->first(); ?>
                                    <td>{{$city['name'] }}</td>
                                </tr>

                                <tr>
                                    <th>Company Name</th>
                                    <td>{{$webusers->companyname}}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>{{$webusers->status}}</td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{$webusers->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{$webusers->updated_at}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>

        <section class="content-header">
            <h1>
                App
                <small>Management</small>
            </h1>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-body table-responsive">
                    <table id="example22" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="display:none;">Id</th>
                            <th>App Name</th>
                            <th>App Icon</th>
                            <th>Support Email</th>
                            <th>Price</th>
                            <th>Version Name</th>
                            <th>Contact Email</th>
                            <th>Company</th>
                            <th>App Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($app as $key => $list)
                            @if($list['step'] == '4')
                                <tr>
                                    <td style="display:none;">{{ $list['id'] }} </td>
                                    <td>{{ $list['app_name'] }} </td>
                                    <td><img src="{{ url($list['apk_icon']) }}" width="80px" ></td>
                                    <td>{{ $list['support_email'] }}</td>
                                    <td>{{ $list['price'] }}</td>
                                    <td>{{ $list['version_number'] }}</td>
                                    <td>{{ $list['contact_email'] }}</td>
                                    <td>{{ $list['company'] }}</td>


                                    <td>
                                        <?php $status_selected = explode(",",$list['app_status']); ?>
                                        {!! Form::select('status', \App\NewApp::$app_status, !empty($status_selected)?$status_selected:null,['class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 70%','onchange'=> 'calltype(this.value,'.$list->id.');']) !!}
                                    </td>

                                    {{--<td>--}}
                                        {{--@if($list['app_status'] == 'pending')--}}
                                            {{--<div class="btn-group-horizontal" id="assign_remove_{{ $list['id'] }}" >--}}
                                                {{--<button class="btn btn-warning unassign ladda-button" data-style="slide-left" id="remove" ruid="{{ $list['id'] }}"  type="button"><span class="ladda-label">Pending</span> </button>--}}
                                            {{--</div>--}}
                                            {{--<div class="btn-group-horizontal" id="assign_add_{{ $list['id'] }}"  style="display: none"  >--}}
                                                {{--<button class="btn btn-success assign ladda-button" data-style="slide-left" id="assign" uid="{{ $list['id'] }}"  type="button"><span class="ladda-label">Approved</span></button>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                        {{--@if($list['app_status'] == 'approved')--}}
                                            {{--<div class="btn-group-horizontal" id="assign_add_{{ $list['id'] }}"   >--}}
                                                {{--<button class="btn btn-success assign ladda-button" id="assign" data-style="slide-left" uid="{{ $list['id'] }}"  type="button"><span class="ladda-label">Approved</span></button>--}}
                                            {{--</div>--}}
                                            {{--<div class="btn-group-horizontal" id="assign_remove_{{ $list['id'] }}" style="display: none" >--}}
                                                {{--<button class="btn  btn-warning unassign ladda-button" id="remove" ruid="{{ $list['id'] }}" data-style="slide-left"  type="button"><span class="ladda-label">Pending</span></button>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</td>--}}

                                    <td>
                                        <div class="btn-group-horizontal">
                                            <a href="{{url('admin/webusers/'.$webusers->id.'/'.$list['id'].'/app')}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>
                                        </div>
                                    </td>
                                </tr>

                                <div id="myModal{{$list['id']}}" class="fade modal" role="dialog" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {{ Form::open(array('url' => 'admin/statusremark/'.$list['id'], 'method' => 'get','style'=>'display:inline')) }}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Are you sure you want to Reject this App?</h4>
                                            </div>

                                            <div class="modal-body" style="height: 150px;">
                                                <div class="form-group" style="margin-bottom: 34px !important;">
                                                    <div class="col-sm-12">
                                                        {!! Form::textarea('remark', null, ['class' => 'form-control', 'id' => 'remark', 'placeholder' => 'Remark','rows'=>'5','cols'=>'5']) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn pull-left" data-dismiss="modal">Close</button>
                                                <button class="btn btn-default" type="submit">Update</button>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>

                                </div>


                                <div id="myModal_approved{{$list['id']}}" class="fade modal" role="dialog" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {{ Form::open(array('url' => 'admin/statusremark_approved/'.$list['id'], 'method' => 'get','style'=>'display:inline')) }}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Approved App</h4>
                                            </div>

                                            <div class="modal-body">
                                                <p>Are you sure you want to Approved this App?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn pull-left" data-dismiss="modal" onclick="status_display();">Close</button>
                                                <button class="btn btn-default" type="submit">Update</button>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>

                                <div id="myModal_pending{{$list['id']}}" class="fade modal" role="dialog" >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            {{ Form::open(array('url' => 'admin/statusremark_pending/'.$list['id'], 'method' => 'get','style'=>'display:inline')) }}
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Pending App</h4>
                                            </div>

                                            <div class="modal-body">
                                                <p>Are you sure you want to Pending this App?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn pull-left" data-dismiss="modal" onclick="status_display();">Close</button>
                                                <button class="btn btn-default" type="submit">Update</button>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
        <br><br>
        <!-- /.content -->
    </div>



@endsection


<script src="{{ URL::asset('assets/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.assign').click(function(){

            var user_id = $(this).attr('uid');
            var l = Ladda.create(this);
            l.start();
            $.ajax({
                url: '{{url('admin/api/cms/webusers/assign')}}',
                type: "post",
                data: {'id': user_id,'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
                success: function(data){
                    l.stop();
                    $('#assign_remove_'+user_id).show();
                    $('#assign_add_'+user_id).hide();
                }
            });
        });

        $('.unassign').click(function(){
            //alert('in');
            var user_id = $(this).attr('ruid');
            var l = Ladda.create(this);
            l.start();
            $.ajax({
                url: '{{url('admin/api/cms/webusers/unassign')}}',
                type: "post",
                data: {'id': user_id,'X-CSRF-Token' : $('meta[name=_token]').attr('content')},
                success: function(data){
                    l.stop();
                    $('#assign_remove_'+user_id).hide();
                    $('#assign_add_'+user_id).show();
                }
            });
        });
    });
</script>

<script>
    function calltype(val,vid){

        if(val == "rejected"){
            $('#myModal'+vid).modal({
                show: true
            });
        }

        if(val == "approved"){
            $('#myModal_approved'+vid).modal({
                show: true
            });
        }

        if(val == "pending"){
            $('#myModal_pending'+vid).modal({
                show: true
            });
        }

        if(val == '') val = 0;

        $.ajax({
            url: '{{ url('admin/app/status') }}/'+val +'/'+ vid,
            error:function(){
            },
            success: function(result){
                //  alert(result);
            }
        });
    }
</script>