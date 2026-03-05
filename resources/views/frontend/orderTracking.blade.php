@extends('frontend.layout')
@section('frontend_title', 'Track Order')
@section('frontend_content')
    <div class="container py-5">

        {{-- Search Form --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="font-weight-bold mb-1 text-center">Track Your Order</h4>
                        <p class="text-muted text-center mb-4" style="font-size:14px;">
                            Enter your order number and phone or email to track your order.
                        </p>

                        @if ($errors->has('not_found'))
                            <div class="alert alert-danger text-center">
                                {{ $errors->first('not_found') }}
                            </div>
                        @endif

                        <form action="{{ route('frontend.track-order.track') }}" method="POST">
                            @csrf

                           

                            <div class="form-group mb-4">
                                <label class="font-weight-medium">Order Number or Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="query"
                                    class="form-control @error('query') is-invalid @enderror"
                                    placeholder="e.g. ORD-XXXXXXXX or 01XXXXXXXXX" value="{{ old('query') }}" required>
                                @error('query')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block w-100 py-2">
                                Track Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Result --}}
        @isset($order)
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Order Header --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <h5 class="font-weight-bold mb-1">{{ $order->order_number }}</h5>
                                    <p class="text-muted mb-1" style="font-size:14px;">
                                        <i class="fa fa-user mr-1"></i> {{ $order->name }}
                                    </p>
                                    <p class="text-muted mb-0" style="font-size:14px;">
                                        <i class="fa fa-phone mr-1"></i> {{ $order->phone }}
                                    </p>
                                    <p class="text-muted mt-2 mb-0" style="font-size:12px;">
                                        Placed on {{ $order->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="badge badge-pill px-3 py-2
                                {{ $order->order_status == 'delivered'
                                    ? 'badge-success'
                                    : ($order->order_status == 'cancelled'
                                        ? 'badge-danger'
                                        : ($order->order_status == 'shipped'
                                            ? 'badge-info'
                                            : ($order->order_status == 'processing'
                                                ? 'badge-primary'
                                                : 'badge-warning'))) }}"
                                        style="font-size:13px;">
                                        {{ ucfirst($order->order_status) }}
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Timeline --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="font-weight-bold mb-4">Order Status</h6>
                            @php
                                $steps = ['pending', 'processing', 'shipped', 'delivered'];
                                $currentIndex = array_search($order->order_status, $steps);
                                $cancelled = $order->order_status === 'cancelled';
                            @endphp

                            @if ($cancelled)
                                <div class="alert alert-danger text-center">
                                    <i class="fa fa-times-circle mr-2"></i>
                                    This order has been <strong>cancelled</strong>.
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center position-relative"
                                    style="padding: 0 10px;">

                                    {{-- Progress Line --}}
                                    <div
                                        style="position:absolute; top:20px; left:10%; right:10%; height:4px; background:#e9ecef; z-index:0;">
                                        <div
                                            style="height:100%; background:#28a745; width:{{ $currentIndex == 0 ? '0' : ($currentIndex == 1 ? '33%' : ($currentIndex == 2 ? '66%' : '100%')) }}; transition: width 0.5s;">
                                        </div>
                                    </div>

                                    @foreach ($steps as $i => $step)
                                        <div class="text-center" style="z-index:1; flex:1;">
                                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-2"
                                                style="width:40px; height:40px;
                                       background: {{ $i <= $currentIndex ? '#28a745' : '#e9ecef' }};
                                       color: {{ $i <= $currentIndex ? '#fff' : '#adb5bd' }};
                                       font-size:16px; border: 3px solid {{ $i <= $currentIndex ? '#28a745' : '#dee2e6' }};">
                                                @if ($step == 'pending')
                                                    <i class="fa fa-clock-o"></i>
                                                @elseif($step == 'processing')
                                                    <i class="fa fa-cog"></i>
                                                @elseif($step == 'shipped')
                                                    <i class="fa fa-truck"></i>
                                                @elseif($step == 'delivered')
                                                    <i class="fa fa-check"></i>
                                                @endif
                                            </div>
                                            <p class="mb-0 font-weight-{{ $i <= $currentIndex ? 'bold' : 'normal' }}"
                                                style="font-size:12px; color: {{ $i <= $currentIndex ? '#28a745' : '#adb5bd' }}">
                                                {{ ucfirst($step) }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="font-weight-bold mb-3">Order Items</h6>
                            @foreach ($order->items as $item)
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    @if ($item->product_image)
                                        <img src="{{ asset('storage/' . $item->product_image) }}"
                                            style="width:65px; height:65px; object-fit:cover; border-radius:8px;"
                                            class="mr-3">
                                    @else
                                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded"
                                            style="width:65px; height:65px; min-width:65px;">
                                            <i class="fa fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 font-weight-medium">{{ $item->product_name }}</h6>
                                        @if ($item->variant_name)
                                            <small class="text-muted">Variant: {{ $item->variant_name }}</small>
                                        @endif

                                        <small>X {{ $item->qty }}</small>
                                    </div>
                                    <div class="text-right">
                                        <strong>৳{{ number_format($item->subtotal, 2) }}</strong><br>
                                        <small class="text-muted">৳{{ number_format($item->price, 2) }} each</small>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Totals --}}
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Subtotal</span>
                                <span>৳{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <span class="text-muted">Shipping</span>
                                <span>৳{{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong class="text-primary">৳{{ number_format($order->total_amount, 2) }}</strong>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        @endisset

    </div>
@endsection
