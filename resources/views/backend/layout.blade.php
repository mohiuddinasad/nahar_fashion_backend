<!doctype html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>@yield('backend_title')</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Gradient Able is trending dashboard template made using Bootstrap 5 design framework. Gradient Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="codedthemes" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('backend/assets/images/favicon.svg') }}" type="image/x-icon" />

    <!-- map-vector css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/plugins/jsvectormap.min.css') }}" />
    <!-- [Google Font : Poppins] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/material.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style-preset.css') }}" />
    @stack('backend_css')

</head>
<!-- [Head] end -->
<!-- [Body] Start -->
<x-toast />

<body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <img src="{{ asset('backend/assets/images/logo-dark.svg') }}" alt="logo image" class="logo-lg" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">

                    <li class="pc-item">
                        <a href="{{ route('dashboard') }}" class="pc-link"><span class="pc-micon"> <i
                                    class="ph ph-gauge"></i></span><span class="pc-mtext">Dashboard</span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"> <iconify-icon
                                    icon="eos-icons:role-binding" width="24" height="24"></iconify-icon>
                            </span><span class="pc-mtext">Role & Permission</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('dashboard.users.user-list') }}">User
                                    List</a></li>


                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('dashboard.role-permission.role-list') }}">Role List</a></li>

                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><iconify-icon
                                    icon="icon-park-outline:ad-product" width="24" height="24"></iconify-icon>
                            </span><span class="pc-mtext">Product</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('dashboard.categories.category-list') }}">Cetagory</a></li>


                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('dashboard.products.product-list') }}">Product List</a></li>

                        </ul>

                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><iconify-icon
                                    icon="ph:flag-banner-fold-duotone" width="24" height="24"></iconify-icon>
                            </span><span class="pc-mtext">Banners</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('dashboard.banners.top.banner-list') }}">Top Banner</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('dashboard.banners.bottom.banner-list') }}">Bottom Banner</a></li>




                        </ul>
                    </li>

                    <li class="pc-item">
                        <a href="{{ route('dashboard.orders.order-list') }}" class="pc-link"><span class="pc-micon"><iconify-icon icon="lets-icons:order" width="24" height="24"></iconify-icon></span><span class="pc-mtext">Orders</span></a>
                    </li>



                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    <header class="pc-header" style="background: #D19C97">
        <div class="m-header">
            <a href="{{ route('frontend.home') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <h3>Nahar Fashion</h3>
            </a>
        </div>
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto d-flex align-items-center">
                <div class="message">
                    <a href="{{ route('dashboard.contact-list') }}"
                        class="d-flex align-items-center text-decoration-none justify-content-center text-dark">
                        <iconify-icon icon="lets-icons:message-fill" width="28" height="28"></iconify-icon>
                    </a>
                </div>
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <img src="{{ asset(Auth::user()->user_image) }}" alt="user-image" class="user-avtar" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 225px)">
                                    <ul class="list-group list-group-flush w-100">

                                        <li class="list-group-item">


                                            <a href="{{ route('dashboard.profile') }}" class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph ph-user-circle"></i>
                                                    <span>View profile</span>
                                                </span>
                                            </a>

                                        </li>
                                        <li class="list-group-item">
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ph ph-power"></i>
                                                        <span>Logout</span>
                                                    </span>
                                                </button>
                                            </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        @yield('backend_content')
    </div>

    <x-toast />
    @stack('backend_js')
    <!-- [Page Specific JS] start -->

    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
    <script src="{{ asset('backend/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/world.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/world-merc.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/dashboard-sales.js') }}"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('backend/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('backend/assets/js/script.js') }}"></script>
    <script src="{{ asset('backend/assets/js/theme.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugins/feather.min.js') }}"></script>
    {{-- jQuery (Select2 এর জন্য দরকার) --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        layout_change('light');
    </script>

    <script>
        layout_sidebar_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    <script>
        header_change('header-1');
    </script>


</body>
<!-- [Body] end -->

</html>
