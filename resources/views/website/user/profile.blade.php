@extends('website.layouts.app')

@section('content')
    <main class="site-main">

        <div class="container-inner">

            <div class="tab-shopping">

                <div class="tab-shoppping-cart">

                    @include('website.sidemenu')



                    <div class="tab-container">

                        <div id="tab-1" class="tab-panel active">

                            @if(\Illuminate\Support\Facades\Session::has('success'))

                                <br>

                                <div class="alert alert-warning alert-dismissible" role="alert">

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                    {{ \Illuminate\Support\Facades\Session::get('success') }}

                                </div>

                            @endif



                            <div class="col-md-8">



                                <h3 class="">Update your Account</h3>

                                <p class="p-title-login">Update ThirdEye Account details</p>



                                <form class="updateaccount" method="post" action="{{url('update_account')}}">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <p class="form-row form-row-wide">

                                        <label for="name">Name <span class="note-impor">*</span></label>

                                        {!! Form::text('name', $user->name, ['class' => 'input-text']) !!}

                                        @if ($errors->has('name'))

                                            <span class="help-block" style="color: red">

                                    <strong>{{ $errors->first('name') }}</strong>

                                </span>

                                        @endif

                                    </p>

                                    <p class="form-row form-row-wide">

                                        <label for="email">Email <span class="note-impor">*</span></label>

                                        {!! Form::text('email', $user->email, ['class' => 'input-text']) !!}

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
                                        {!! Form::select('country', [''=>'Please select'] + $country, !empty($user->country)?$user->country:null,['id'=>'country','class' => 'select2 select-detail','onchange'=> 'calltype(this.value);']) !!}
                                        @if ($errors->has('country'))
                                            <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                        @endif
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <label for="state">State <span class="note-impor">*</span></label>
                                        {{--                            {!! Form::text('state', null, ['class' => 'input-text']) !!}--}}
                                        {!! Form::select('state', [''=>'Please select'] + $state, !empty($user->state)?$user->state:null,['id'=>'state','class' => 'select2 select-detail','onchange'=> 'division(this.value);']) !!}
                                        @if ($errors->has('state'))
                                            <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                                        @endif
                                    </p>


                                    <p class="form-row form-row-wide">
                                        <label for="city">City <span class="note-impor">*</span></label>
                                        {{--                            {!! Form::text('city', null, ['class' => 'input-text']) !!}--}}
                                        {!! Form::select('city', [''=>'Please select'] + $city , !empty($user->city)?$user->city:null,['id'=>'city','class' => 'select2 select-detail']) !!}
                                        @if ($errors->has('city'))
                                            <span class="help-block" style="color: red">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                                        @endif
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <label for="companyname">Company name or Individual <span class="note-impor">*</span></label>
                                        {!! Form::text('companyname', $user->companyname, ['class' => 'input-text']) !!}
                                        @if ($errors->has('companyname'))
                                            <span class="help-block" style="color: red">
                                            <strong>{{ $errors->first('companyname') }}</strong>
                                        </span>
                                        @endif
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <label for="paypal_email">Paypal Email<span class="note-impor">*</span></label>
                                        {!! Form::text('paypal_email', $user->paypal_email, ['class' => 'input-text', 'placeholder' => 'Paypal email']) !!}
                                        @if ($errors->has('paypal_email'))
                                            <span class="help-block" style="color: red">
                                                <strong>{{ $errors->first('paypal_email') }}</strong>
                                            </span>
                                        @endif
                                    </p>

                                    <p class="form-row">

                                        <input type="submit" value="Update" name="Update" class="button-submit">

                                    </p>

                                </form>

                            </div>

                        </div>

                    </div>

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