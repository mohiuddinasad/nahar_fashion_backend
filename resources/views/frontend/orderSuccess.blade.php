@extends('frontend.layout')
@section('frontend_title', 'Order Success')
@section('frontend_content')
    <div class="container py-5 text-center">
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="green" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
            </svg>
        </div>
        <h2>Order Placed Successfully!</h2>
        <p class="text-muted">Your order number is <strong>{{ $order->order_number }}</strong></p>
        <p>We'll contact you at <strong>{{ $order->phone }}</strong> to confirm your order.</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
@endsection
