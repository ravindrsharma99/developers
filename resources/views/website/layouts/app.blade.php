<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Third Eye</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/chosen.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/website/css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/datepicker/datepicker3.css')}}">
    @yield('css')
</head>
<body class="index-opt-1">
<div class="wrapper">
    <header class="site-header header-opt-1">
        <div class="header-content">
            <div class="container-inner">
                <div class="row">
                    <div class="col-lg-2 col-md-3">
                        <div class="logo-header"><a href="{{url('/')}}"><img src="{{ URL::asset('assets/website/images/home1/logo.png') }}" alt="logo"></a></div>
                    </div>

                    @if(session()->get('SESS_USER'))
                    <div class="col-lg-8 col-md-6 ">
                        <div class="block-search">


                            <form method="get" id="search_form"  name="search_form" class="form-search" action="{{url('search')}}">
                                <div class="form-content">
                                    <div class="search-input">
                                        {{--<input type="text" class="input" name="keyword" id="search" value="" placeholder="Search here...." autocomplete="off">--}}
                                        {!! Form::text('keyword', null, ['class' => 'input', 'placeholder' => 'Search here....','id'=>'search']) !!}
                                    </div>
                                    <div class="categori-search">
                                        {!! Form::select('category', [''=>'All Categories'] + $category_id, null,['class' => 'chosen-select categori-search-option']) !!}

                                        {{--<select data-placeholder="All Categories" class="chosen-select categori-search-option">--}}
                                            {{--<option>All Categories</option>--}}
                                            {{--<option>Games</option>--}}
                                            {{--<option>Entertainment</option>--}}
                                            {{--<option>Books</option>--}}
                                            {{--<option>Business</option>--}}
                                            {{--<option>Education</option>--}}
                                            {{--<option>Enterprise</option>--}}
                                            {{--<option>Health & Fitness</option>--}}
                                            {{--<option>Kids</option>--}}
                                            {{--<option>Magazines & Newspapers</option>--}}
                                            {{--<option>Music</option>--}}
                                            {{--<option>Navigation</option>--}}
                                            {{--<option>Social Networking</option>--}}
                                            {{--<option>Utilities</option>--}}
                                            {{--<option>Travel</option>--}}
                                        {{--</select>--}}
                                    </div>
                                    <button class="btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </form>

                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        {{--<div class="header-menu-nar header-sticky">--}}
        <div class="header-menu-nar header">
            <div class="container-inner">
                <div class="header-menu-nav-inner">
                    <div class="header-menu-nav">
                        <div class="header-menu">

                            <ul class="header-nav smarket-nav">
                                <li class="btn-close hidden-mobile"><i class="fa fa-times" aria-hidden="true"></i></li>

                                @if(session()->get('SESS_USER'))
                                    <li class="menu-item-has-children arrow" style="float: right">
                                        <a href="{{url('logout')}}" class="dropdown-toggle">Logout</a>
                                    </li>
                                    <li class="menu-item-has-children @if(isset($menu) && $menu=='WebUserAcount') active @endif arrow" style="float: right">
                                        <a href="{{url('account')}}" class="dropdown-toggle">Account</a>
                                    </li>
                                    <li class="menu-item-has-children @if(isset($menu) && $menu=='Forums') active @endif arrow" style="float: right">
                                        <a href="{{url('forums')}}" class="dropdown-toggle">Forums</a>
                                    </li>
                                @else
                                    <li class="menu-item-has-children active arrow" style="float: right">
                                        <a href="{{url('login')}}" class="dropdown-toggle">Login <span class="or-two"> / </span> Register</a>
                                    </li>
                                @endif
                            </ul>


                        </div>
                        <span data-action="toggle-nav" class="menu-on-mobile hidden-mobile">
                            <span class="btn-open-mobile home-page">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                            <span class="title-menu-mobile">Main menu</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @yield('content')


    <footer class="footer site-footer footer-opt-1">
        <div class="footer-column">
            <div class="container-inner equal-container">
                <div class="row">
                    <div class="col-lg-1  col-sm-5 equal-elem">

                    </div>
                    <div class="col-lg-18 col-md-3 col-sm-5 equal-elem">
                        <h3 class="title-of-footer">Contact Us</h3>
                        <div class="contacts">
                            <span class="contacts-icon info-address"></span><span class="contacts-info">Address 300 Alexander Park, Suite 206 Princeton, NJ 08540.</span>
                            <span class="contacts-icon info-support"></span><span class="contacts-info">sales@thirdeyegen.com <br> developers@thirdeyegen.com</span>
                            <span class="contacts-icon info-phone" style="margin: 0px 13px 0 0; !important;"></span><span class="contacts-info">609-423-1660</span>
                            <span class="contacts-icon glyphicons glyphicons-fax" style="margin: 2px 13px 0 0; !important;"><i class="fa fa-fax" aria-hidden="true"></i></span><span class="contacts-info">609-480-1507</span>
                        </div>
                    </div>
                    <div class="col-lg-18 col-md-3 col-sm-5 equal-elem">
                        <h3 class="title-of-footer">Information</h3>
                        <div class="links">
                            <ul>
                                <li><a href="{{url('account')}}">My account</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-20 col-md-2 col-sm-5 equal-elem">
                        <h3 class="title-of-footer">Our Policy</h3>
                        <div class="links">
                            <ul>
                                <li><a href="{{url('terms')}}">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>



                    {{--<div class="col-lg-20 col-md-2 col-sm-4 equal-elem">--}}
                        {{--<h3 class="title-of-footer">Signup For Newsletter</h3>--}}
                        {{--<div class="footer-newsletter">--}}
                            {{--<p>Lorem ipsum dolor sit amete, consectetur adipisicing sed do eiusmod tempor</p>--}}
                            {{--<div class="newsletter-form">--}}
                                {{--<form id="newsletter-validate-detail" class="form subscribe">--}}
                                    {{--<div class="control">--}}
                                        {{--<input type="email" placeholder="Type your email here" name="email" class="input-subscribe">--}}
                                        {{--<button type="submit" title="Subscribe" class="btn subscribe">--}}
                                            {{--<span><i class="fa fa-envelope" aria-hidden="true"></i></span>--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-lg-20 col-md-4 col-sm-5 equal-elem">
                        <h3 class="title-of-footer title-follow">Follow Us</h3>
                        <div class="footer-follow">
                            <ul>
                                <li><a class="facebook" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a class="pinterest" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a class="vk-plus" href="#"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
                                <li><a class="google-plus" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="footer-copyright">
            <div class="container-inner">
                <div class="footer-copyright-left">
                    <p>Copyright @ 2017 <span>ThirdEye Gen, Inc </span>| All rights reserved.</p>
                </div>
                <div class="footer-copyright-right">
                    <div class="pay-men">
                        <a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay1.jpg') }}" alt="pay1"></a>
                        {{--<a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay2.jpg') }}" alt="pay2"></a>--}}
                        <a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay3.jpg') }}" alt="pay3"></a>
                        {{--<a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay4.jpg') }}" alt="pay4"></a>--}}
                        <a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay5.jpg') }}" alt="pay4"></a>
                        {{--<a href="#"><img src="{{ URL::asset('assets/website/images/home1/pay6.jpg') }}" alt="pay4"></a>--}}
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<a href="javascript:;" id="scrollup" title="Scroll to Top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<!-- jQuery -->
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery.actual.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/chosen.jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/lightbox.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/owl.carousel2.thumbs.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/Modernizr.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery.plugin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/jquery.countdown.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/website/js/function.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    $(function() {
        $('search_form').each(function() {
            $(this).find('search').keypress(function(e) {
                if(e.which == 10 || e.which == 13) {
                    this.form.submit();
                }
            });
        });
    });
</script>
@yield('js')
@stack('scripts')
</body>
</html>
