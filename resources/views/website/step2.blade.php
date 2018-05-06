@extends('website.layouts.app')

@section('content')

<style>
        .help-tip{
            position: absolute;
            left: 120px;
            text-align: center;
            background-color: #BCDBEA;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            line-height: 26px;
            cursor: default;
        }

        .help-tip:before{
            content:'i';
            font-weight: bold;
            color:#fff;
        }

        .help-tip:hover span{
            display:block;
            transform-origin: 100% 0%;

            -webkit-animation: fadeIn 0.3s ease-in-out;
            animation: fadeIn 0.3s ease-in-out;

        }

        .help-tip span{
            display: none;
            text-align: left;
            background-color: #1E2021;
            padding: 12px;
            width: 260px;
            position: absolute;
            border-radius: 3px;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
            color: #FFF;
            font-size: 13px;
            line-height: 1.4;
        }



        .help-tip1{
            position: absolute;
            left: 118px;
            text-align: center;
            background-color: #BCDBEA;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            line-height: 26px;
            cursor: default;
        }

        .help-tip1:before{
            content:'i';
            font-weight: bold;
            color:#fff;
        }

        .help-tip1:hover span{
            display:block;
            transform-origin: 100% 0%;

            -webkit-animation: fadeIn 0.3s ease-in-out;
            animation: fadeIn 0.3s ease-in-out;

        }

        .help-tip1 span{
            display: none;
            text-align: left;
            background-color: #1E2021;
            padding: 12px;
            width: 260px;
            position: absolute;
            border-radius: 3px;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
            color: #FFF;
            font-size: 13px;
            line-height: 1.4;
        }
    </style>

    <main class="site-main">
            <div class="container-inner">
                <div class="tab-shopping">
                    <div class="tab-shoppping-cart">

                        @include('website.sidemenu')
                        <div class="tab-container" style="padding-top: 0px;">
                            <div id="tab-1" class="tab-panel active">
                                <section class="ai06-cart-step">
                                    <ul>
                                        <li class="active"><a href="{{url('step1')}}"><span class="cp-img-04">UPLOAD APK FILE</span></a></li>
                                        <li class="active"><a href="{{url('step2')}}"><span class="cp-img-04">APP DETAILS</span></a></li>
                                        <li><a href="{{url('step3')}}"><span class="cp-img-04">APP SCREENSHOTS</span></a></li>
                                        <li><a href="{{url('step4')}}"><span class="cp-img-04">APP CONFIRMED</span></a></li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </section>

                                <div class="col-md-6">
                                    <form class="step2" method="post" action="{{url('step2_update')}}" enctype="multipart/form-data">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <p class="form-row form-row-wide">
                                            <label for="version_number">Version Name <span class="note-impor">*</span></label>
                                            {!! Form::text('version_number', $step2['version_number'], ['class' => 'input-text']) !!}
                                            @if ($errors->has('version_number'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('version_number') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="version_code">Version Code <span class="note-impor">* (Make sure <strong>Version Code</strong> must be matched with <strong>Version Code</strong> in APK file)</span></label>
                                            {!! Form::text('version_code', $step2['version_code'], ['class' => 'input-text important-input']) !!}
                                            @if ($errors->has('version_code'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('version_code') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="package_id">Package ID <span class="note-impor">*  (Make sure <strong>Package ID</strong> must be matched with <strong>Package ID</strong> in APK file)</span></label>
                                            {!! Form::text('package_id', $step2['package_id'], ['class' => 'input-text important-input', 'placeholder' => 'ex: com.android.candy']) !!}
                                            @if ($errors->has('package_id'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('package_id') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>

                                        <p class="form-row form-row-wide">
                                            <label for="category">Category <span class="note-impor">*</span></label>
                                            @if(isset($newapp[0]['company']))
                                                {!! Form::select('category', [''=>'Please select'] + $category_id, $step2->category,['class' => 'select-detail']) !!}
                                            @else
                                                {!! Form::select('category', [''=>'Please select'] + $category_id, null,['class' => 'select-detail']) !!}
                                            @endif

                                            @if ($errors->has('category'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('category') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>


                                        <p class="form-row form-row-wide">
                                            <label for="price">Price <span class="note-impor">*</span></label>
                                            {!! Form::select('price', \App\NewApp::$price,$step2['price'],['id' => 'price-select', 'class' => 'select-detail','onchange'=>'show_price(this.value)']) !!}
                                            @if ($errors->has('price'))
                                                <span class="help-block" style="color: red">
                                                     <strong>{{ $errors->first('price') }}</strong>
                                               </span>
                                            @endif
                                        </p>

                                        <p class="form-row form-row-wide @if($step2['price']=='Price') @else hide-input  @endif" id="price_div">
                                            <label for="amount">Amount in USD <span class="note-impor">*</span></label>
                                            {!! Form::select('amount', \App\NewApp::$amount, !empty($step2['amount'])?$step2['amount']:null,['class' => 'select-detail']) !!}
                                            @if ($errors->has('amount'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('amount') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>

                                        <p class="form-row form-row-wide @if($step2['price']=='Price')  @else hide-input  @endif" id="price_div1">
                                            <label for="paypal_id">Paypal Id <span class="note-impor">*</span><a href="https://www.paypal.com/signin?country.x=US&locale.x=en_US" target="_blank">&nbsp;&nbsp;&nbsp;<img src="{{ URL::asset('assets/website/images/home1/pay1.jpg') }}" alt="pay1"></a></label>
                                            {!! Form::email('paypal_id', $step2['paypal_id'], ['class' => 'input-text']) !!}
                                            @if ($errors->has('paypal_id'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('paypal_id') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>


                                        <p class="form-row form-row-wide">
                                            <label for="support_email">Support Email <span class="note-impor">*</span>
													<span class="help-tip">
                                                        <span>
                                                            This is the contact e-mail for anyone who downloads your app and wants to contact your company regarding support questions
                                                        </span>
                                                    </span>
											</label>
                                            {!! Form::text('support_email', $step2['support_email'], ['class' => 'input-text']) !!}
                                            @if ($errors->has('support_email'))
                                                <span class="help-block" style="color: red">
                                                    <strong>{{ $errors->first('support_email') }}</strong>
                                                 </span>
                                            @endif
                                        </p>



                                        <p class="form-row form-row-wide">
                                            <label for="company">Company <span class="note-impor">*</span></label>
                                            {!! Form::text('company', $step2['company'], ['class' => 'input-text']) !!}
                                            @if ($errors->has('company'))
                                                <span class="help-block" style="color: red">
                                                    <strong>
                                                        {{ $errors->first('company') }}
                                                    </strong>
                                                </span>
                                            @endif
                                        </p>



                                        <p class="form-row form-row-wide">
                                            <label for="contact_email">Contact Email <span class="note-impor">*</span>
													<span class="help-tip1">
                                                        <span>
                                                            This is the contact e-mail for your company if ThirdEye Gen, Inc wants to contact your company regarding app questions
                                                        </span>
                                                    </span>
											</label>
                                            {!! Form::text('contact_email', $step2['contact_email'], ['class' => 'input-text']) !!}
                                            @if ($errors->has('contact_email'))
                                                <span class="help-block" style="color: red">
                                                    <strong>{{ $errors->first('contact_email') }}</strong>
                                                 </span>
                                            @endif
                                        </p>



                                        <p class="form-row form-row-wide">
                                            <label for="description">Description <span class="note-impor">*</span></label>
                                            {!! Form::textarea('description', $step2['description'], ['class' => 'textarea-control','rows'=>'5','cols'=>'35']) !!}
                                            @if ($errors->has('description'))
                                                <span class="help-block" style="color: red">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                 </span>
                                            @endif
                                        </p>

                                        <p class="form-row">
                                            <input type="submit" value="next" name="submit" class="button-submit" style="background-color: #ff9933">
                                        </p>

                                        <script>
                                            function show_price(val) {
                                                if(val=='Price'){
                                                    document.getElementById('price_div').classList.remove('hide-input');
                                                    document.getElementById('price_div1').classList.remove('hide-input');
                                                }
                                                else{
                                                    document.getElementById('price_div').classList.add('hide-input');
                                                    document.getElementById('price_div1').classList.add('hide-input');
                                                }
                                            }

                                            show_price(document.getElementById('price-select').value);
                                        </script>
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