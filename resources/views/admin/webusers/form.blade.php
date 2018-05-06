<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="name">Name <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="email">Email <span class="text-red">*</span></label>

    <div class="col-sm-5">
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="inputPassword3">Password @if (!isset($appuser)) <span class="text-red">*</span> @else <span class="text-red">&nbsp;&nbsp;</span> @endif</label>
    <div class="col-sm-5">
        <input type="password" placeholder="Password" id="password" name="password" class="form-control" >
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="inputPassword3">Confirm Password @if (!isset($appuser)) <span class="text-red">*</span> @else <span class="text-red">&nbsp;&nbsp;</span> @endif</label>

    <div class="col-sm-5">
        <input type="password" placeholder="Confirm password" id="password-confirm" name="password_confirmation" class="form-control" >
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
             <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="country">Country <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {{--        {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'State']) !!}--}}
        {!! Form::select('country', [''=>'Please select'] + $country, null,['id'=>'country','class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 100%','onchange'=> 'calltype(this.value);']) !!}
        @if ($errors->has('country'))
            <span class="help-block">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="state">State <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {{--        {!! Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'State']) !!}--}}
        @if($mode == 'edit')
            {!! Form::select('state', [''=>'Please select'] + $state , null,['id'=>'state','class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 100%','onchange'=> 'division(this.value);']) !!}
        @else
            {!! Form::select('state', [''=>'Please select'] , null,['id'=>'state','class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 100%','onchange'=> 'division(this.value);']) !!}
        @endif

        @if ($errors->has('state'))
            <span class="help-block">
                <strong>{{ $errors->first('state') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="city">City <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {{--{!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City']) !!}--}}
        @if($mode == 'edit')
            {!! Form::select('city', [''=>'Please select'] + $city , null,['id'=>'city','class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 100%']) !!}
        @else
            {!! Form::select('city', [''=>'Please select'] , null,['id'=>'city','class' => 'select2 select2-hidden-accessible form-control', 'style' => 'width: 100%']) !!}
        @endif

        @if ($errors->has('city'))
            <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="companyname">Company Name <span class="text-red">*</span></label>
    <div class="col-sm-5">
        {!! Form::text('companyname', null, ['class' => 'form-control', 'placeholder' => 'Company Name']) !!}
        @if ($errors->has('companyname'))
            <span class="help-block">
                <strong>{{ $errors->first('companyname') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
    <label class="col-sm-2 control-label" for="role">Status <span class="text-red">*</span></label>

    <div class="col-sm-5">

        @foreach (\App\WebUser::$status as $key => $value)
            <label>
                {!! Form::radio('status', $key, null, ['class' => 'flat-red']) !!} <span style="margin-right: 10px">{{ $value }}</span>
            </label>
        @endforeach
        @if ($errors->has('status'))
            <span class="help-block">
             <strong>{{ $errors->first('status') }}</strong>
            </span>
        @endif
    </div>
</div>


<script type="text/javascript">
    function calltype(val){
        if(val == '') val = '';
        $.ajax({
            url: '{{ url('login/state/country') }}/'+ val,
            error:function(){
            },
            success: function(result){
                //alert(result);
                $("#state").empty();
                $("#state").html(result);
                $('#state').select2()
            }
        });
        var state=document.getElementById('state').value;
        //alert(region);
        division(state);
    }

    function division(state){
        //  alert(state);
        if(state == '') state = '';

        var country=document.getElementById('country').value;
        $.ajax({
            url: '{{ url('login/city') }}/'+state +'/'+country,
            error:function(){
            },
            success: function(result){
                //alert(result);
                $("#city").empty();
                $("#city").html(result);
                $('#city').select2()
            }
        });
    }
</script>