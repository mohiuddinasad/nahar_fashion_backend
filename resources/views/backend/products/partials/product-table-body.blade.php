@forelse($products as $product)
    @php
        $stockClass = match($product->stock_status) {
            'in_stock'     => 'stock-in',
            'out_of_stock' => 'stock-out',
            'pre_order'    => 'stock-pre',
            default        => 'stock-default'
        };
    @endphp
    <tr>
        <td style="color:#9ca3af; font-size:13px;">
            {{ $products->firstItem() + $loop->index }}
        </td>
        <td>
            @if($product->productImage->first())
                <img src="{{ Storage::url($product->productImage->first()->image_name) }}"
                     class="product-img" alt="{{ $product->name }}">
            @else
                <div class="product-img-placeholder">—</div>
            @endif
        </td>
        <td><span style="font-weight:500;">{{ $product->name }}</span></td>
        <td class="hide-mobile">
            <span class="cat-badge">{{ $product->category->name ?? '—' }}</span>
        </td>
        <td class="hide-mobile">
            <div class="price-main">${{ number_format($product->price, 2) }}</div>
           
        </td>
        <td class="hide-mobile">
            <span class="stock-badge {{ $stockClass }}">
                {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
            </span>
        </td>
        <td>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.products.product-edit', $product) }}"
                   class="btn-edit-sm">Edit</a>

                <form action="{{ route('dashboard.products.product-delete', $product) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-sm">Delete</button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-5" style="color:#9ca3af;">
            No products found.
        </td>
    </tr>
@endforelse
