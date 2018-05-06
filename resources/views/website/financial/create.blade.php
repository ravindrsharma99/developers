@extends('website.layouts.app') @section('content')

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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ \Illuminate\Support\Facades\Session::get('success') }}
                        </div>
                        @endif

                        <div class="col-md-8">
                            <h3 style="color: #666666;margin-bottom: 24px;">Avaiable Balance: ${{$user->balance}}</h3>
                            @if($user->withdrawal_pending )
                            <h3 style="color: #666666;margin-bottom: 24px;">Pending Withdrawable: ${{$user->withdrawal_pending}}</h3>
                            @endif
                            <div>
                                <h4 class="title-primary">Create new withdraw</h4>
                            </div>

                            <form class="updatepayment" method="POST" action="{{route('withdraw-requests.store')}}">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <p class="form-row form-row-wide">
                                    <label for="paypal_email">Paypal Email <span class="note-impor">*</span></label>
                                    {!! Form::text('paypal_email', $user->paypal_email, ['class' => 'input-text', 'placeholder' => 'Paypal email']) !!}
                                    @if ($errors->has('paypal_email'))
                                        <span class="help-block" style="color: red">
                                            <strong>{{ $errors->first('paypal_email') }}</strong>
                                        </span>
                                    @endif
                                </p>

                                <p class="form-row form-row-wide">
                                    <label for="amount">Amount  <span class="note-impor">*</span> <em>(Minimum withdraw amount is ${{$minimumWithdrawalAmount}})</em></label>
                                    {!! Form::text('amount', floor($user->balance), ['class' => 'input-text', 'placeholder' => 'amount']) !!}
                                    @if ($errors->has('amount'))
                                        <span class="help-block" style="color: red">
                                            <strong>{{ $errors->first('amount') }}</strong>
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
    <div class="block-html-full-width" style=" border-top: none;display: inline-block;margin-top: 70px;padding: 0px 0;width: 100%;"></div>
</main>
@endsection