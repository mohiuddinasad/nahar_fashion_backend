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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <title>@yield('frontend_title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="./assets/img/favicon.ico" rel="icon">
    <!-- <link rel="stylesheet" href="./assets/css/bootstrap.min.css"> -->

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
    @stack('frontend_css')
</head>

<body>
    <!-- Topbar Start -->
    <div class="container">

        <div class="row align-items-center py-3">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h2 class="m-0 display-5 font-weight-semi-bold"><span class>Nahar Fashion</h2>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                @php
                    $wishlistCount = Auth::check() ? Auth::user()->wishlists()->count() : 0;
                @endphp
                <a href="{{ route('frontend.wishlist') }}" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge" id="wishlistCount">{{ $wishlistCount }}</span>
                </a>
                <a href="{{ route('frontend.cart') }}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">{{ $qty ? $qty : 0 }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div id="navbar" class="container">
        <div class="row border-top">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">


                        @forelse ($categories as $category)
                            @if ($category->children->count() > 0)
                                <div class="nav-item dropdown">
                                    <a href="{{ route('frontend.category-wise-product', $category->slug) }}"
                                        class="nav-link" data-toggle="dropdown"> {{ $category->name }} <i
                                            class="fa fa-angle-down float-right mt-1"></i></a>
                                    <div
                                        class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                        @foreach ($category->children as $child)
                                            <a href="{{ route('frontend.category-wise-product', $child->slug) }}"
                                                class="dropdown-item">{{ $child->name }}</a>
                                        @endforeach

                                    </div>
                                </div>
                            @else
                                <a href="{{ route('frontend.category-wise-product', $category->slug) }}"
                                    class="nav-item nav-link">{{ $category->name }}</a>
                            @endif
                        @empty
                            <p class="text-center">No category found</p>
                        @endforelse
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href class="text-decoration-none d-block d-lg-none">
                        <h4 class="m-0 display-5 font-weight-semi-bold">Nahar
                            Fashion</h4>
                    </a>
                    <button type="button" class="d-lg-none menu-btn" id="menuBtn">
                        <iconify-icon icon="ic:round-menu" width="24" height="24"></iconify-icon>
                    </button>

                    <!-- Overlay -->
                    <div class="overlay" id="overlay"></div>

                    <!-- Sidebar -->
                    <div class="sidebar" id="sidebar">
                        <!-- Sidebar Header -->
                        <div class="sidebar-header">
                            <h2>Navigation</h2>
                            <button class="close-btn" id="closeBtn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Tabs -->
                        <div class="tabs">
                            <button class="tab-btn active" data-tab="menus">Menus</button>
                            <button class="tab-btn" data-tab="categories">Categories</button>
                        </div>

                        <!-- Menus Tab Content -->
                        <div class="tab-content" id="menus">
                            <a href="#home" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <span>Home</span>
                            </a>
                            <a href="#shop" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Shop</span>
                            </a>
                            <a href="#profile" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profile</span>
                            </a>
                            <a href="#settings" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Settings</span>
                            </a>
                        </div>

                        <!-- Categories Tab Content -->
                        <div class="tab-content" id="categories">
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="category-name">Smartphones</span>
                                </div>
                                <span class="category-count">45</span>
                            </button>
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="category-name">Laptops</span>
                                </div>
                                <span class="category-count">32</span>
                            </button>
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                    <span class="category-name">Audio</span>
                                </div>
                                <span class="category-count">28</span>
                            </button>
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="category-name">Wearables</span>
                                </div>
                                <span class="category-count">19</span>
                            </button>
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="category-name">Cameras</span>
                                </div>
                                <span class="category-count">15</span>
                            </button>
                            <button class="category-item">
                                <div class="category-left">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="category-name">Gaming</span>
                                </div>
                                <span class="category-count">38</span>
                            </button>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('frontend.home') }}" class="nav-item nav-link">Home</a>
                            <a href="{{ route('frontend.shop') }}" class="nav-item nav-link">Shop</a>
                            <a href="shop.html" class="nav-item nav-link">Wholesale</a>
                            <a href="{{ route('frontend.contact') }}" class="nav-item nav-link">Contact</a>
                            <a href="contact.html" class="nav-item nav-link">Track Order</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            @auth
                                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Profile</a>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="nav-item nav-link btn btn-link" style="display:inline-flex;align-items:center; ">
                                        <span>Logout</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                                <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
    <!-- ========== Start cart popup ========== -->

    <!-- Overlay -->

    <section>


        <div id="cartPopupOverlay" onclick="closePopup()">

        </div>

        <div id="cartPopup">

            <!-- Left: Image Panel -->
            <div class="cp-left">
                <div class="cp-img-wrap">
                    <img id="popupImage" src="https://via.placeholder.com/300x350" alt="Product">
                    <div class="cp-img-shine"></div>
                </div>

                <!-- Floating decorative circles -->
                <div class="cp-circle cp-circle-1"></div>
                <div class="cp-circle cp-circle-2"></div>
                <div class="cp-circle cp-circle-3"></div>
            </div>

            <!-- Right: Info Panel -->
            <div class="cp-right">

                <!-- Close -->
                <a class="cp-close" onclick="closePopup()">
                    <iconify-icon icon="mingcute:close-fill" width="18" height="18"></iconify-icon>
                </a>

                <!-- Animated content blocks -->
                <div class="cp-anim-block" style="--delay: 0.05s">
                    <div class="cp-category">✦ New Arrival</div>
                    <h3 class="cp-name" id="popupName">Product Name</h3>
                </div>

                <div class="cp-anim-block" style="--delay: 0.1s">
                    <div class="cp-price-row">
                        <span class="cp-price" id="popupPrice">৳ 0.00</span>
                        <span class="cp-badge">In Stock</span>
                    </div>
                </div>

                <div class="cp-divider cp-anim-block" style="--delay: 0.15s"></div>

                <!-- Variants -->
                <div id="popupVariantSection" class="cp-anim-block" style="--delay: 0.2s">
                    <p class="cp-label">Select Variant</p>
                    <div id="popupVariants" class="cp-variants"></div>
                </div>

                <!-- Quantity -->
                <div class="cp-qty-wrap cp-anim-block" style="--delay: 0.25s">
                    <p class="cp-label">Quantity</p>
                    <div class="cp-qty">
                        <button id="popupQtyMinus" onclick="popupQtyChange(-1)" class="cp-qty-btn">−</button>
                        <input type="number" id="popupQty" value="1" min="1" class="cp-qty-input">
                        <button id="popupQtyPlus" onclick="popupQtyChange(1)" class="cp-qty-btn">+</button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <a id="popupAddToCartLink" href="#" class="cp-add-btn cp-anim-block" style="--delay: 0.3s">
                    <span>Add to Cart</span>
                    <svg class="cp-btn-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                    <div class="cp-ripple"></div>
                </a>



            </div>
        </div>

        <input type="hidden" id="popupProductId" value="">
        <input type="hidden" id="popupVariantId" value="">
    </section>

    <!-- ========== End cart popup ========== -->

    @yield(section: 'frontend_content')
    <!-- Footer Start -->

    <footer class="bg-secondary text-dark">

        <div class="container mt-5 pt-5">
            <div class="row pt-5">
                <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <a href="" class="text-decoration-none">
                        <h1 class="mb-4 display-5 font-weight-semi-bold">Nahar
                            Fashion</h1>
                    </a>
                    <p>We produce high quality textile products. Our
                        main products are Chair Cover, Sofa Cover, Table
                        Cover</p>

                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Quick
                                Links</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark text-decoration-none mb-2" href="index.html"><i
                                        class="fa fa-angle-right mr-2"></i>Home</a>
                                <a class="text-dark text-decoration-none mb-2" href="shop.html"><i
                                        class="fa fa-angle-right mr-2"></i>Our
                                    Shop</a>

                                <a class="text-dark text-decoration-none mb-2" href="cart.html"><i
                                        class="fa fa-angle-right mr-2"></i>Shopping
                                    Cart</a>
                                <a class="text-dark text-decoration-none mb-2" href="checkout.html"><i
                                        class="fa fa-angle-right mr-2"></i>Checkout</a>
                                <a class="text-dark text-decoration-none" href="contact.html"><i
                                        class="fa fa-angle-right mr-2"></i>Contact
                                    Us</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Info
                                Link</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark text-decoration-none mb-2" href><i
                                        class="fa fa-angle-right mr-2"></i>Terms
                                    & Conditions</a>
                                <a class="text-dark text-decoration-none mb-2" href><i
                                        class="fa fa-angle-right mr-2"></i>Privacy
                                    Policy</a>

                                <a class="text-dark text-decoration-none mb-2" href><i
                                        class="fa fa-angle-right mr-2"></i>Return
                                    Policy</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Contact
                                Us</h5>
                            <div class="mb-3 address">
                                <p class="mb-0">Address</p>
                                <span>1 kilometer , Chittagong</span>
                            </div>
                            <div class="mb-3 address">
                                <p class="mb-0">Phone</p>
                                <span>+880 123456789</span>
                            </div>
                            <div class="mb-3 address">
                                <p class="mb-0">Email</p>
                                <span>info@naharfashion.com</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <p class="mb-0 text-dark">&copy; 2026 Nahar
                        Fashion. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 mb-3 text-md-right">
                    <p class="mb-0 text-dark">Develop by <a href="https://mohiuddinasad.netlify.app">Mohiuddin
                            Asad</a></p>

                </div>

            </div>
        </div>
    </footer>
    <!-- Footer End -->
    <x-toast />
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/mail/contact.js') }}"></script>

    <!-- jquery js  -->
    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.countdown.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/syotimer.examples.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>

    <!-- slick js  -->

    <!-- Template Javascript -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/cartpopup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/side_bar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slider.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>

    <script>
        function toggleWishlist(btn, productId) {
            const isWishlisted = btn.classList.contains('wishlisted');
            const url = isWishlisted ? `/wishlist/remove/${productId}` : `/wishlist/add/${productId}`;
            const method = isWishlisted ? 'DELETE' : 'POST';
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                console.error('CSRF token missing!');
                return;
            }

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token.content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'login_required') {
                        window.location.href = '/login';
                        return;
                    }

                    if (data.status === 'added' || data.status === 'already_added') {
                        btn.classList.add('wishlisted');
                        if (btn.querySelector('i')) {
                            btn.querySelector('i').className = 'fas fa-heart';
                        }
                    }

                    if (data.status === 'removed') {
                        const card = document.getElementById(`wishlist-card-${productId}`);
                        if (card) {
                            card.style.transition = 'opacity 0.3s';
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.remove();

                                // Check if any rows left
                                const tbody = document.querySelector('#wishlist_product tbody');
                                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                    document.querySelector('#wishlist_product .container').innerHTML = `
                            <div class="alert alert-info text-center my-5">
                                Your wishlist is empty. <a href="/shop">Continue Shopping</a>
                            </div>`;
                                }
                            }, 300);
                        } else {
                            btn.classList.remove('wishlisted');
                            if (btn.querySelector('i')) {
                                btn.querySelector('i').className = 'far fa-heart';
                            }
                        }
                    }

                    if (data.count !== undefined) {
                        const badge = document.getElementById('wishlistCount');
                        if (badge) badge.textContent = data.count;
                    }
                })
                .catch(err => console.error('Wishlist error:', err));
        }
    </script>

    <!-- <script src="./assets/js/bootstrap.bundle.min.js"></script> -->
    @stack('frontend_js')
</body>

</html>
