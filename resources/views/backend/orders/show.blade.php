@extends('backend.layout')
@section('backend_title', 'Order Details')

@section('backend_content')
<div class="container p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Order: {{ $order->order_number }}</h4>
        <a href="{{ route('dashboard.orders.order-list') }}" class="btn btn-secondary btn-sm">← Back</a>
    </div>

    <div class="row">
        {{-- Customer Info --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Customer Info</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }} {{ $order->postal }}</p>
                    @if($order->comments)
                    <p><strong>Comments:</strong> {{ $order->comments }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Update Order Status</div>
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.order-status', $order) }}" method="POST">
                        @csrf @method('PUT')
                        <select name="order_status" class="form-select mb-2">
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                <option value="{{ $status }}" @selected($order->order_status == $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Payment Status --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">Payment Status</div>
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.payment-status', $order) }}" method="POST">
                        @csrf @method('PUT')
                        <select name="payment_status" class="form-select mb-2">
                            @foreach(['pending','paid','failed','refunded'] as $status)
                                <option value="{{ $status }}" @selected($order->payment_status == $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success w-100">Update Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="card mb-3">
        <div class="card-header">Order Items</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr><th>Image</th><th>Product</th><th>Variant</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product_image)
                            <img src="{{ asset('storage/' . $item->product_image) }}" width="50" class="rounded">
                            @else — @endif
                        </td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ !empty($item->variant_name) ? $item->variant_name : '—' }}</td>
                        <td>৳{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>৳{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr><td colspan="5" class="text-end"><strong>Subtotal</strong></td><td>৳{{ number_format($order->subtotal, 2) }}</td></tr>
                    <tr><td colspan="5" class="text-end"><strong>Shipping</strong></td><td>৳{{ number_format($order->shipping_cost, 2) }}</td></tr>
                    <tr><td colspan="5" class="text-end"><strong>Total</strong></td><td><strong>৳{{ number_format($order->total_amount, 2) }}</strong></td></tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Customer Images --}}
    @if($order->images->count())
    <div class="card mb-3">
        <div class="card-header">Uploaded Images</div>
        <div class="card-body">
            <div class="row">
                @foreach($order->images as $img)
                <div class="col-md-2">
                    <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="img-fluid rounded">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Delete --}}
    <form action="{{ route('dashboard.orders.order-delete', $order) }}" method="POST" onsubmit="return confirm('Delete this order?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger btn-sm">Delete Order</button>
    </form>
</div>
@endsection
