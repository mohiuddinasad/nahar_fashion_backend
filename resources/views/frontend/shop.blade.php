@extends('frontend.layout')
@section('frontend_title', 'Shop')
@push('frontend_css')
@endpush
@section('frontend_content')
    <!-- Page Header Start -->
    <section class="bg-secondary">
        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="{{ route('frontend.home') }}">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">Shop</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Shop Start -->
    <div class="container pt-5">
        <div class="row">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form id="filterForm" method="GET" action="{{ request()->url() }}">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        @php
                            $prices = [
                                '' => 'All Price',
                                '0-500' => '৳ 0 - ৳ 500',
                                '500-1000' => '৳ 500 - ৳ 1000',
                                '1000-1500' => '৳ 1000 - ৳ 1500',
                                '1500-2000' => '৳ 1500 - ৳ 2000',
                                '2000-2500' => '৳ 2000 - ৳ 2500',
                                '2500-3000' => '৳ 2500 - ৳ 3000',
                                '3000-4000' => '৳ 3000 - ৳ 4000',
                            ];
                        @endphp

                        @foreach ($prices as $value => $label)
                            <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                                <input type="radio" class="custom-control-input" name="price"
                                    id="price-{{ $loop->index }}" value="{{ $value }}"
                                    {{ request('price', '') == $value ? 'checked' : '' }}
                                    onchange="document.getElementById('filterForm').submit()">
                                <label class="custom-control-label"
                                    for="price-{{ $loop->index }}">{{ $label }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div id="all_product" class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <form method="GET" action="{{ request()->url() }}"
                            class="d-flex align-items-center justify-content-end mb-4">
                            @if (request('price'))
                                <input type="hidden" name="price" value="{{ request('price') }}">
                            @endif



                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    @php
                                        $sortLabels = [
                                            'latest' => 'Latest',
                                            'price_asc' => 'Price: Low to High',
                                            'price_desc' => 'Price: High to Low',
                                        ];
                                    @endphp
                                    {{ $sortLabels[request('sort', 'latest')] ?? 'Sort by' }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach ($sortLabels as $val => $sortLabel)
                                        <a class="dropdown-item {{ request('sort', 'latest') == $val ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort' => $val, 'page' => 1]) }}">
                                            {{ $sortLabel }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Products --}}
                    @forelse ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 p-2 card_parent">
                            <div class="product_card">
                                <div class="product-badge">
                                    @if ($product->discount_percentage > 0)
                                        <span
                                            class="badge bg-danger text-white">{{ $product->discount_percentage }}%</span>
                                    @endif
                                </div>
                                <div class="product-image">
                                    <a href="{{ route('frontend.product-details', $product->slug) }}">
                                        <img src="{{ asset($product->productImage->first()?->image_name) }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                    <div class="product-actions">
                                        @php
                                            $isWishlisted = Auth::check()
                                                ? Auth::user()->wishlists->contains('product_id', $product->id)
                                                : false;
                                        @endphp
                                        <button type="button"
                                            class="action-btn wishlist-btn {{ $isWishlisted ? 'wishlisted' : '' }}"
                                            onclick="event.preventDefault(); toggleWishlist(this, {{ $product->id }})">
                                            <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <h6 class="product-title">{{ Str::limit($product->name, 28) }}</h6>
                                    <div class="product-price">
                                        <span class="current-price">৳{{ $product->price }}</span>
                                        @if ($product->discount_price > 0)
                                            <span class="old-price">৳ {{ $product->discount_price }}</span>
                                        @endif
                                    </div>

                                    @if ($product->stock_status == 'out_of_stock')
                                        <button class="add-to-cart-btn out_stock" style="cursor: not-allowed" disabled
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                            data-image="{{ asset($product->productImage->first()?->image_name) }}"
                                            data-variants="{{ json_encode($product->productVariant->map(fn($v) => ['id' => $v->id, 'name' => $v->variant_name, 'price' => $v->total_price])) }}">
                                            <iconify-icon icon="bx:cart" width="24" height="24"></iconify-icon>
                                            <span>Out of Stock</span>
                                        </button>
                                    @else
                                        <button class="add-to-cart-btn" style="cursor: pointer"
                                            onclick="openProductPopup(this)" data-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                            data-image="{{ asset($product->productImage->first()?->image_name) }}"
                                            data-variants="{{ json_encode($product->productVariant->map(fn($v) => ['id' => $v->id, 'name' => $v->variant_name, 'price' => $v->total_price])) }}">
                                            <iconify-icon icon="bx:cart" width="24" height="24"></iconify-icon>
                                            <span>Add to Cart</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No products available.
                            </div>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="col-12 pb-1 d-flex justify-content-center my-3">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@push('frontend_js')
    <script>
        const liveSearchInput = document.getElementById('liveSearchInput');
        const liveSearchResults = document.getElementById('liveSearchResults');
        let searchTimeout = null;

        liveSearchInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                liveSearchResults.style.display = 'none';
                liveSearchResults.innerHTML = '';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('frontend.shop.live-search') }}?search=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(products => {
                        liveSearchResults.innerHTML = '';

                        if (products.length === 0) {
                            liveSearchResults.innerHTML = `
                                <div class="list-group-item text-muted text-center py-3">
                                    No products found
                                </div>`;
                            liveSearchResults.style.display = 'block';
                            return;
                        }

                        products.forEach(product => {
                            liveSearchResults.innerHTML += `
                                <a href="/product_details/${product.slug}"
                                    class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2">
                                    <img src="${product.image}" alt="${product.name}"
                                        style="width:48px; height:48px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                                    <div>
                                        <div class="font-weight-semibold" style="font-size:14px;">${product.name}</div>
                                        <div class="text-primary" style="font-size:13px;">৳${product.price}</div>
                                    </div>
                                </a>`;
                        });

                        liveSearchResults.style.display = 'block';
                    })
                    .catch(() => {
                        liveSearchResults.style.display = 'none';
                    });
            }, 100);
        });

        document.addEventListener('click', function(e) {
            if (!liveSearchInput.contains(e.target) && !liveSearchResults.contains(e.target)) {
                liveSearchResults.style.display = 'none';
            }
        });

        liveSearchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2 && liveSearchResults.innerHTML !== '') {
                liveSearchResults.style.display = 'block';
            }
        });
    </script>
@endpush
