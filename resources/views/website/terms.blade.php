@extends('website.layouts.app')
@section('content')
    <main class="site-main">
        <div class="container-inner">
            <div class="tab-shopping">
                <div class="tab-shoppping-cart">
                    <div class="tab-container" style="overflow: visible; float: right">
                        <div id="tab-1" class="tab-panel active">
                            <div class="box-content">
                                <div class="block-product-one-row">
                                    <div class="block-product-title">Terms & Con.</div>

                                    <div class="products auto-clear">
                                        {!! $terms['content'] !!}
                                    </div>
                                </div>
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