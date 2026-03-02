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
@push('frontend_css')
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
@endpush
@section('frontend_content')
    <!-- Page Header Start -->
    <section id class="bg-secondary">

        <div class="container">
            <div class="d-flex align-items-center py-3 px-1">
                <div class="d-inline-flex">
                    <p class="m-0"><a href="index.html">Home</a></p>
                    <p class="m-0 px-2">-</p>
                    <p class="m-0">{{ $product->category->name }}</p>
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
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Reviews)</small>
                </div>

                <a href class="wishlist d-flex align-items-center">
                    <span class="d-flex align-items-center"><iconify-icon icon="solar:heart-linear" width="24"
                            height="24"></iconify-icon>
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
                        ৳ {{ number_format($product->productVariant->first()->total_price ?? $product->price, 2) }}
                    </b>

                </p>
                <form action="{{ route('frontend.add.cart') }}" method="GET">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="selectedVariantId"
                        value="{{ $product->productVariant->first()?->id }}">
                    <input type="hidden" name="qty" id="selectedQty" value="1">

                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                    </button>
                </form>

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

                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">1 review for
                                    "Colorful Stylish Shirt"</h4>
                                <div class="media mb-4">
                                    <img src="./assets/img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                        style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan
                                                    2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet
                                            elitr
                                            ea clita ipsum, tempor
                                            labore
                                            accusam ipsum et no at. Kasd
                                            diam tempor rebum magna
                                            dolores
                                            sed sed eirmod ipsum.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be
                                    published. Required fields are
                                    marked
                                    *</small>

                                <form>
                                    <div class="form-group">
                                        <label for="message">Your Review
                                            *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name
                                            *</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email
                                            *</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Submit" class="btn btn-primary px-3">
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
                                        <span class="badge bg-danger text-white">{{ $related->discount_ }}%</span>
                                    </div>
                                    <div class="product-image">
                                        <a href="{{ route('frontend.product-details', $related->slug) }}"><img
                                                src="{{ Storage::url($related->productImage->first()->image_name ?? '') }}"
                                                alt="Colorful Stylish Shirt"></a>
                                        <div class="product-actions">
                                            <button class="action-btn wishlist-btn">
                                                <i class="far fa-heart"></i>
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
                                        <button class="add-to-cart-btn">
                                            <iconify-icon icon="bx:cart" width="24" height="24"></iconify-icon>
                                            <span>Add to Cart</span>
                                        </button>
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
                {{ $product->discount_price ?? $product->price }};

            const qty = parseInt($("#detailQtyInput").val());
            const total = price * qty;

            $("#variantPrice").text("৳ " + total.toFixed(2));
        }
    </script>
@endpush
