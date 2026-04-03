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
    @yield('meta')

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
                <img style="width:150px;" src="{{ Storage::url($globalSetting->site_logo) }}" alt="">
                </a>
            </div>
            <div class="col-lg-6 text-left">
                <form method="GET" action="{{ request()->url() }}"
                    class="d-flex align-items-center justify-content-between">
                    @if (request('price'))
                        <input type="hidden" name="price" value="{{ request('price') }}">
                    @endif

                    <div class="input-group position-relative">
                        <input type="text" class="form-control" name="search" id="liveSearchInput"
                            placeholder="Search by name" value="{{ request('search') }}" autocomplete="off">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div id="liveSearchResults" class="list-group shadow"
                            style="display:none; position:absolute; top:100%; left:0; right:0; z-index:9999; max-height:400px; overflow-y:auto;">
                        </div>
                    </div>


                </form>
            </div>
            <div class="col-lg-3 col-6 wishlist-cart text-right">
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

                    <!---------------------------- Sidebar ---------------------------->
                    <div class="sidebar" id="sidebar">
                        <!-- Sidebar Header -->
                        <div class="sidebar-header">
                            <img style="width: 140px;" src="{{ asset('frontend/assets/img/logo.png') }}"
                                alt="">
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
                            <a href="{{ route('frontend.home') }}" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                <span>Home</span>
                            </a>
                            <a href="{{ route('frontend.shop') }}" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Shop</span>
                            </a>
                            <a href="{{ route('frontend.contact') }}" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Contact</span>
                            </a>
                            <a href="{{ route('frontend.track-order') }}" class="menu-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 .001M13 16H9m4 0h3m3 0h.5a.5.5 0 00.5-.5v-4.293a1 1 0 00-.293-.707l-3.207-3.207A1 1 0 0015.793 7H13v9z" />
                                </svg>
                                <span>Track Order</span>
                            </a>
                            <div class="d-flex flex-wrap mt-4">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="menu-item">Profile</a>
                                @else
                                    <a href="{{ route('login') }}" class="menu-item">Login</a>
                                    <a href="{{ route('register') }}" class="menu-item">Register</a>
                                @endauth
                            </div>
                        </div>

                        <!-- Categories Tab Content -->
                        <div class="tab-content" id="categories">

                            @forelse ($categories as $category)
                                @if ($category->children->count() > 0)
                                    <div class="category-item has-dropdown">
                                        <a href="#dropdown-toggle-btn" class="category-left">
                                            <span class="category-name">{{ $category->name }}</span>
                                        </a>


                                        <button class="dropdown-toggle-btn" type="button">
                                            <svg width="12" height="12" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>


                                        <ul class="category-dropdown">
                                            @foreach ($category->children as $child)
                                                <li><a
                                                        href="{{ route('frontend.category-wise-product', $child->slug) }}">{{ $child->name }}</a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('frontend.category-wise-product', $category->slug) }}"
                                        class="category-item text-decoration-none">
                                        <div class="category-left">
                                            <span class="category-name">{{ $category->name }}</span>
                                        </div>

                                    </a>
                                @endif
                            @empty

                            @endforelse


                        </div>
                    </div>



                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('frontend.home') }}" class="nav-item nav-link">Home</a>
                            <a href="{{ route('frontend.shop') }}" class="nav-item nav-link">Shop</a>
                            <a href="shop.html" class="nav-item nav-link">Wholesale</a>
                            <a href="{{ route('frontend.contact') }}" class="nav-item nav-link">Contact</a>
                            <a href="{{ route('frontend.track-order') }}" class="nav-item nav-link">Track Order</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            @auth
                                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Profile</a>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="nav-item nav-link btn btn-link"
                                        style="display:inline-flex;align-items:center; ">
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

    <!-- ══ FOOTER NAV ══ -->
    <section id="mobileNav" class="d-lg-none">
        <nav class="footer-nav">

            <!-- Home -->
            <a href="{{ route('frontend.home') }}" class="nav-item" data-label="Home">
                <div class="icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" fill="none"
                            stroke="#9CA3AF" />
                        <path d="M9 21V12h6v9" fill="none" stroke="#9CA3AF" />
                    </svg>
                </div>
                <span class="nav-label">Home</span>
            </a>
            {{-- shop  --}}
            <a href="{{ route('frontend.shop') }}" class="nav-item" data-label="Shop">
                <div class="icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" fill="none" stroke="#9CA3AF" />
                        <line x1="3" y1="6" x2="21" y2="6" fill="none"
                            stroke="#9CA3AF" />
                        <path d="M16 10a4 4 0 01-8 0" fill="none" stroke="#9CA3AF" />
                    </svg>
                </div>
                <span class="nav-label">Shop</span>
            </a>

            <!-- Wishlist -->
            <a href="{{ route('frontend.wishlist') }}" class="nav-item" data-label="Wishlist">
                <div class="icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"
                            fill="none" stroke="#9CA3AF" />
                    </svg>
                    <span class="badge">{{ $wishlistCount }}</span>
                </div>
                <span class="nav-label">Wishlist</span>
            </a>

            <!-- Cart -->
            <a href="{{ route('frontend.cart') }}" class="nav-item" data-label="Cart">
                <div class="icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" fill="none" stroke="#9CA3AF" />
                        <line x1="3" y1="6" x2="21" y2="6" fill="none"
                            stroke="#9CA3AF" />
                        <path d="M16 10a4 4 0 01-8 0" fill="none" stroke="#9CA3AF" />
                    </svg>
                    <span class="badge">{{ $qty ? $qty : 0 }}</span>
                </div>
                <span class="nav-label">Cart</span>
            </a>

            <!-- Profile / Login -->
            @auth
                <a href="{{ route('dashboard') }}" class="nav-item" data-label="Profile">
                    <div class="icon-wrap">
                        <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" fill="none" stroke="#9CA3AF" />
                            <circle cx="12" cy="7" r="4" fill="none" stroke="#9CA3AF" />
                        </svg>
                    </div>
                    <span class="nav-label">Profile</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-item d-none" data-label="Login">
                    <div class="icon-wrap">
                        <svg width="22" height="22" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" fill="none" stroke="#9CA3AF" />
                            <polyline points="10 17 15 12 10 7" fill="none" stroke="#9CA3AF" />
                            <line x1="15" y1="12" x2="3" y2="12" fill="none"
                                stroke="#9CA3AF" />
                        </svg>
                    </div>
                    <span class="nav-label">Login</span>
                </a>
            @endauth
        </nav>
    </section>
    <!-- ========== Start cart popup ========== -->

    <!-- Overlay -->

    <section>


        <div id="cartPopupOverlay" onclick="closePopup()">

        </div>

        <div class="cart_body">
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
                            <input type="number" id="popupQty" value="1" min="1"
                                class="cp-qty-input">
                            <button id="popupQtyPlus" onclick="popupQtyChange(1)" class="cp-qty-btn">+</button>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <a id="popupAddToCartLink" href="#" class="cp-add-btn cp-anim-block text-decoration-none"
                        style="--delay: 0.3s; background-color:#D19C97 ; color: #fff;">
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
                                <span>{{ $globalSetting->contact_address }}</span>
                            </div>
                            <div class="mb-3 address">
                                <p class="mb-0">Phone</p>
                                <span>{{ $globalSetting->contact_phone }}</span>
                            </div>
                            <div class="mb-3 address">
                                <p class="mb-0">Email</p>
                                <span>{{ $globalSetting->contact_email }}</span>
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

    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>

    <!-- slick js  -->

    <!-- Template Javascript -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/mobileNav.js') }}"></script>
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
                                        style="width:48px; height:48px; object-fit:cover; border-radius:6px; flex-shrink:0;margin-right: 10px;">
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
    <!-- <script src="./assets/js/bootstrap.bundle.min.js"></script> -->
    @stack('frontend_js')
</body>

</html>
