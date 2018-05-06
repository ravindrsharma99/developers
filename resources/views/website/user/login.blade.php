@extends('website.layouts.app')
@section('content')

<main class="site-main">
        <div class="container-wapper">
            <div class="row">
                @if(\Illuminate\Support\Facades\Session::has('success'))
                    <br>
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ \Illuminate\Support\Facades\Session::get('success') }}
                    </div>
                @endif

                <div class="col-md-6">
                    <h5 class="title-login">Login</h5>
                    <p class="p-title-login">Hello, Welcome to your account.</p>

                    <form method="post" class="login" action="{{url('loggedin')}}">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <p class="form-row form-row-wide">
                            <label for="email_login">Email Address <span class="note-impor">*</span></label>
                            {!! Form::text('email_login', null, ['class' => 'input-text']) !!}
                            @if ($errors->has('email_login'))
                                <span class="help-block" style="color: red">
                                    <strong>
                                        @if($errors->first('email_login') == 'The email login field is required.')
                                            {{ 'The email field is required.' }}
                                        @else
                                            {{ $errors->first('email_login') }}
                                        @endif
                                    </strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password_login">Password <span class="note-impor">*</span></label>
                            <input type="password" name="password_login" class="input-text">
                            @if ($errors->has('password_login'))
                                <span class="help-block" style="color: red">
                                    <strong>
                                        <strong>
                                            @if($errors->first('password_login') == 'The password login field is required.')
                                                {{ 'The password field is required.' }}
                                            @else
                                                {{ $errors->first('password_login') }}
                                            @endif
                                        </strong>
                                    </strong>
                                 </span>
                            @endif
                        </p>

                        <ul class="inline-block">
                            <li class="inline-block-li"><input type="radio"><span class="input"></span>Remember me!</li>
                        </ul>

                        <a href="{{url('forgetpassword')}}" class="forgot-password">Forgot Your password ?</a>
                        <p class="form-row">
                            <input type="submit" value="Login" name="Login" class="button-submit">
                        </p>
                    </form>
                </div>

                <div class="col-md-6">
                    <h5 class="title-login">Create A New Account</h5>
                    <p class="p-title-login">Create your own Thirdeye account.</p>

                    <form class="register" method="post" action="{{url('registration')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <p class="form-row form-row-wide">
                            <label for="name">Name <span class="note-impor">*</span></label>
                            {!! Form::text('name', null, ['class' => 'input-text']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="email">Email <span class="note-impor">*</span></label>
                            {!! Form::text('email', null, ['class' => 'input-text']) !!}
                            @if ($errors->has('email'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="password">Password <span class="note-impor">*</span></label>
                            <input type="password" name="password" class="input-text">
                            @if ($errors->has('password'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('password') }}</strong>
                                 </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="inputPassword3">Confirm Password <span class="note-impor">*</span></label>
                            <input type="password" id="password-confirm" name="password_confirmation" class="input-text">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </p>


                        <p class="form-row form-row-wide">
                            <label for="state">Country <span class="note-impor">*</span></label>
                            {{--{!! Form::text('state', null, ['class' => 'input-text']) !!}--}}
                            {!! Form::select('country', [''=>'Please select'] + $country, null,['id'=>'country','class' => 'select2 select-detail','onchange'=> 'calltype(this.value);']) !!}
                            @if ($errors->has('country'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="state">State <span class="note-impor">*</span></label>
{{--                            {!! Form::text('state', null, ['class' => 'input-text']) !!}--}}
                            {!! Form::select('state', [''=>'Please select'], null,['id'=>'state','class' => 'select2 select-detail','onchange'=> 'division(this.value);']) !!}
                            @if ($errors->has('state'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </p>


                        <p class="form-row form-row-wide">
                            <label for="city">City <span class="note-impor">*</span></label>
{{--                            {!! Form::text('city', null, ['class' => 'input-text']) !!}--}}
                            {!! Form::select('city', [''=>'Please select'], null,['id'=>'city','class' => 'select2 select-detail']) !!}
                            @if ($errors->has('city'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide">
                            <label for="companyname">Company name or Individual <span class="note-impor">*</span></label>
                            {!! Form::text('companyname', null, ['class' => 'input-text']) !!}
                            @if ($errors->has('companyname'))
                                <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('companyname') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row form-row-wide" style="margin-top: 26px;">
                                <input type="checkbox" name="terms_agree" required>
                                <span class="input"></span>I agree with the <a href="{{url('terms')}}" target="_blank" style="color: orange">ThirdEye Software Developer Agreement</a>
                        </p>

                        <p class="form-row">
                            <input type="submit" value="Sign Up" name="Sign Up" class="button-submit">
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div class="block-html-full-width" style=" border-top: none;

    display: inline-block;

    margin-top: 70px;

    padding: 0px 0;

    width: 100%;"></div>
    </main>
@endsection

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