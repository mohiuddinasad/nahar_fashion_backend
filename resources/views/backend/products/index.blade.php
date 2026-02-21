@extends('backend.layout')

@push('backend_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('backend_content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Products</h2>
        <a href="{{ route('dashboard.products.product-create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    {{-- Success / Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search Box --}}
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('dashboard.products.product-list') }}" method="GET">
                <div class="row g-3 align-items-end">

                    {{-- Search by Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Search by Name</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="Type product name..."
                               value="{{ request('search') }}">
                    </div>



                    {{-- Buttons --}}
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-20">
                            Search
                        </button>

                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body">

            {{-- Result count --}}
            <p class="text-muted mb-2">
                Total <strong>{{ $products->total() }}</strong> products found
                @if(request('search') || request('category_id'))
                    for your search
                @endif
            </p>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>
                        <td>
                            @if($product->productImage->first())
                                <img src="{{ Storage::url($product->productImage->first()->image_path) }}"
                                     width="55" height="55" style="object-fit:cover;" class="rounded">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>
                            ${{ number_format($product->price, 2) }}
                            @if($product->discount_price)
                                <br>
                                <small class="text-danger">
                                    Sale: ${{ number_format($product->discount_price, 2) }}
                                </small>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = match($product->stock_status) {
                                    'in_stock'     => 'success',
                                    'out_of_stock' => 'danger',
                                    'pre_order'    => 'warning',
                                    default        => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                            </span>
                        </td>
                        <td>{{ $product->is_featured ? '✅' : '—' }}</td>
                        <td>
                            <a href="{{ route('dashboard.products.product-edit', $product) }}"
                               class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('dashboard.products.product-delete', $product) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No products found.
                            @if(request('search') || request('category_id'))
                                <a href="{{ route('dashboard.products.product-list') }}">Clear search</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination (keeps search params) --}}
            {{ $products->links() }}

        </div>
    </div>

</div>
@endsection

@push('backend_js')
<script>
    $(document).ready(function () {
        $('#categoryFilter').select2({
            theme: 'bootstrap-5',
            placeholder: '— All Categories —',
            allowClear: true,
        });
    });
</script>
@endpush
