@extends('backend.layout')
@section('backend_title', 'Secondary Banners')

@push('backend_css')
@endpush

@section('backend_content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0 fw-semibold">Secondary Banners</h5>
                <a href="{{ route('dashboard.banners.bottom.banner-create') }}" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-plus me-1"></i> Add Banner
                </a>
            </div>

            {{-- Table Card --}}
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:50px">#</th>
                                <th>Image</th>
                                <th>Category</th>
                               
                                <th>Created At</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $key => $banner)
                                
                            <tr>
                                <td class="ps-4 text-muted small">{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset($banner->bottom_image) }}" alt="Banner"
                                         class="rounded border"
                                         style="width:100px; height:50px; object-fit:cover;">
                                </td>
                                <td><span class="fw-medium">{{ $banner->category->name }}</span></td>
                               
                                <td class="text-muted small">{{ $banner->created_at->format('d M Y') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('dashboard.banners.bottom.banner-edit', $banner->id) }}" class="btn btn-sm btn-light border me-1" title="Edit">
                                        <i class="fas fa-pen fa-xs"></i>
                                    </a>
                                    <a href="{{ route('dashboard.banners.bottom.banner-delete', $banner->id) }}" class="btn btn-sm btn-light border text-danger" title="Delete">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-lg me-2"></i> No banners found.
                                </td>
                            @endforelse
                           
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('backend_js')
@endpush