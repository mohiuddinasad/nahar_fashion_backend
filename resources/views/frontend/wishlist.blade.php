@extends('frontend.layout')
@section('frontend_title', 'My Wishlist')
@section('frontend_content')

    <!-- Page Header -->
    <section class="bg-secondary">
        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="{{ route('frontend.home') }}">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">My Wishlist</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== Start wishlist ========== -->
    <section id="wishlist_product">
        <div class="container">
            @if ($wishlists->isEmpty())
                <div class="alert alert-info text-center my-5">
                    Your wishlist is empty. <a href="{{ route('frontend.shop') }}">Continue Shopping</a>
                </div>
            @else
                <table class="table table-bordered text-center my-5">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Stock Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($wishlists as $wishlist)
                            @php $product = $wishlist->product; @endphp
                            <tr id="wishlist-card-{{ $product->id }}">
                                <td class="align-middle">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <img class="rounded" style="width: 70px;"
                                                src="{{ $product->productImage->first() ? asset('storage/' . $product->productImage->first()->image_name) : asset('assets/img/no-image.png') }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                        <div class="name col-8 p-0" style="text-align: left;">
                                            <h6 class="m-0">
                                                <a href="{{ route('frontend.product-details', $product->slug) }}"
                                                    class="text-dark">
                                                    {{ $product->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">৳{{ $product->price }}</td>
                                <td class="align-middle">
                                    @if ($product->stock_status == 'out_of_stock')
                                        <span class="out_stock">Out of Stock</span>
                                    @else
                                        <span class="in_stock">In Stock</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($product->stock_status == 'out_of_stock')
                                        <button class="btn btn-sm btn-secondary" style="cursor: not-allowed;" disabled>Add to Cart</button>
                                    @else
                                        <button class="btn btn-sm btn-primary" onclick="openProductPopup(this)"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-price="{{ $product->discount_price ?? $product->price }}"
                                            data-image="{{ $product->productImage->first() ? asset('storage/' . $product->productImage->first()->image_name) : asset('assets/img/no-image.png') }}"
                                            data-variants="{{ json_encode($product->productVariant->map(fn($v) => ['id' => $v->id, 'name' => $v->variant_name, 'price' => $v->total_price])) }}">
                                            Add to Cart
                                        </button>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-danger wishlisted"
                                        onclick="event.preventDefault(); toggleWishlist(this, {{ $product->id }})">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
    <!-- ========== End wishlist ========== -->

@endsection
{{-- toggleWishlist function is already in layout.blade.php --}}
