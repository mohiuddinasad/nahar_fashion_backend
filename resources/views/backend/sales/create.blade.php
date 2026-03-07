@extends('backend.layout')
@section('backend_title', 'Sales Dashboard')
@section('backend_content')
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                        <h5 class="fw-bold">
                            <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Sale Record
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dashboard.daily-sales.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sale Date <span class="text-danger">*</span></label>
                                <input type="date" name="sale_date"
                                    class="form-control @error('sale_date') is-invalid @enderror"
                                    value="{{ old('sale_date', date('Y-m-d')) }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Total Sale (৳) <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="total_sale" id="total_sale" step="0.01"
                                            min="0" class="form-control @error('total_sale') is-invalid @enderror"
                                            value="{{ old('total_sale') }}" placeholder="0.00" required
                                            oninput="calcProfit()">
                                        @error('total_sale')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Total Cost (৳) <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">৳</span>
                                        <input type="number" name="total_cost" id="total_cost" step="0.01"
                                            min="0" class="form-control @error('total_cost') is-invalid @enderror"
                                            value="{{ old('total_cost') }}" placeholder="0.00" required
                                            oninput="calcProfit()">
                                        @error('total_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Live Profit Preview --}}
                            {{-- <div class="mb-3 p-3 rounded-3 bg-light">
                                <span class="text-muted fw-semibold small">NET PROFIT (auto)</span>
                                <h3 id="profit_preview" class="mb-0 fw-bold text-success mt-1">৳ 0.00</h3>
                            </div> --}}

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Note (Optional)</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Any extra information...">{{ old('note') }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i>Save Record
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
