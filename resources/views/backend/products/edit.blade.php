@extends('backend.layout')
@section('backend_title', 'Edit Product')
@push('backend_css')
@endpush

@section('backend_content')
<div class="pc-content">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Edit Product: {{ $product->name }}</h2>
            <a href="{{ route('dashboard.products.product-list') }}" class="btn btn-secondary">← Back</a>
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

        <form action="{{ route('dashboard.products.product-update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('backend.products._form')

            @if($product->productImage->count())
            <div class="card mt-3">
                <div class="card-header fw-bold">
                    Current Images
                    <small class="text-muted fw-normal ms-2">(tick checkbox to delete an image)</small>
                </div>
                <div class="card-body d-flex flex-wrap gap-3">
                    @foreach($product->productImage as $img)
                    <div class="text-center">
                        <img src="{{ asset($img->image_name) }}" alt="Product Image"
                             width="100" height="100" style="object-fit:cover;" class="rounded border">
                        <br>
                        <label class="mt-1 text-danger" style="cursor:pointer;">
                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                            Delete
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Update Product</button>
                <a href="{{ route('dashboard.products.product-list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>

@endsection

@push('backend_js')
@endpush
