@extends('backend.layout')
@section('backend_title', 'Sales Dashboard')
@push('backend_css')
    <style>
        @media (max-width: 991.98px) {
            .table {
                width: 600px;
            }
        }
    </style>
@endpush
@section('backend_content')
    <div class="container p-3">

        {{-- ===== STAT BOXES ===== --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100"
                    style="background: linear-gradient(135deg,#667eea,#764ba2); color:white;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold">TODAY SALE</p>
                            <h4 class="mb-0 fw-bold">৳{{ number_format($todaySale, 2) }}</h4>
                            <small class="opacity-75">Cost: ৳{{ number_format($todayCost, 2) }}</small>
                        </div>
                        <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100"
                    style="background: linear-gradient(135deg,#f093fb,#f5576c); color:white;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold">THIS MONTH SALE</p>
                            <h4 class="mb-0 fw-bold">৳{{ number_format($monthlySale, 2) }}</h4>
                            <small class="opacity-75">Cost: ৳{{ number_format($monthlyCost, 2) }}</small>
                        </div>
                        <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100"
                    style="background: linear-gradient(135deg,#4facfe,#00f2fe); color:white;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold">THIS YEAR SALE</p>
                            <h4 class="mb-0 fw-bold">৳{{ number_format($yearlySale, 2) }}</h4>
                        </div>
                        <i class="fas fa-calendar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100"
                    style="background: linear-gradient(135deg,#43e97b,#38f9d7); color:white;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 small opacity-75 fw-semibold">TOTAL SALE</p>
                            <h4 class="mb-0 fw-bold">৳{{ number_format($totalSale, 2) }}</h4>
                        </div>
                        <i class="fas fa-coins fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== DATE SEARCH ===== --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('dashboard.daily-sales.index') }}" method="GET">
                    <div class="row g-2 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label fw-semibold small mb-1">From Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold small mb-1">To Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('dashboard.daily-sales.index') }}" class="btn btn-outline-secondary px-3">
                                    <i class="fas fa-rotate-left me-1"></i>Reset
                                </a>
                            </div>
                        </div>

                        {{-- Quick Filter Buttons --}}
                        <div class="col-12">
                            <div class="d-flex gap-2 flex-wrap align-items-center">
                                <span class="text-muted small fw-semibold">Quick:</span>

                                <a href="{{ route('dashboard.daily-sales.index', ['start_date' => now()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                                    class="btn btn-sm {{ request('start_date') == now()->toDateString() && request('end_date') == now()->toDateString() ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Today
                                </a>

                                <a href="{{ route('dashboard.daily-sales.index', ['start_date' => now()->startOfWeek()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                                    class="btn btn-sm {{ request('start_date') == now()->startOfWeek()->toDateString() ? 'btn-info text-white' : 'btn-outline-info' }}">
                                    This Week
                                </a>

                                <a href="{{ route('dashboard.daily-sales.index', ['start_date' => now()->startOfMonth()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                                    class="btn btn-sm {{ request('start_date') == now()->startOfMonth()->toDateString() ? 'btn-success' : 'btn-outline-success' }}">
                                    This Month
                                </a>

                                <a href="{{ route('dashboard.daily-sales.index', ['start_date' => now()->startOfYear()->toDateString(), 'end_date' => now()->toDateString()]) }}"
                                    class="btn btn-sm {{ request('start_date') == now()->startOfYear()->toDateString() ? 'btn-warning' : 'btn-outline-warning' }}">
                                    This Year
                                </a>

                                <a href="{{ route('dashboard.daily-sales.index', ['start_date' => now()->subDays(30)->toDateString(), 'end_date' => now()->toDateString()]) }}"
                                    class="btn btn-sm {{ request('start_date') == now()->subDays(30)->toDateString() ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                    Last 30 Days
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- ===== TABLE (always visible) ===== --}}
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-list me-2 text-primary"></i>
                        @if ($isFiltered)
                            Filtered Records
                            <span class="badge bg-primary ms-1">{{ $sales->total() }}</span>
                        @else
                            All Sale Records
                            <span class="badge bg-secondary ms-1">{{ $sales->total() }}</span>
                        @endif
                    </h6>
                    <a href="{{ route('dashboard.daily-sales.create') }}" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-plus me-1"></i>Add New Sale
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Sale (৳)</th>
                                <th>Cost (৳)</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td>{{ ($sales->currentPage() - 1) * $sales->perPage() + $loop->iteration }}</td>
                                    <td>{{ $sale->sale_date->format('d M Y') }}</td>
                                    <td class="text-primary fw-semibold">৳{{ number_format($sale->total_sale, 2) }}</td>
                                    <td class="text-danger">৳{{ number_format($sale->total_cost, 2) }}</td>
                                    <td class="text-muted small">{{ $sale->note ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.daily-sales.edit', $sale) }}"
                                            class="btn btn-sm btn-outline-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.daily-sales.destroy', $sale) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Delete this record?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        @if ($isFiltered)
                                            <i class="fas fa-search me-2"></i>
                                            No records found for selected date range.
                                            <a href="{{ route('dashboard.daily-sales.index') }}">Clear filter</a>
                                        @else
                                            <i class="fas fa-inbox me-2"></i>
                                            No records yet.
                                            <a href="{{ route('dashboard.daily-sales.create') }}">Add first sale!</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-2">
                    {{ $sales->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>

@endsection

@push('backend_js')
    <script>
        const chartCanvas = document.getElementById('saleChart');
        if (chartCanvas) {
            const chartData = @json($chartData);
            new Chart(chartCanvas, {
                type: 'bar',
                data: {
                    labels: chartData.map(d => d.sale_date),
                    datasets: [{
                            label: 'Sale (৳)',
                            data: chartData.map(d => d.total_sale),
                            backgroundColor: 'rgba(102,126,234,0.75)',
                            borderRadius: 6,
                        },
                        {
                            label: 'Profit (৳)',
                            data: chartData.map(d => d.profit),
                            backgroundColor: 'rgba(67,233,123,0.75)',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
@endpush
