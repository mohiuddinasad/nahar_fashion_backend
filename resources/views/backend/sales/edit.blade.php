@extends('backend.layout')
@section('backend_title', 'Sales Dashboard')
@section('backend_content')
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold">
                            <i class="fas fa-edit me-2 text-warning"></i>Edit Sale Record
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dashboard.daily-sales.update', $dailySale) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sale Date</label>
                                <input type="date" name="sale_date" class="form-control"
                                    value="{{ old('sale_date', $dailySale->sale_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Total Sale (৳)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="total_sale" id="total_sale" step="0.01"
                                            min="0" class="form-control"
                                            value="{{ old('total_sale', $dailySale->total_sale) }}" required
                                            oninput="calcProfit()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Total Cost (৳)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="total_cost" id="total_cost" step="0.01"
                                            min="0" class="form-control"
                                            value="{{ old('total_cost', $dailySale->total_cost) }}" required
                                            oninput="calcProfit()">
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="mb-3 p-3 rounded-3 bg-light">
                                <span class="text-muted fw-semibold small">NET PROFIT (auto)</span>
                                <h3 id="profit_preview"
                                    class="mb-0 fw-bold mt-1 {{ $dailySale->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                    ৳ {{ number_format($dailySale->profit, 2) }}
                                </h3>
                            </div> --}}

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Note</label>
                                <textarea name="note" class="form-control" rows="2">{{ old('note', $dailySale->note) }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="fas fa-save me-1"></i>Update Record
                                </button>
                                <a href="{{ route('dashboard.daily-sales.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-1"></i>Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('backend_js')
    <script>
        function calcProfit() {
            const sale = parseFloat(document.getElementById('total_sale').value) || 0;
            const cost = parseFloat(document.getElementById('total_cost').value) || 0;
            const profit = sale - cost;
            const el = document.getElementById('profit_preview');
            el.textContent = '৳ ' + profit.toFixed(2);
            el.className = 'mb-0 fw-bold mt-1 ' + (profit >= 0 ? 'text-success' : 'text-danger');
        }
    </script>
@endpush
