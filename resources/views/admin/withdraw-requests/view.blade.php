@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <h1>
                Withdrawal Requests
                <small>View</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/appusers')}}"><i class="fa fa-dashboard"></i> Withdrawal Requests</a></li>
                <li class="active">View</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View Withdrawal Request Detail</h3>
                        </div>
                        <div class="box-body">
                            <form method="POST" action="{{route('admin.withdraw-requests.update', ['withdrawRequest' => $withdrawRequest])}}">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT" />
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Id</th>
                                            <td>{{$withdrawRequest->id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Developer Name</th>
                                            <td>
                                                @if($withdrawRequest->user)
                                                {{$withdrawRequest->user->getTitle()}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Withdraw Code</th>
                                            <td>
                                                {{$withdrawRequest->code}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Paypal Email</th>
                                            <td>
                                                {{$withdrawRequest->paypal_email}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>
                                                ${{$withdrawRequest->amount}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{$withdrawRequest->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{$withdrawRequest->updated_at}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($withdrawRequest->status == 'pending' || $withdrawRequest->status == 'processing')
                                                <select id="withdrawStatus" name="status" class="form-control input-sm" onchange="onStatusChanged(this)" style="width: 200px">
                                                    <option value="pending" {{$withdrawRequest->status == 'pending' ? 'selected' : ''}} >PENDING</option>
                                                    <option value="processing" {{$withdrawRequest->status == 'processing' ? 'selected' : ''}} >PROCESSING</option>
                                                    <option value="success" {{$withdrawRequest->status == 'success' ? 'selected' : ''}}>SUCCESS</option>
                                                    <option value="failed" {{$withdrawRequest->status == 'failed' ? 'selected' : ''}}>FAILED</option>
                                                </select>
                                                @else
                                                {{$withdrawRequest->status}}
                                                @endif
                                            </td>
                                        </tr>
                                        @if($withdrawRequest->status == 'pending' || $withdrawRequest->status == 'processing')
                                        <tr id="failureReason">
                                            <th>Failure Reason</th>
                                            <td>
                                                <input type="text" class="form-control" name="failure_reason" placeholder="Failure reason" />
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            
                                <div style="padding: 16px;text-align:right;">
                                    <a class="btn btn-danger" href="{{route('admin.withdraw-requests.index')}}">Cancel</a>
                                    @if($withdrawRequest->status == 'pending' || $withdrawRequest->status == 'processing')
                                    <button class="btn btn-success">Submit</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    function onStatusChanged(ele){
        var failureReason = document.getElementById('failureReason');
        if(ele.value == 'failed'){
            if(failureReason){
                failureReason.style.display = '';
            }
        }
        else{
            if(failureReason){
                failureReason.style.display = 'none';
            }
        }
    }
    window.addEventListener('load', () => {
        onStatusChanged(document.getElementById('failureReason'));
    });
</script>
@endsection


