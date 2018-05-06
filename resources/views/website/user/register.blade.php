@extends('website.layouts.app')

@section('content')


    <div class="wrap-breadcrumb">
        <div class="container">
            <div class="zoo-breadcrumb-container">
            <span>
                <a class="zoo-breadcrumb-url zoo-breadcrumb-home" href="{{url('/')}}">
                    Home
                </a>
            </span>
                <span role="presentation" class="zoo-breadcrumb-separator"> <i class="fa fa-angle-right"></i></span>
                <span>
                   My Account
                </span>
            </div>
        </div>
    </div>
    <br>
    <main id="main" class="single-page" role="main">
        <div class="container">

            <div class="woocommerce">

                <div class="wrap-login" id="customer_login">

                    <div class="register form">

                        <h3>Register</h3>

                        <form method="post" class="register" action="{{url('registration')}}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                {{--<img style="padding: 1px;" src="{{ URL::asset('resource/login-register/fblogin.png')}}">--}}

                                {{--<img style="padding: 1px;" src="{{ URL::asset('resource/login-register/googlelogin.png')}}">--}}

                                {{--<p class="col-xs-12 col-sm-12 space"><span>or</span></p>--}}

                            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                                <label for="email">Full Name <span style="color: red;">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="name" id="name" value=""/>
                                @if ($errors->has('name'))
                                    <span class="help-block" style="color: red">
                            <strong>
                                {{ $errors->first('name') }}</strong>
                        </span>
                                @endif
                            </p>

                            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                                <label for="email">Email <span style="color: red;">*</span></label>
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="email" value=""/>
                                @if ($errors->has('email'))
                                    <span class="help-block" style="color: red">
                            <strong>
                                {{ $errors->first('email') }}</strong>
                        </span>
                                @endif
                            </p>
                            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                                <label for="password">Password <span style="color: red;">*</span></label>
                                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password"
                                       id="password"/>
                                @if ($errors->has('password'))
                                    <span class="help-block" style="color: red">
                            <strong>
                                {{ $errors->first('password') }}</strong>
                        </span>
                                @endif
                            </p>

                            {{--<div class="form-group">--}}
                                {{--<label class="col-sm-2 control-label" for="subcategory">Subategory</label>--}}
                                {{--<div class="col-sm-8">--}}
                                    {{--<select class="col-sm-12 col-xs-12"  name="subcategory_id" id="subcategory">--}}
                                        {{--<option value="">Please Select</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <p  class="form-row">
                                <label for="role">Role <span style="color: red;">*</span></label>
                                <select class="col-sm-12 col-xs-12"  name="role" id="role">
                                    <option value="">Please Select</option>
                                    <option value="instructor">Instructor</option>
                                    <option value="student">Student</option>

                                </select>
                                {{--<label for="student" class="inline">--}}
                                    {{--<input class="woocommerce-Input woocommerce-Input--radio" name="role" type="radio" id="student"  value="student"/> Student </label>--}}

                                {{--<label for="instructor" class="inline">--}}
                                    {{--<input class="woocommerce-Input woocommerce-Input--radio" name="role" type="radio"  id="instructor" value="instructor"/> Instructor </label>--}}

                                @if ($errors->has('role'))
                                    <span class="help-block" style="color: red">
                                   <strong>
                                {{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </p>
                            <p class="form-row" style="margin-top: 20px;">
                                <input type="submit" class="woocommerce-Button button" name="register"
                                       value="Register"/>
                            </p>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </main> <!-- #main -->
<br>
@endsection
