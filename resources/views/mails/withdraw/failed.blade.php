Hi {{$withdrawRequest->user->getTitle()}},<br>
<br>
Your withdraw request {{$withdrawRequest->code}} has been failed.<br>
Request: {{$withdrawRequest->code}}.<br>
Paypal Email: {{$withdrawRequest->paypal_email}}.<br>
Amount: ${{$withdrawRequest->amount}}<br>
@if($withdrawRequest->failure_reason)
{{$withdrawRequest->failure_reason}}
@endif
<br>
Please feel free to contact us if any issues.<br>
<br>
Regards<br>
Thirdeyegen Support Team.