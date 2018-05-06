Hi {{$withdrawRequest->user->getTitle()}},<br>
<br>

We received your withdraw request {{$withdrawRequest->code}}. We will process it in some business days.<br>
Request: {{$withdrawRequest->code}}.<br>
Paypal Email: {{$withdrawRequest->paypal_email}}.<br>
Amount: ${{$withdrawRequest->amount}}<br>

<br>
Please feel free to contact us if any issues.<br>
<br>
Regards<br>
Thirdeyegen Support Team.