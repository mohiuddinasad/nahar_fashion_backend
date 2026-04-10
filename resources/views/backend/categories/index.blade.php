@extends('backend.layout')
@section('backend_title', 'Categories')
@push('backend_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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

        .category-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .category-table thead tr { background: #f9fafb; }
        .category-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-weight: 500;
            font-size: 13px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        .category-table tbody tr { border-bottom: 1px solid #f3f4f6; }
        .category-table tbody tr:last-child { border-bottom: none; }
        .category-table tbody tr:hover { background: #fafafa; }
        .category-table td { padding: 10px 14px; color: #111; vertical-align: middle; }

        .cat-img {
            width: 44px; height: 44px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e5e7eb;
        }
        .cat-img-placeholder {
            width: 44px; height: 44px;
            border-radius: 8px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: center;
            color: #9ca3af; font-size: 18px;
        }

        .parent-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        .top-badge {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .slug-text { font-size: 12px; color: #9ca3af; font-family: monospace; }

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

        .btn-search {
            padding: 8px 20px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #111;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-search:hover { background: #f9fafb; }

        /* Loading spinner inside table */
        .table-loading {
            opacity: 0.4;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        /* Pagination */
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
            .btn-search { width: 100%; text-align: center; }
        }
    </style>
@endpush

@section('backend_content')
    <div class="container py-4 px-3 px-md-4" style="max-width: 1100px;">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title mb-0">Categories</h2>
            <a href="{{ route('dashboard.categories.category-create') }}" class="btn-add">
                + Add Category
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
                        id="categorySearchInput"
                        class="search-input"
                        placeholder="Type to search categories..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-card">

            <div class="table-meta" id="tableMeta">
                Total <strong>{{ $categories->total() }}</strong> categories found
            </div>

            <div class="table-responsive">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th class="hide-mobile">Parent</th>
                            <th class="hide-mobile">Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        @include('backend.categories.partials.category-table-body')
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center py-3" id="paginationWrap">
                {{ $categories->links() }}
            </div>

        </div>
    </div>
@endsection

@push('backend_js')
<script>
    const categoryInput  = document.getElementById('categorySearchInput');
    const tableBody      = document.getElementById('categoryTableBody');
    const tableMeta      = document.getElementById('tableMeta');
    const paginationWrap = document.getElementById('paginationWrap');
    const ajaxUrl        = "{{ route('dashboard.categories.ajax-search') }}";

    let debounceTimer = null;

    // Type করলে AJAX search
    categoryInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => doSearch(this.value.trim()), 300);
    });

    function doSearch(q) {
        // Loading state
        tableBody.classList.add('table-loading');

        fetch(`${ajaxUrl}?q=${encodeURIComponent(q)}`)
            .then(res => res.json())
            .then(data => {
                // Table rows update
                tableBody.innerHTML = data.html;

                // Meta text update
                if (q) {
                    tableMeta.innerHTML = `Total <strong>${data.total}</strong> categories found for "<strong>${q}</strong>"`;
                } else {
                    tableMeta.innerHTML = `Total <strong>${data.total}</strong> categories found`;
                }

                // Pagination update
                paginationWrap.innerHTML = data.links;

                tableBody.classList.remove('table-loading');
            })
            .catch(() => {
                tableBody.classList.remove('table-loading');
            });
    }
</script>
@endpush
