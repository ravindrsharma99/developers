@extends('website.layouts.app') @section('content')

<style>
    @media (max-width: 1366px){
        .tab-shoppping-cart {
            width: calc(100% - 240px) !important;
        }
    }
</style>

<main class="site-main">
    <div class="container-inner">
        <div class="tab-shopping">
            <div class="tab-shoppping-cart">
                @include('website.sidemenu')

                <div class="tab-container">
                    <div id="tab-1" class="tab-panel active">
                        @if(\Session::has('success'))
                        <br>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ \Session::get('success') }}
                        </div>
                        @endif

                        @if(\Session::has('error'))
                        <br>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ \Session::get('error') }}
                        </div>
                        @endif

                        <div class="col-md-12">
                            <h3 style="color: #666666;margin-bottom: 24px;">Avaiable Balance: ${{$user->balance}}</h3>
                            @if($user->withdrawal_pending )
                            <h3 style="color: #666666;margin-bottom: 24px;">Pending Withdrawable: ${{$user->withdrawal_pending}}</h3>
                            @endif
                            <div>
                                <h4 class="title-primary">Withdrawals History</h4>
                                <div style="margin-bottom: 16px;text-align:right;">
                                    <a class="button" href="{{route('withdraw-requests.create')}}">Create New Withdrawal</a>
                                </div>
                                @if($withdrawRequests && $withdrawRequests->count())
                                <table class="table">
                                    <thead>
                                        <th>Request Code</th>
                                        <th>Requested Date</th>
                                        <th>Paypal Email</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Failure Reason</th>
                                    </thead>
                                    <tbody>
                                        @foreach($withdrawRequests as $r)
                                        <tr>
                                            <td>{{$r->code}}</td>
                                            <td>{{$r->created_at}}</td>
                                            <td>{{$r->paypal_email}}</td>
                                            <td>${{$r->amount}}</td>
                                            <td class="{{ $r->status == 'failed' ? 'text-danger' : ($r->status == 'success' ? 'text-success' : '') }}">{{$r->status}}</td>
                                            <td>{{$r->failure_reason}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <p>You have no withdraw requests.</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-html-full-width" style=" border-top: none;display: inline-block;margin-top: 70px;padding: 0px 0;width: 100%;"></div>
</main>
@endsection