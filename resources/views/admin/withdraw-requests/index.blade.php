@extends('admin.layouts.app')
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Withdrawal Requests
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/appusers')}}"><i class="fa fa-dashboard"></i> Withdrawal Requests</a></li>
            </ol>

            <br>
            @include ('admin.error')

            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <table id="paymentTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Code</th>
                            <th>Developer</th>
                            <th>Paypal Account</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Failure Reason</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($items as $list)
                            <tr>
                                <td>{{ $list['id'] }}</td>
                                <td>{{ $list['code'] }}</td>
                                <td>
                                    @if($list->user)
                                    <a href="{{$list->user->getAdminHref()}}">{{$list->user->getTitle()}}</a>
                                    @endif
                                </td>
                                <td>{{ $list->paypal_email}} </td>
                                <td>{{ $list->amount ? '$' . $list->amount : '0' }}</td>
                                <td class="{{ $list->status == 'failed' ? 'text-danger' : ($list->status == 'success' ? 'text-success' : '') }}">{{ $list->status }}</td>
                                <td>{{ $list->failure_reason }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    <div class="btn-group-horizontal">
                                        <a href="{{url('admin/withdraw-requests/'.$list['id'])}}"> <button class="btn btn-info"  type="button"><i class="fa fa-eye"></i></button></a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @if(!$items->count())
                    <p>There is no withdrawal request now.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

<script src="{{ URL::asset('assets/jquery.js')}}"></script>
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>

<script>
    $(document).ready(function(){
        $('#paymentTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[ 9, "desc" ]],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 8 ] }
            ]

        });
    });
</script>