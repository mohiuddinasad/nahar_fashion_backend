<div class="row">

    {{-- LEFT COLUMN --}}
    <div class="col-md-8">

        <div class="card mb-3">
            <div class="card-header fw-bold">Basic Information</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="productName"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" id="productSlug" class="form-control"
                        value="{{ old('slug', $product->slug ?? '') }}" placeholder="Auto-generated from name if empty">
                </div>

                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="categorySelect"
                        class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">— Select Category —</option>
                        @foreach ($categories as $cat)
                            {{-- Parent Category --}}
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>

                            {{-- Children Categories --}}
                            @foreach ($cat->children as $child)
                                <option value="{{ $child->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $child->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;↳ {{ $child->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header fw-bold">Pricing & Stock</div>
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="{{ old('price', $product->price ?? '') }}" required min="0">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Discount Price</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="discount_price" class="form-control"
                            value="{{ old('discount_price', $product->discount_price ?? '') }}" min="0">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Discount %</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="discount_percentage" class="form-control"
                            value="{{ old('discount_percentage', $product->discount_percentage ?? '') }}"
                            min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" class="form-control"
                        value="{{ old('quantity', $product->quantity ?? 0) }}" required min="0">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Stock Status</label>
                    <select name="stock_status" class="form-select">
                        @foreach (['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock', 'pre_order' => 'Pre Order'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('stock_status', $product->stock_status ?? 'in_stock') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                            {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">Featured</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_new" value="1"
                            {{ old('is_new', $product->is_new ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label">New</label>
                    </div>
                </div>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                Product size
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addVariant()">+ Add
                    size</button>
            </div>
            <div class="card-body" id="variantContainer">
                @if (isset($product) && $product->productVariant->count())
                    @foreach ($product->productVariant as $i => $variant)
                        <div class="row g-2 mb-2 variant-row">
                            <div class="col-md-6">
                                <input type="text" name="variants[{{ $i }}][variant_name]"
                                    class="form-control" placeholder="e.g. Red / XL"
                                    value="{{ $variant->variant_name }}">
                            </div>
                            <div class="col-md-5">
                                <input type="number" step="0.01"
                                    name="variants[{{ $i }}][total_price]" class="form-control"
                                    placeholder="Price" value="{{ $variant->total_price }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="this.closest('.variant-row').remove()">✕</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted mb-0" id="noVariantMsg">
                        No variants yet. Click "+ Add Variant" to add one.
                    </p>
                @endif
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-md-4">

        <div class="card mb-3">
            <div class="card-header fw-bold">Product Images</div>
            <div class="card-body">
                <input type="file" name="images[]" class="form-control" multiple accept="image/*"
                    onchange="previewImages(event)">
                <small class="text-muted">Select multiple. JPEG, PNG, WebP — max 2MB each.</small>
                <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header fw-bold">SEO (Optional)</div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                        value="{{ old('meta_title', $product->meta_title ?? '') }}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control"
                        value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // ── Slug auto-generate ──────────────────────────────
    document.getElementById('productName').addEventListener('input', function() {
        const slugField = document.getElementById('productSlug');
        if (!slugField.dataset.edited) {
            slugField.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    });
    document.getElementById('productSlug').addEventListener('input', function() {
        this.dataset.edited = 'true';
    });

    // ── Variant add/remove ──────────────────────────────
    let variantIndex = document.querySelectorAll('.variant-row').length;

    function addVariant() {
        const container = document.getElementById('variantContainer');
        const msg = document.getElementById('noVariantMsg');
        if (msg) msg.remove();

        container.insertAdjacentHTML('beforeend', `
            <div class="row g-2 mb-2 variant-row">
                <div class="col-md-6">
                    <input type="text" name="variants[${variantIndex}][variant_name]"
                           class="form-control" placeholder="e.g. Red / XL">
                </div>
                <div class="col-md-5">
                    <input type="number" step="0.01" name="variants[${variantIndex}][total_price]"
                           class="form-control" placeholder="Price">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm"
                            onclick="this.closest('.variant-row').remove()">✕</button>
                </div>
            </div>
        `);
        variantIndex++;
    }

    // ── Image preview ───────────────────────────────────
    function previewImages(event) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        [...event.target.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                preview.insertAdjacentHTML('beforeend',
                    `<img src="${e.target.result}" width="80" height="80"
                          style="object-fit:cover;" class="rounded border">`
                );
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Select2 category ────────────────────────────────
    $(document).ready(function() {
        $('#categorySelect').select2({
            theme: 'bootstrap-5',
            placeholder: '— Select Category —',
            allowClear: true,
            width: '100%',


        });
    });
</script>
