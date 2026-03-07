@extends('backend.layout')
@section('backend_title', 'Dashboard')
@section('backend_content')

<div class="container-fluid p-3">

    {{-- ===== TOP STAT CARDS ===== --}}
    <div class="row g-3 mb-4">

        {{-- Today Orders --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100"
                 style="background: linear-gradient(135deg,#667eea,#764ba2); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold text-uppercase">Today Orders</p>
                            <h3 class="mb-0 fw-bold">{{ $todayOrders }}</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

        {{-- Monthly Orders --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100"
                 style="background: linear-gradient(135deg,#f093fb,#f5576c); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold text-uppercase">Monthly Orders</p>
                            <h3 class="mb-0 fw-bold">{{ $monthlyOrders }}</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

        {{-- Today Sale --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100"
                 style="background: linear-gradient(135deg,#4facfe,#00f2fe); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold text-uppercase">Today Sale</p>
                            <h3 class="mb-0 fw-bold">৳{{ number_format($todaySale, 0) }}</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-coins fa-lg"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- Monthly Sale --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100"
                 style="background: linear-gradient(135deg,#43e97b,#38f9d7); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold text-uppercase">Monthly Sale</p>
                            <h3 class="mb-0 fw-bold">৳{{ number_format($monthlySale, 0) }}</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;background:rgba(255,255,255,0.2);">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    {{-- ===== ORDER STATUS BADGES ===== --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3">
                <h4 class="fw-bold text-dark mb-0">{{ $totalOrders }}</h4>
                <small class="text-muted fw-semibold">Total</small>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3"
                 style="border-left: 4px solid #ffc107 !important;">
                <h4 class="fw-bold text-warning mb-0">{{ $pendingOrders }}</h4>
                <small class="text-muted fw-semibold">Pending</small>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3"
                 style="border-left: 4px solid #0dcaf0 !important;">
                <h4 class="fw-bold text-info mb-0">{{ $processingOrders }}</h4>
                <small class="text-muted fw-semibold">Processing</small>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3"
                 style="border-left: 4px solid #198754 !important;">
                <h4 class="fw-bold text-success mb-0">{{ $deliveredOrders }}</h4>
                <small class="text-muted fw-semibold">Delivered</small>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3"
                 style="border-left: 4px solid #dc3545 !important;">
                <h4 class="fw-bold text-danger mb-0">{{ $cancelledOrders }}</h4>
                <small class="text-muted fw-semibold">Cancelled</small>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-3 text-center p-3"
                 style="border-left: 4px solid #667eea !important;">
                <h4 class="fw-bold text-primary mb-0">৳{{ number_format($monthlyCost, 0) }}</h4>
                <small class="text-muted fw-semibold">Monthly Cost</small>
            </div>
        </div>

    </div>

    {{-- ===== CHART + RECENT ORDERS ===== --}}
    {{-- ===== CHART + RECENT ORDERS ===== --}}
<div class="row g-3">

    {{-- Gradient Line Chart --}}
    <div class="col-lg-7">
        <div class="card border-0 rounded-3 h-100" style="box-shadow: 0 4px 20px rgba(0,0,0,0.07);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="fw-bold mb-0">Orders Overview</h6>
                        <small class="text-muted">Last 7 days performance</small>
                    </div>
                    <span class="badge rounded-pill px-3 py-2"
                          style="background:#f0f2ff; color:#667eea; font-size:12px;">
                        <i class="fas fa-chart-area me-1"></i>7 Days
                    </span>
                </div>
                <canvas id="ordersChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="col-lg-5">
        <div class="card border-0 rounded-3 h-100" style="box-shadow: 0 4px 20px rgba(0,0,0,0.07);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0">Recent Orders</h6>
                        <small class="text-muted">Latest 5 orders</small>
                    </div>
                    <a href="{{ route('dashboard.orders.order-list') }}"
                       class="btn btn-sm px-3 fw-semibold"
                       style="background:#f0f2ff; color:#667eea; font-size:12px; border-radius:20px;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                @forelse($recentOrders as $order)
                    @php
                        $statusConfig = match($order->order_status) {
                            'pending'    => ['bg' => '#fff8e1', 'color' => '#f59e0b', 'label' => 'Pending'],
                            'processing' => ['bg' => '#e0f7fa', 'color' => '#0dcaf0', 'label' => 'Processing'],
                            'shipped'    => ['bg' => '#e8f4fd', 'color' => '#667eea', 'label' => 'Shipped'],
                            'delivered'  => ['bg' => '#e8f5e9', 'color' => '#198754', 'label' => 'Delivered'],
                            'cancelled'  => ['bg' => '#fdecea', 'color' => '#dc3545', 'label' => 'Cancelled'],
                            default      => ['bg' => '#f5f5f5', 'color' => '#6c757d', 'label' => ucfirst($order->order_status)],
                        };
                    @endphp
                    <div class="d-flex align-items-center justify-content-between px-2 py-2 rounded-2
                                {{ !$loop->last ? 'mb-1 border-bottom' : '' }}"
                         style="transition: background 0.15s ease;"
                         onmouseover="this.style.background='#f8f9ff'"
                         onmouseout="this.style.background='transparent'">

                        <div class="d-flex align-items-center gap-2">
                            {{-- Avatar --}}
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:38px; height:38px;
                                        background:{{ $statusConfig['bg'] }};
                                        color:{{ $statusConfig['color'] }};
                                        font-size:13px;">
                                {{ strtoupper(substr($order->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold" style="font-size:13px;">
                                    {{ $order->name ?? 'Unknown' }}
                                </p>
                                <p class="mb-0 text-muted" style="font-size:11px;">
                                    #{{ $order->order_number ?? $order->id }}
                                </p>
                            </div>
                        </div>

                        <div class="text-end">
                            <span class="d-inline-block rounded-pill px-2 py-1 mb-1 fw-semibold"
                                  style="background:{{ $statusConfig['bg'] }};
                                         color:{{ $statusConfig['color'] }};
                                         font-size:11px;">
                                {{ $statusConfig['label'] }}
                            </span>
                            <p class="mb-0 text-muted" style="font-size:10px;">
                                {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 opacity-25 d-block"></i>
                        No orders yet.
                    </div>
                @endforelse

            </div>
        </div>
    </div>

</div>

@endsection

@push('backend_js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(102,126,234,0.35)');
    gradient.addColorStop(1, 'rgba(102,126,234,0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($last7Days->pluck('date')),
            datasets: [{
                label: 'Orders',
                data: @json($last7Days->pluck('orders')),
                fill: true,
                backgroundColor: gradient,
                borderColor: '#667eea',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#667eea',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#667eea',
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#333',
                    bodyColor: '#667eea',
                    borderColor: '#e0e0e0',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: ctx => `  ${ctx.parsed.y} orders`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#aaa', font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }
                },
                x: {
                    ticks: { color: '#aaa', font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush