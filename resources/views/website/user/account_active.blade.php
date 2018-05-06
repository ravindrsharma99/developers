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

                    <h3 class="title-login">
                        <img width="100" height="100" src="{{ URL::asset('assets/website/images/imgpsh_fullsize.png') }}"  alt="">
                        @if($active_status == 2)

                        @else
                            @if($active_status == 0)
                                Your account has been activate successfully.
                            @else
                                Already your account is activated.
                            @endif
                        @endif
                    </h3>

            </div>
        </div>
        <div class="block-html-full-width" style=" border-top: none;
    display: inline-block;
    margin-top: 70px;
    padding: 0px 0;
    width: 100%;"></div>
    </main>
@endsection

