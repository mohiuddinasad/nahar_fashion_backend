@php
    $cart = session()->get('cart', []);
    $qty = array_sum(array_column($cart, 'qty'));
@endphp

@php
    $total_price = 0;
@endphp

@foreach ($cart as $id => $data)
    @php
        $total_price += $data['price'] * $data['qty'];
    @endphp
@endforeach

@extends('frontend.layout')
@section('frontend_title', $product->name)

@section('meta')
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ Str::limit($product->description, 150) }}">
    <meta property="og:image" content="{{ asset(Storage::url($product->productImage->first()?->image_name)) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">
@endsection
@push('frontend_css')
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">

    <style>
        .demo-card {
            background: white;
            border-radius: 16px;
            padding: 36px 40px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
            min-width: 320px;
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: #25D366;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 17px;
            font-weight: 800;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            padding: 13px 26px 13px 20px;
            cursor: pointer;
            letter-spacing: 0.01em;
            box-shadow: 0 2px 10px rgba(37, 211, 102, 0.28);
            transition: background 0.18s, transform 0.13s, box-shadow 0.18s;
            position: relative;
            overflow: hidden;
        }

        .whatsapp-btn:hover {
            background: #1ebe5d;
            transform: translateY(-2px) scale(1.025);
            box-shadow: 0 6px 22px rgba(37, 211, 102, 0.38);
        }

        .whatsapp-btn:active {
            transform: scale(0.97);
            box-shadow: 0 1px 6px rgba(37, 211, 102, 0.18);
        }

        .whatsapp-btn .wa-icon {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.12));
        }

        .phone-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #222;
            font-size: 20px;
            font-weight: 800;
        }

        .phone-row .wa-circle-wrap {
            position: relative;
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .phone-row .wa-circle-wrap::before,
        .phone-row .wa-circle-wrap::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.25);
            animation: wa-pulse 2s ease-out infinite;
        }

        .phone-row .wa-circle-wrap::before {
            width: 100%;
            height: 100%;
            animation-delay: 0s;
        }

        .phone-row .wa-circle-wrap::after {
            width: 130%;
            height: 130%;
            animation-delay: 0.5s;
            background: rgba(37, 211, 102, 0.12);
        }

        @keyframes wa-pulse {
            0% {
                transform: scale(0.85);
                opacity: 1;
            }

            70% {
                transform: scale(1.35);
                opacity: 0;
            }

            100% {
                transform: scale(1.35);
                opacity: 0;
            }
        }

        .phone-row .wa-circle {
            width: 44px;
            height: 44px;
            background: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 12px rgba(37, 211, 102, 0.45);
            border: 2px solid #1ebe5d;
            position: relative;
            z-index: 1;
        }

        .phone-row .wa-circle svg {
            width: 22px;
            height: 22px;
        }

        .label {
            font-size: 13px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: -6px;
        }
    </style>
@endpush
@section('frontend_content')
    <!-- Page Header Start -->
    <section id class="bg-secondary">

        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="index.html">Home</a></p>

                    <p class="m-0 px-2">-</p>
                    <p class="m-0">{{ $product->name }}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header End -->

    <!-- Shop Detail Start -->

    <div class="details container py-5">
        <div class="row">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">

                        @foreach ($product->productImage as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ Storage::url($image->image_name) }}" alt="Image">
                            </div>
                        @endforeach


                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <div class="d-flex align-items-center mb-3">
                    <h3 class="font-weight-semi-bold m-0">{{ $product->name }}</h3>
                    @if ($product->stock_status == 'in_stock')
                        <span class="badge bg-primary text-white rounded mx-2">In Stock</span>
                    @else
                        <span class="badge bg-danger text-white rounded mx-2">Out of Stock</span>
                    @endif
                </div>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        @php $avg = round($product->reviews->avg('rating')); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $avg)
                                <small class="fas fa-star"></small>
                            @else
                                <small class="far fa-star"></small>
                            @endif
                        @endfor
                    </div>
                    <small class="pt-1">({{ $product->reviews->count() }} Reviews)</small>
                </div>

                @php
                    $isWishlisted = Auth::check()
                        ? Auth::user()->wishlists->contains('product_id', $product->id)
                        : false;
                @endphp

                <a href="" class="wishlist d-flex align-items-center {{ $isWishlisted ? 'wishlisted' : '' }}"
                    onclick="event.preventDefault(); toggleWishlist(this, {{ $product->id }})">
                    <span class="d-flex align-items-center"><i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
                    </span>
                    Add to wishlist
                </a>
                <p>Brand : <span class="text-primary">Nahar
                        Fashion</span></p>
                <div class="price d-flex align-items-center mb-4">
                    <p class="m-0">Price : <b class="text-primary">৳
                            {{ number_format($product->price, 2) }}</b>/1</p>
                    <div class="discount_percent">
                        @if ($product->discount_percentage > 0)
                            <p class="text-danger mx-3 mb-0">-{{ $product->discount_percentage }}%</p>
                        @else
                            <p class="text-danger mx-3 mb-0 d-none">-{{ $product->discount_percentage }}%</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    <form>
                        <div class="radio-group">
                            @foreach ($product->productVariant as $variant)
                                <div class="radio-box">
                                    <input type="radio" name="variant" id="variant_{{ $loop->index }}"
                                        value="{{ $variant->id }}" data-price="{{ $variant->total_price }}"
                                        {{ $loop->first ? 'checked' : '' }}>
                                    <label for="variant_{{ $loop->index }}">
                                        {{ $variant->variant_name }}
                                    </label>
                                </div>
                            @endforeach


                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" id="detailQtyInput" class="form-control bg-secondary text-center"
                            value="1" readonly>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="total_price">Total Price :
                    <b class="text-primary font-weight-bold" id="variantPrice">
                        @if ($product->productVariant->isNotEmpty())
                            ৳ {{ number_format($product->productVariant->first()->total_price, 2) }}
                        @else
                            ৳ {{ number_format($product->price, 2) }}
                        @endif
                    </b>
                </p>
                <form action="{{ route('frontend.add.cart') }}" method="GET">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="selectedVariantId"
                        value="{{ $product->productVariant->first()?->id }}">
                    <input type="hidden" name="qty" id="selectedQty" value="1">

                    <button type="submit"
                        class="btn btn-primary px-3 {{ $product->stock_status == 'out_of_stock' ? 'disabled' : '' }}"
                        {{ $product->stock_status == 'out_of_stock' ? 'disabled' : '' }}
                        style="{{ $product->stock_status == 'out_of_stock' ? 'cursor: not-allowed; background-color: #cccccc; color: #fff; border: none;' : 'cursor: pointer;' }}">
                        <i class="fa fa-shopping-cart mr-1"></i>
                        {{ $product->stock_status == 'out_of_stock' ? 'Out of Stock' : 'Add To Cart' }}
                    </button>
                </form>

                @php
                    $productUrl = route('frontend.product-details', $product->slug);

                    $message = $productUrl . "\n\n";
                    $message .= 'Hello! I am interested in this product.';
                @endphp
                <div class="order_btn">
                    <a href="https://wa.me/8801761955564?text={{ urlencode($message) }}" target="_blank">
                        <button class="whatsapp-btn mt-3">
                            Order via WhatsApp
                        </button>
                    </a>
                </div>
                <div class="d-flex pt-2 mt-3">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share
                        on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href>
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href>
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href>
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href>
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews
                        ({{ $product->reviews->count() }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            {{-- ======= REVIEWS LIST ======= --}}
                            <div class="col-md-6">


                                @forelse ($product->reviews as $review)
                                    <div class="media mb-4">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3 mt-1"
                                            style="width: 45px; height: 45px; font-size: 18px; font-weight: bold; flex-shrink: 0;">
                                            {{ strtoupper(substr($review->name, 0, 1)) }}
                                        </div>
                                        <div class="media-body">
                                            <h6>{{ $review->name }}
                                                <small> - <i>{{ $review->created_at->format('d M Y') }}</i></small>
                                            </h6>

                                            {{-- Star Rating --}}
                                            <div class="text-primary mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>

                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No reviews yet. Be the first to review!</p>
                                @endforelse
                            </div>

                            {{-- ======= REVIEW FORM ======= --}}
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published.
                                    Required fields are marked *</small>

                                {{-- Success Message --}}
                                @if (session('success'))
                                    <div class="alert alert-success mt-2">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('frontend.reviews.store', $product->id) }}" method="POST"
                                    class="mt-3">
                                    @csrf

                                    {{-- Rating --}}
                                    <div class="form-group">
                                        <label>Your Rating *</label>
                                        <div class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star rating-star" data-value="{{ $i }}"
                                                    style="cursor:pointer; font-size: 1.5rem;"></i>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="rating-value"
                                            value="{{ old('rating', 5) }}">
                                        @error('rating')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Comment --}}
                                    <div class="form-group">
                                        <label for="comment">Your Review *</label>
                                        <textarea name="comment" id="comment" cols="30" rows="5"
                                            class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
                                        @error('comment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Name --}}
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary px-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <section id="related_product">
        <div class="container">

            <div class=" py-5">
                <div class="mb-4">
                    <h2 class><span class="px-2">Related Products</span></h2>
                    <hr>
                </div>
                <div id="all_product" class="row">
                    <div class="col">
                        <div class="owl-carousel related-carousel">

                            @foreach ($relatedProducts as $related)
                                <div class="product_card">
                                    <div class="product-badge">
                                        @if ($related->discount_percentage > 0)
                                            <span
                                                class="badge bg-danger text-white">{{ $related->discount_percentage }}%</span>
                                        @endif
                                    </div>
                                    <div class="product-image">
                                        <a href="{{ route('frontend.product-details', $related->slug) }}"><img
                                                src="{{ Storage::url($related->productImage->first()->image_name ?? '') }}"
                                                alt="Colorful Stylish Shirt"></a>
                                        <div class="product-actions">
                                            @php
                                                $isWishlisted = Auth::check()
                                                    ? Auth::user()->wishlists->contains('product_id', $related->id)
                                                    : false;
                                            @endphp
                                            <button type="button"
                                                class="action-btn wishlist-btn {{ $isWishlisted ? 'wishlisted' : '' }}"
                                                onclick="event.preventDefault(); toggleWishlist(this, {{ $related->id }})">
                                                <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-title">{{ $related->name }}</h6>
                                        <div class="product-price">
                                            <span class="current-price">৳{{ number_format($related->price, 2) }}</span>
                                            @if ($related->discount_price > 0)
                                                <span
                                                    class="old-price">৳{{ number_format($related->discount_price ?? 0, 2) }}</span>
                                            @else
                                                <span
                                                    class="old-price d-none">৳{{ number_format($related->discount_price ?? 0, 2) }}</span>
                                            @endif
                                        </div>
                                        @if ($related->stock_status == 'out_of_stock')
                                            <button class="add-to-cart-btn out_stock" style="cursor: not-allowed" disabled
                                                data-id="{{ $related->id }}" data-name="{{ $related->name }}"
                                                data-price="{{ $related->price }}"
                                                data-image="{{ $related->productImage->first() ? asset('storage/' . $related->productImage->first()->image_name) : asset('assets/img/no-image.png') }}"
                                                data-variants="{{ json_encode($related->productVariant->map(fn($v) => ['id' => $v->id, 'name' => $v->variant_name, 'price' => $v->total_price])) }}">
                                                <iconify-icon icon="bx:cart" width="24"
                                                    height="24"></iconify-icon>
                                                <span>Out of Stock</span>
                                            </button>
                                        @else
                                            <button class="add-to-cart-btn" style="cursor: pointer"
                                                onclick="openProductPopup(this)" data-id="{{ $related->id }}"
                                                data-name="{{ $related->name }}" data-price="{{ $related->price }}"
                                                data-image="{{ $related->productImage->first() ? asset('storage/' . $related->productImage->first()->image_name) : asset('assets/img/no-image.png') }}"
                                                data-variants="{{ json_encode($related->productVariant->map(fn($v) => ['id' => $v->id, 'name' => $v->variant_name, 'price' => $v->total_price])) }}">
                                                <iconify-icon icon="bx:cart" width="24"
                                                    height="24"></iconify-icon>
                                                <span>Add to Cart</span>
                                            </button>
                                        @endif


                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Products End -->
@endsection
@push('frontend_js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {

            // ── main.js এর listener বন্ধ করুন ────────────
            $(".quantity button").off("click");

            // ── নতুন listener ─────────────────────────────
            $(".btn-plus").on("click", function() {
                const input = $("#detailQtyInput");
                const newVal = parseInt(input.val()) + 1;
                input.val(newVal);
                $("#selectedQty").val(newVal);
                updateTotalPrice();
            });

            $(".btn-minus").on("click", function() {
                const input = $("#detailQtyInput");
                const newVal = Math.max(1, parseInt(input.val()) - 1);
                input.val(newVal);
                $("#selectedQty").val(newVal);
                updateTotalPrice();
            });


            const firstChecked = document.querySelector('input[name="variant"]:checked');
            if (firstChecked) {
                $("#selectedVariantId").val(firstChecked.value);
                updateTotalPrice();
            }

            // ── Variant change ────────────────────────────
            $('input[name="variant"]').on('change', function() {
                $("#selectedVariantId").val(this.value);
                updateTotalPrice();
            });

        });

        // ── Total Price Calculate ─────────────────────────
        function updateTotalPrice() {
            const selectedVariant = document.querySelector('input[name="variant"]:checked');
            const price = selectedVariant ?
                parseFloat(selectedVariant.dataset.price) :
                {{ $product->price }};

            const qty = parseInt($("#detailQtyInput").val());
            const total = price * qty;

            $("#variantPrice").text("৳ " + total.toFixed(2));
        }
    </script>

    <script>
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating-value');

        function highlightStars(value) {
            stars.forEach(star => {
                star.style.color = star.dataset.value <= value ? '#f5a623' : '#ccc';
            });
        }

        // Set initial highlight
        highlightStars(ratingInput.value);

        stars.forEach(star => {
            star.addEventListener('click', () => {
                ratingInput.value = star.dataset.value;
                highlightStars(star.dataset.value);
            });

            star.addEventListener('mouseover', () => highlightStars(star.dataset.value));
            star.addEventListener('mouseleave', () => highlightStars(ratingInput.value));
        });
    </script>
@endpush
