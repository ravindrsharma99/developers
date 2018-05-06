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
                                <h3 class="">Payment</h3>
                                <p class="p-title-login">Paypal Payment.</p>

                                <form class="updatepayment" method="post" action="{{url('payment_update')}}">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <p class="form-row form-row-wide">
                                        <label for="name"></label>
                                        {!! Form::text('name', null, ['class' => 'input-text']) !!}
                                        @if ($errors->has('name'))
                                            <span class="help-block" style="color: red">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </p>

                                    <p class="form-row">
                                        <input type="submit" value="Submit" name="Submit" class="button-submit" style="background-color: #ff9933">
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