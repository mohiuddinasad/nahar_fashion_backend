@extends('backend.layout')
@section('backend_title', 'Order Details')

@push('backend_css')
<style>
    @media (max-width: 768px) {
        .items-table-wrap {
            overflow-x: auto;
        }
        .items-table-wrap table {
            min-width: 580px;
        }
    }
</style>
@endpush

@section('backend_content')
<div class="container p-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="mb-0">
            Order: <span class="fw-bold">{{ $order->order_number }}</span>
        </h4>
        <a href="{{ route('dashboard.orders.order-list') }}" class="btn btn-secondary btn-sm">&#8592; Back</a>
    </div>

    {{-- Top Row --}}
    <div class="row g-3 mb-3 align-items-start">

        {{-- Customer Info --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header table-light fw-semibold">Customer Info</div>
                <div class="card-body">
                    <p class="mb-2"><span class="text-muted small">Name</span><br><strong>{{ $order->name }}</strong></p>
                    <p class="mb-2"><span class="text-muted small">Email</span><br><strong>{{ $order->email }}</strong></p>
                    <p class="mb-2"><span class="text-muted small">Phone</span><br><strong>{{ $order->phone }}</strong></p>
                    <p class="mb-2"><span class="text-muted small">Address</span><br><strong>{{ $order->address }}, {{ $order->city }} {{ $order->postal }}</strong></p>
                    @if($order->comments)
                    <p class="mb-0"><span class="text-muted small">Notes</span><br><strong>{{ $order->comments }}</strong></p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status Cards stacked on the right --}}
        <div class="col-md-8">
            <div class="row g-3">

                {{-- Order Status --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header table-light fw-semibold">Update Order Status</div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.orders.order-status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="order_status" class="form-select mb-3">
                                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                        <option value="{{ $status }}" @selected($order->order_status == $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Payment Status --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header table-light fw-semibold">Payment Status</div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.orders.payment-status', $order) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="payment_status" class="form-select mb-3">
                                    @foreach(['pending','paid','failed','refunded'] as $status)
                                        <option value="{{ $status }}" @selected($order->payment_status == $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Update Payment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- Order Items --}}
    <div class="card mb-3">
        <div class="card-header table-light fw-semibold">Order Items</div>
        <div class="card-body p-0 items-table-wrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product_image)
                                <img src="{{ asset($item->product_image) }}" width="48" height="48"
                                     style="object-fit:cover; border-radius:6px; border:1px solid #dee2e6;"
                                     alt="{{ $item->product_name }}">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="fw-semibold align-middle">{{ $item->product_name }}</td>
                        <td class="align-middle">
                            @if(!empty($item->variant_name))
                                <span class="badge bg-secondary">{{ $item->variant_name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="align-middle">&#2547;{{ number_format($item->price, 2) }}</td>
                        <td class="align-middle">
                            <span class="badge bg-light text-dark border">{{ $item->qty }}</span>
                        </td>
                        <td class="align-middle fw-semibold">&#2547;{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="5" class="text-end text-muted">Subtotal</td>
                        <td>&#2547;{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end text-muted">Shipping</td>
                        <td>&#2547;{{ number_format($order->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total</td>
                        <td class="fw-bold">&#2547;{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Uploaded Images --}}
    @if($order->images->count())
    <div class="card mb-3">
        <div class="card-header table-light fw-semibold">Uploaded Images</div>
        <div class="card-body">
            <div class="row g-2">
                @foreach($order->images as $img)
                <div class="col-6 col-md-2">
                    <a href="{{ asset($img->image_path) }}" target="_blank">
                        <img src="{{ asset($img->image_path) }}"
                             class="img-fluid rounded border"
                             style="width:100%; height:90px; object-fit:cover;"
                             alt="Order Image">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Delete --}}
    <form action="{{ route('dashboard.orders.order-delete', $order) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this order?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Delete Order</button>
    </form>

</div>
@endsection
