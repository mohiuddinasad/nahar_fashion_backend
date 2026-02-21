<div class="row">

    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header fw-bold">Category Details</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="categoryName"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="categorySlug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $category->slug ?? '') }}"
                           placeholder="Auto-generated from name if left empty">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">— None (Top Level) —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $category->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>



            </div>
        </div>
    </div>

    <div class="col-md-4">

        <div class="card mb-3">
            <div class="card-header fw-bold">Category Image</div>
            <div class="card-body">
                <input type="file" name="category_image" class="form-control" accept="image/*"
                       onchange="previewCatImage(event)">
                <small class="text-muted">JPEG, PNG, WebP — max 2MB</small>
                <div class="mt-2">
                    <img id="catImagePreview" src="#" alt="Preview"
                         style="display:none; width:100%; height:150px; object-fit:cover;"
                         class="rounded border">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header fw-bold">SEO (Optional)</div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           value="{{ old('meta_title', $category->meta_title ?? '') }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control"
                           value="{{ old('meta_keywords', $category->meta_keywords ?? '') }}">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Auto-generate slug from name
    document.getElementById('categoryName').addEventListener('input', function () {
        const slugField = document.getElementById('categorySlug');
        if (!slugField.dataset.edited) {
            slugField.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    });

    document.getElementById('categorySlug').addEventListener('input', function () {
        this.dataset.edited = 'true';
    });

    // Image preview
    function previewCatImage(event) {
        const preview = document.getElementById('catImagePreview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
