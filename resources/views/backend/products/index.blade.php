@extends('backend.layout')

@section('backend_title')
    Product List
@endsection

@push('backend_css')
    <style>
        .page-title { font-size: 22px; font-weight: 600; color: #111; }

        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        .search-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .table-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }
        .table-meta {
            padding: 10px 1.25rem;
            font-size: 13px;
            color: #6b7280;
            border-bottom: 1px solid #f3f4f6;
        }
        .table-meta strong { color: #111; }

        .product-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .product-table thead tr { background: #f9fafb; }
        .product-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-weight: 500;
            font-size: 13px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        .product-table tbody tr { border-bottom: 1px solid #f3f4f6; }
        .product-table tbody tr:last-child { border-bottom: none; }
        .product-table tbody tr:hover { background: #fafafa; }
        .product-table td { padding: 10px 14px; color: #111; vertical-align: middle; }

        .product-img {
            width: 44px; height: 44px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e5e7eb;
        }
        .product-img-placeholder {
            width: 44px; height: 44px;
            border-radius: 8px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: center;
            color: #9ca3af; font-size: 18px;
        }

        .cat-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }

        .price-main { font-weight: 500; color: #111; font-size: 14px; }
        .price-sale { font-size: 12px; color: #b91c1c; margin-top: 2px; }

        /* Stock badges */
        .stock-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }
        .stock-in      { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .stock-out     { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .stock-pre     { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .stock-default { background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

        .btn-edit-sm {
            padding: 5px 13px;
            font-size: 13px;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit-sm:hover { background: #f9fafb; color: #111; }

        .btn-delete-sm {
            padding: 5px 13px;
            font-size: 13px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-delete-sm:hover { background: #fee2e2; }

        .btn-add {
            background: #111;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-add:hover { background: #333; color: #fff; }

        .search-input {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #111;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .search-input:focus {
            border-color: #9ca3af;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .table-loading {
            opacity: 0.4;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .pagination .page-link {
            border: 1px solid #e5e7eb;
            color: #374151;
            border-radius: 6px !important;
            margin: 0 2px;
            padding: 5px 11px;
            font-size: 13px;
        }
        .pagination .page-item.active .page-link {
            background: #111;
            border-color: #111;
            color: #fff;
        }
        .pagination .page-link:hover { background: #f9fafb; color: #111; }

        @media (max-width: 576px) {
            .hide-mobile { display: none; }
        }
    </style>
@endpush

@section('backend_content')
    <div class="container py-4 px-3 px-md-4" style="max-width: 1100px;">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title mb-0">Products</h2>
            <a href="{{ route('dashboard.products.product-create') }}" class="btn-add">
                + Add Product
            </a>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Search --}}
        <div class="search-card">
            <div class="d-flex gap-2 align-items-end flex-wrap">
                <div class="flex-grow-1" style="min-width: 220px;">
                    <label class="form-label mb-1" style="font-size:13px; font-weight:500; color:#6b7280;">
                        Search by name
                    </label>
                    <input
                        type="text"
                        id="productSearchInput"
                        class="search-input"
                        placeholder="Type to search products..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-card">

            <div class="table-meta" id="tableMeta">
                Total <strong>{{ $products->total() }}</strong> products found
            </div>

            <div class="table-responsive">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th class="hide-mobile">Category</th>
                            <th class="hide-mobile">Price</th>
                            <th class="hide-mobile">Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @include('backend.products.partials.product-table-body')
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center py-3" id="paginationWrap">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
@endsection

@push('backend_js')
<script>
    const productInput   = document.getElementById('productSearchInput');
    const tableBody      = document.getElementById('productTableBody');
    const tableMeta      = document.getElementById('tableMeta');
    const paginationWrap = document.getElementById('paginationWrap');
    const ajaxUrl        = "{{ route('dashboard.products.ajax-search') }}";

    let debounceTimer = null;

    productInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => doSearch(this.value.trim()), 300);
    });

    function doSearch(q) {
        tableBody.classList.add('table-loading');

        fetch(`${ajaxUrl}?q=${encodeURIComponent(q)}`)
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = data.html;

                tableMeta.innerHTML = q
                    ? `Total <strong>${data.total}</strong> products found for "<strong>${q}</strong>"`
                    : `Total <strong>${data.total}</strong> products found`;

                paginationWrap.innerHTML = data.links;
                tableBody.classList.remove('table-loading');
            })
            .catch(() => {
                tableBody.classList.remove('table-loading');
            });
    }
</script>
@endpush
