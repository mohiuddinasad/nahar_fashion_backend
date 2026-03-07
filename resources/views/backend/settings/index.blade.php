@extends('backend.layout')
@section('backend_title', 'Website Settings')
@section('backend_content')

<div class="container p-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-4">

            {{-- ===== LEFT COLUMN ===== --}}
            <div class="col-lg-8">

                {{-- General Settings --}}
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold">
                            <i class="fas fa-globe me-2 text-primary"></i>General Settings
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Site Name <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                                   value="{{ old('site_name', $setting->site_name) }}"
                                   placeholder="My Awesome Shop">
                            @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            {{-- Logo --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Site Logo</label>
                                <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror"
                                       accept="image/*" onchange="previewImage(this, 'logo_preview')">
                                @error('site_logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    @if($setting->site_logo)
                                        <img id="logo_preview" src="{{ Storage::url($setting->site_logo) }}"
                                             class="img-thumbnail" style="height:80px; object-fit:contain;">
                                    @else
                                        <img id="logo_preview" src="#" class="img-thumbnail d-none"
                                             style="height:80px; object-fit:contain;">
                                    @endif
                                </div>
                                <small class="text-muted">PNG, JPG, WEBP — max 2MB</small>
                            </div>

                            {{-- Favicon --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Favicon</label>
                                <input type="file" name="site_favicon" class="form-control @error('site_favicon') is-invalid @enderror"
                                       accept="image/*" onchange="previewImage(this, 'favicon_preview')">
                                @error('site_favicon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    @if($setting->site_favicon)
                                        <img id="favicon_preview" src="{{ Storage::url($setting->site_favicon) }}"
                                             class="img-thumbnail" style="height:48px; object-fit:contain;">
                                    @else
                                        <img id="favicon_preview" src="#" class="img-thumbnail d-none"
                                             style="height:48px; object-fit:contain;">
                                    @endif
                                </div>
                                <small class="text-muted">PNG, ICO — max 512KB</small>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold">
                            <i class="fas fa-address-book me-2 text-success"></i>Contact Information
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="contact_phone" class="form-control"
                                           value="{{ old('contact_phone', $setting->contact_phone) }}"
                                           placeholder="+880 1XXXXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                                           value="{{ old('contact_email', $setting->contact_email) }}"
                                           placeholder="info@example.com">
                                    @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-location-dot"></i></span>
                                    <textarea name="contact_address" class="form-control" rows="2"
                                              placeholder="Dhaka, Bangladesh">{{ old('contact_address', $setting->contact_address) }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- SEO Settings --}}
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h6 class="fw-bold">
                            <i class="fas fa-magnifying-glass me-2 text-warning"></i>SEO Settings
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ old('meta_title', $setting->meta_title) }}"
                                   placeholder="Best Online Shop in Bangladesh"
                                   maxlength="255">
                            <small class="text-muted">Recommended: 50–60 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"
                                      placeholder="Short description of your website..." maxlength="500">{{ old('meta_description', $setting->meta_description) }}</textarea>
                            <small class="text-muted">Recommended: 150–160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control"
                                   value="{{ old('meta_keywords', $setting->meta_keywords) }}"
                                   placeholder="shop, ecommerce, bangladesh, online">
                            <small class="text-muted">Comma separated keywords</small>
                        </div>

                        <div class="mb-1">
                            <label class="form-label fw-semibold">OG / Meta Image</label>
                            <input type="file" name="meta_image" class="form-control @error('meta_image') is-invalid @enderror"
                                   accept="image/*" onchange="previewImage(this, 'meta_img_preview')">
                            @error('meta_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-2">
                                @if($setting->meta_image)
                                    <img id="meta_img_preview" src="{{ Storage::url($setting->meta_image) }}"
                                         class="img-thumbnail" style="height:80px; object-fit:cover;">
                                @else
                                    <img id="meta_img_preview" src="#" class="img-thumbnail d-none"
                                         style="height:80px; object-fit:cover;">
                                @endif
                            </div>
                            <small class="text-muted">Recommended: 1200×630px</small>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ===== RIGHT COLUMN ===== --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 80px;">
                    <div class="card-body text-center p-4">
                        <h6 class="fw-bold mb-3">Save Changes</h6>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-save me-2"></i>Update Settings
                        </button>
                        <a href="{{ route('dashboard.settings.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-rotate-left me-1"></i>Reset
                        </a>

                        <hr>

                        {{-- Current Info Preview --}}
                        <div class="text-start">
                            <p class="small text-muted fw-semibold mb-2">CURRENT INFO</p>
                            <p class="small mb-1">
                                <i class="fas fa-globe me-2 text-primary"></i>
                                {{ $setting->site_name ?? '—' }}
                            </p>
                            <p class="small mb-1">
                                <i class="fas fa-phone me-2 text-success"></i>
                                {{ $setting->contact_phone ?? '—' }}
                            </p>
                            <p class="small mb-1">
                                <i class="fas fa-envelope me-2 text-warning"></i>
                                {{ $setting->contact_email ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('backend_js')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush