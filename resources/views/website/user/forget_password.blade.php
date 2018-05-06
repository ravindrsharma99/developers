@extends('website.layouts.app')
@section('content')

    <main class="site-main">
        <div class="container-wapper">
            <div class="row">
                <div class="col-md-10">
                    @if(\Illuminate\Support\Facades\Session::has('success'))
                        <br>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                        </div>
                    @endif
                        @if(\Illuminate\Support\Facades\Session::has('forgeterror'))
                            <br>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                {{ \Illuminate\Support\Facades\Session::get('forgeterror') }}
                            </div>
                        @endif
                    <h5 class="title-login">Lost password</h5>
                    <p class="p-title-login">Lost your password? Please enter your  email address. You will receive a link to create a new password via email.</p>

                    <form method="post" class="login" action="{{url('reset_password')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <p class="form-row form-row-wide">
                            <label for="email">Email Address <span class="note-impor">*</span></label>

                            <input type="email" value="" name="email" class="input-text">

                            @if ($errors->has('email'))
                                <span class="help-block" style="color: #ff7f00">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </p>

                        <p class="form-row">
                            <input type="submit" value="Send" name="Send" class="button-submit">
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
