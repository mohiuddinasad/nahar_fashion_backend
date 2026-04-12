@forelse($categories as $category)
    <tr>
        <td style="color:#9ca3af; font-size:13px;">
            {{ $categories->firstItem() + $loop->index }}
        </td>
        <td>
            @if($category->category_image)
                <img src="{{ asset($category->category_image) }}"
                     class="cat-img" alt="{{ $category->name }}">
            @else
                <div class="cat-img-placeholder">—</div>
            @endif
        </td>
        <td>
            <span style="font-weight:500;">{{ $category->name }}</span>
        </td>
        <td class="hide-mobile">
            @if($category->parent)
                <span class="parent-badge">{{ $category->parent->name }}</span>
            @else
                <span class="parent-badge top-badge">Top level</span>
            @endif
        </td>
        <td class="hide-mobile">
            <span class="slug-text">{{ $category->slug }}</span>
        </td>
        <td>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.categories.category-edit', $category) }}"
                   class="btn-edit-sm">Edit</a>

                <form action="{{ route('dashboard.categories.category-delete', $category) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-sm">Delete</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-5" style="color:#9ca3af;">
            No categories found.
        </td>
    </tr>
@endforelse
