@extends('backend.layout')
@section('backend_title', 'Add New Category')
@push('backend_css')
@endpush

@section('backend_content')
    <div class="pc-content">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Add New Category</h2>
                <a href="{{ route('dashboard.categories.category-list') }}" class="btn btn-secondary">← Back</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dashboard.categories.category-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.categories._form')
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Save Category</button>
                    <a href="{{ route('dashboard.categories.category-list') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>

@endsection

@push('backend_js')
@endpush
