@extends('website.layouts.app')
@section('content')

    <main class="site-main">
            <div class="container-inner">
                <div class="tab-shopping">
                    <div class="tab-shoppping-cart">
                        @include('website.sidemenu')

                        <div class="tab-container" style="padding-top: 0px;">
                            <div id="tab-1" class="tab-panel active">
                                <section class="ai06-cart-step">
                                    <ul>
                                        <li class="active"><a href="{{url('step1/'.$step4_app->id)}}"><span class="cp-img-04">UPLOAD APK FILE</span></a></li>
                                        <li class="active"><a href="{{url('step2/'.$step4_app->id)}}"><span class="cp-img-04">APP DETAILS</span></a></li>
                                        <li class="active"><a href="{{url('step3/'.$step4_app->id)}}"><span class="cp-img-04">APP SCREENSHOTS</span></a></li>
                                        <li class="active"><a href="{{url('step4/'.$step4_app->id)}}"><span class="cp-img-04">APP CONFIRMED</span></a></li>
                                        <div class="clearfix"></div>
                                    </ul>
                                </section><!--ai06-cart-step-->

                                <div class="col-md-6">
                                    <form class="login" method="post" action="{{url('step4/'.$step4_app->id)}}" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <ul class="inline-block">
                                            @if($step4_app->terms_agree == 1)
                                                <li class="inline-block-li"><input type="checkbox" name="terms_agree" checked><span class="input"></span>I agree with the <a href="{{url('terms')}}" target="_blank" style="color: orange">ThirdEye Software Developer Agreement</a></li>
                                            @else
                                                <li class="inline-block-li"><input type="checkbox" name="terms_agree" required><span class="input"></span>I agree with the <a href="{{url('terms')}}" target="_blank" style="color: orange">ThirdEye Software Developer Agreement</a></li>
                                            @endif
                                        </ul>

                                        <p class="form-row">
                                            <input type="submit" value="Submit App" name="submit" class="button-submit" style="background-color: #ff9933">
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