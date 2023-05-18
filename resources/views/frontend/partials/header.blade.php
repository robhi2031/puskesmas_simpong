<!-- Start Header Area -->
<header class="rbt-header rbt-header-4">
    <div class="rbt-sticky-placeholder"></div>
    <!-- Start Header Top -->
    <div class="rbt-header-top rbt-header-top-1 variation-height-50 header-space-betwween bg-color-primary py-2 rbt-border-bottom d-none d-xl-block">
        <div class="container-fluid">
            <div class="rbt-header-sec align-items-center py-2">
                <div class="rbt-header-sec-col rbt-header-left">
                    <div class="rbt-header-content">
                        <div class="header-info w-100" id="headerInfo"></div>
                        <!-- <div class="rbt-separator"></div>
                        <div class="header-info">
                            <ul class="social-share-transparent">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-skype"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <div class="rbt-header-sec-col rbt-header-right">
                    <div class="rbt-header-content">
                        <div class="header-info w-100" id="headerInfo2">
                            <!-- <ul class="rbt-secondary-menu">
                                <li><a href="my-account.html">My Account</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="contact.html">Contact Us</a></li>
                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                <li><a href="#">Terms & Condition</a></li>
                            </ul> -->
                        </div>
                        <!-- <div class="rbt-separator"></div>
                        <div class="header-info">
                            <div class="header-right-btn d-flex">
                                <a class="rbt-btn rbt-switch-btn btn-gradient btn-xs" href="#">
                                    <span data-text="Join Now">Join Now</span>
                                </a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top -->

    <div class="rbt-header-wrapper header-space-betwween bg-color-white header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-start align-items-center">
                <div class="header-left" id="headerLogo"></div>
                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            @php
                                $menus = publicMenus();
                            @endphp
                            @foreach ($menus["menus"] as $menu)
                            {{-- @php dd($menu) @endphp --}}
                            @if (isset($menu['children']) AND $menu['has_child'] == 'Y' )
                                <li class="has-dropdown has-menu-child-item {{ $activeMenu == $menu['menu'] ? 'active' : '' }}">
                                    <a href="javascript:void(0);"><b class="{{ $menu['icon'] }} me-2"></b>{{ $menu['menu'] }}
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        @foreach ($menu['children']["submenu"] as $child)
                                            <li><a href="{{ url($child['route_name']) }}" class="{{ $activeSubMenu == $child['sub_menu'] ? 'active' : '' }}">{{ $child['sub_menu'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="position-static {{ $activeMenu == $menu['menu'] ? 'active' : '' }}">
                                    <a href="{{ url($menu['route_name']) }}"><b class="{{ $menu['icon'] }} me-2"></b>{{ $menu['menu'] }}</a>
                                </li>
                            @endif
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <!-- Navbar Icons -->
                    <ul class="quick-access">
                        <li class="access-icon">
                            <a class="rbt-btn btn-info btn-xs text-light" href="{{ url('auth') }}">
                                <i class="feather-log-in me-1"></i> Login
                            </a>
                        </li>
                        <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn" href="javascript:void();" title="Cari ...">
                                <i class="feather-search"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar d-block d-xl-none">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                </div>
            </div>
        </div>
        <!-- Start Search Dropdown  -->
        <div class="rbt-search-dropdown">
            <div class="wrapper" id="contentSearch">
                <div class="row g-3 mt-3 mt-md-0 mb-5 align-items-center row-formSearch">
                    <div class="col-lg-10">
                        <div class="rbt-search-style-2" id="searchPosts">
                            <input type="text" placeholder="Apa yang ingin anda cari?" class="m-0" name="top-search" id="top-search" />
                            <button type="button" class="reset-btn" id="btn-resetSearch" style="display: none;"><i class="feather-x"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button class="rbt-btn btn-border btn-sm icon-hover w-100 d-block text-center" type="button" id="btn-search">
                            <span class="btn-text">Cari</span>
                            <span class="btn-icon"><i class="feather-search"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Dropdown  -->
    </div>
</header>
<!-- start Mobile Menu Section -->
<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top pb-0">
            <div class="content align-items-center">
                <div class="fw-medium">MENU</div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
        </div>
        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                @php
                    $menus = publicMenus();
                @endphp
                @foreach ($menus["menus"] as $menu)
                {{-- @php dd($menu) @endphp --}}
                @if (isset($menu['children']) AND $menu['has_child'] == 'Y' )
                    <li class="has-dropdown has-menu-child-item">
                        <a href="javascript:void(0);" class="{{ $activeMenu == $menu['menu'] ? 'open' : '' }}">{{ $menu['menu'] }}
                            <i class="feather-chevron-down"></i>
                        </a>
                        <ul class="submenu{{ $activeMenu == $menu['menu'] ? 'active' : '' }}">
                            @foreach ($menu['children']["submenu"] as $child)
                                <li><a href="{{ url($child['route_name']) }}" class="{{ $activeSubMenu == $child['sub_menu'] ? 'active' : '' }}">{{ $child['sub_menu'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="position-static">
                        <a href="{{ url($menu['route_name']) }}" class="{{ $activeMenu == $menu['menu'] ? 'active' : '' }}">{{ $menu['menu'] }}</a>
                    </li>
                @endif
                @endforeach
            </ul>
        </nav>
        <div class="mobile-menu-bottom">
            <hr class="divider-1" />
            <div class="content">
                <div class="logo" id="mobileLogo"></div>
            </div>
            <p class="description" id="mobileDesc"></p>
            <ul class="navbar-top-left rbt-information-list justify-content-start" id="mobileContact"></ul>
            <div class="social-share-wrapper mt-5" id="mobileSocialMedia"></div>
        </div>
    </div>
</div>
<!-- end Mobile Menu Section -->
<a class="close_side_menu" href="javascript:void(0);"></a>