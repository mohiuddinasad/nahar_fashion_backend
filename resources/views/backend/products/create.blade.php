@extends('backend.layout')
@section('backend_title', 'Add New Product')
@push('backend_css')

@endpush

@section('backend_content')

<div class="pc-content">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Add New Product</h2>
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

        <form action="{{ route('dashboard.products.product-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('backend.products._form')
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save Product</button>
                <a href="{{ route('dashboard.products.product-list') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

    </div>
</div>
@endsection

@push('backend_js')
@endpush
