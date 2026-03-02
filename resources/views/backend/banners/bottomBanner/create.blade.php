@extends('backend.layout')
@section('backend_title', 'Secondary Banners')

@push('backend_css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endpush

@section('backend_content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">Add Secondary Banner</h5>
                </div>
                <div class="card-body p-4">

                    <form id="bannerForm" action="{{ route('dashboard.banners.bottom.banner-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" disabled selected>— Select a category —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Banner Image (FilePond) --}}
                        <div class="mb-4">
                            <label for="banner_image" class="form-label">Banner Image <span class="text-danger">*</span></label>
                            <input type="file" id="banner_image" accept="image/*">
                            @error('bottom_image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" onclick="history.back()">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">Save Banner</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('backend_js')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );

        const pond = FilePond.create(document.getElementById('banner_image'), {
            labelIdle: 'Drag & drop your image or <span class="filepond--label-action">Browse</span>',
            acceptedFileTypes: ['image/*'],
            maxFileSize: '5MB',
            imagePreviewHeight: 160,
            allowProcess: false,
            instantUpload: false,
        });

        document.getElementById('bannerForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const files = pond.getFiles();

            if (files.length === 0) {
                alert('Please select a banner image.');
                return;
            }

            const file = files[0].file;
            const dt = new DataTransfer();
            dt.items.add(file);

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = 'bottom_image';
            hiddenInput.style.display = 'none';
            hiddenInput.files = dt.files;

            this.appendChild(hiddenInput);
            this.submit();
        });
    </script>
@endpush