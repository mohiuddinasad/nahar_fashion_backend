@extends('backend.layout')

@push('backend_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endpush

@section('backend_content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Categories</h2>
            <a href="{{ route('dashboard.categories.category-create') }}" class="btn btn-primary">+ Add Category</a>
        </div>

        {{-- Success / Error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Search Box --}}
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{ route('dashboard.categories.category-list') }}" method="GET">
                    <div class="row g-3 align-items-end">

                        {{-- Search by Name --}}
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Search by Name</label>
                            <div class="position-relative">
                                <input type="text" name="search" id="categorySearchInput" class="form-control"
                                    placeholder="Type category name..." value="{{ request('search') }}" autocomplete="off">
                                {{-- Suggestion dropdown --}}
                                <ul id="categorySuggestions" class="list-group position-absolute w-100 shadow-sm"
                                    style="display:none; z-index:9999; top:100%; left:0; max-height:220px; overflow-y:auto;">
                                </ul>
                            </div>
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
                    Total <strong>{{ $categories->total() }}</strong> categories found
                    @if (request('search') || request('parent_id'))
                        for your search
                    @endif
                </p>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Parent Category</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td>
                                    @if ($category->category_image)
                                        <img src="{{ Storage::url($category->category_image) }}" width="55"
                                            height="55" style="object-fit:cover;" class="rounded">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent->name ?? '— Top Level' }}</td>
                                <td><small class="text-muted">{{ $category->slug }}</small></td>
                                <td>
                                    <a href="{{ route('dashboard.categories.category-edit', $category) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('dashboard.categories.category-delete', $category) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No categories found.
                                    @if (request('search') || request('parent_id'))
                                        <a href="{{ route('dashboard.categories.category-list') }}">Clear search</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination (keeps search params) --}}
                {{ $categories->links() }}

            </div>
        </div>

    </div>
@endsection

@push('backend_js')
    <script>
        $(document).ready(function() {
            $('#parentFilter').select2({
                theme: 'bootstrap-5',
                placeholder: '— All Categories —',
                allowClear: true,
            });
        });
    </script>

    <script>
        // ── Select2 for parent filter ──────────────────────
        $(document).ready(function() {
            $('#parentFilter').select2({
                theme: 'bootstrap-5',
                placeholder: '— All Categories —',
                allowClear: true,
            });
        });

        // ── Auto suggest for category name ────────────────
        const categoryInput = document.getElementById('categorySearchInput');
        const categorySuggestions = document.getElementById('categorySuggestions');

        categoryInput.addEventListener('input', function() {
            const q = this.value.trim();

            if (q.length < 2) {
                categorySuggestions.style.display = 'none';
                categorySuggestions.innerHTML = '';
                return;
            }

            fetch(`{{ route('dashboard.categories.category-search') }}?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    categorySuggestions.innerHTML = '';

                    if (data.length === 0) {
                        categorySuggestions.style.display = 'none';
                        return;
                    }

                    data.forEach(name => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action';
                        li.style.cursor = 'pointer';
                        li.textContent = name;

                        // Click করলে input এ বসে যাবে এবং form submit হবে
                        li.addEventListener('click', function() {
                            categoryInput.value = name;
                            categorySuggestions.style.display = 'none';
                            categoryInput.closest('form').submit();
                        });

                        categorySuggestions.appendChild(li);
                    });

                    categorySuggestions.style.display = 'block';
                });
        });

        // বাইরে click করলে suggestion বন্ধ হবে
        document.addEventListener('click', function(e) {
            if (!categoryInput.contains(e.target)) {
                categorySuggestions.style.display = 'none';
            }
        });
    </script>
@endpush
