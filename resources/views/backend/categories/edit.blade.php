@extends('backend.layout')
@section('backend_title', 'Edit Category')
@push('backend_css')
@endpush

@section('backend_content')

<div class="pc-content">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Edit Category: {{ $category->name }}</h2>
            <a href="{{ route('dashboard.categories.category-list') }}" class="btn btn-secondary">← Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.categories.category-update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend.categories._form')

            @if($category->category_image)
            <div class="card mt-3">
                <div class="card-header fw-bold">Current Image</div>
                <div class="card-body">
                    <img src="{{ asset($category->category_image) }}"
                         width="120" height="120" style="object-fit:cover;" class="rounded border">
                    <p class="text-muted mt-2 mb-0">
                        <small>Upload a new image above to replace this one.</small>
                    </p>
                </div>
            </div>
            @endif

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Update Category</button>
                <a href="{{ route('dashboard.categories.category-list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>
@endsection

@push('backend_js')

@endpush
