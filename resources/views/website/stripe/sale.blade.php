<form action="{{route('stripe.charge')}}" method="post">
    {{csrf_field()}}
    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{$stripe_public_key}}"
            data-description="Access for a year"
            data-amount="5000"
            data-locale="auto"></script>
</form>