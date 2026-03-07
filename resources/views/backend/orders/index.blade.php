@extends('backend.layout')

@section('backend_title', 'Orders')
@push('backend_css')
    <style>
        @media (max-width: 992px) {
            .table_card{
                overflow-x: auto;

            }
            .table_card .card-body{
                width: max-content;
            }

            .status{
                margin-bottom: 10px;
            }
        }
    </style>
@endpush


@section('backend_content')
    <div class="container p-4">
        <h4 class="mb-4">Orders</h4>

        {{-- Stats --}}
        <div class="row justify-content-center mb-4">
            @foreach (['total' => 'primary', 'pending' => 'warning', 'processing' => 'info', 'delivered' => 'success', 'cancelled' => 'danger'] as $key => $color)
                <div class="col-lg-2">
                    <div class="card border-{{ $color }} text-center">
                        <div class="card-body py-2">
                            <h5 class="mb-0">{{ $stats[$key] }}</h5>
                            <small class="text-muted text-capitalize">{{ $key }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filters --}}
        <form method="GET" id="filterForm" class="row justify-content-between g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" id="searchInput" class="form-control"
                    placeholder="Search order #, name, email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6 px-1 status">
                        <select name="order_status" id="orderStatusSelect" class="form-select">
                            <option value="">All Status</option>
                            @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('order_status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 px-1 status">
                        <select name="payment_status" id="paymentStatusSelect" class="form-select">
                            <option value="">All Payment</option>
                            @foreach (['pending', 'paid', 'failed', 'refunded'] as $status)
                                <option value="{{ $status }}" @selected(request('payment_status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

        </form>

        {{-- Table --}}
        <div class="card table_card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>
                                    {{ $order->name }}<br>
                                    <small class="text-muted">{{ $order->phone }}</small>
                                </td>
                                <td>{{ $order->items->count() }} item(s)</td>
                                <td>৳{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'cancelled' ? 'danger' : ($order->order_status == 'processing' ? 'info' : 'warning')) }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('dashboard.orders.order-show', $order) }}"
                                        class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
    </div>

    <script>
        // Auto-submit on dropdown change
        document.getElementById('orderStatusSelect').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        document.getElementById('paymentStatusSelect').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Auto-submit on search with debounce (waits 500ms after user stops typing)
        let searchTimer;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    </script>

@endsection
