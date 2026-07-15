<!DOCTYPE html>
<html lang="{{get_user_lang()}}" dir="{{get_user_lang_direction()}}">
<head>
    @if(!empty(get_static_option('site_google_analytics')))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{get_static_option('site_google_analytics')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', "{{get_static_option('site_google_analytics')}}");
    </script>
    @endif
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{get_static_option('site_meta_description')}}">
    <meta name="tags" content="{{get_static_option('site_meta_tags')}}">

    {!! render_favicon_by_id(get_static_option('site_favicon')) !!}
    
    <!-- Title -->
    @if(request()->is(get_static_option('about_page_slug')) || request()->is(get_static_option('service_page_slug')) || request()->is(get_static_option('product_page_slug').'-cart') || request()->is(get_static_option('product_page_slug')) || request()->is(get_static_option('work_page_slug')) || request()->is(get_static_option('team_page_slug')) || request()->is(get_static_option('faq_page_slug')) || request()->is(get_static_option('blog_page_slug')) || request()->is(get_static_option('contact_page_slug')) || request()->is('p/*') || request()->is(get_static_option('blog_page_slug').'/*') || request()->is(get_static_option('service_page_slug').'/*') || request()->is(get_static_option('career_with_us_page_slug').'/*') || request()->is(get_static_option('events_page_slug').'/*') || request()->is(get_static_option('knowledgebase_page_slug').'/*') || request()->is(get_static_option('product_page_slug').'/*') || request()->is(get_static_option('donation_page_slug').'/*'))
        <title>@yield('site-title') - {{get_static_option('site_'.$user_select_lang_slug.'_title')}} </title>
    @else
        <title>{{get_static_option('site_'.$user_select_lang_slug.'_title')}} - {{get_static_option('site_'.$user_select_lang_slug.'_tag_line')}}</title>
    @endif

    <!-- Base Stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/fonts/xg-flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/toastr.css')}}">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- GWM New Design System -->
    <link rel="stylesheet" href="{{asset('assets/css/gwm-design-system.css')}}?v=2.0">
    <link rel="stylesheet" href="{{asset('assets/css/gwm-animations.css')}}?v=2.0">

    <!-- Legacy Style for compatibility -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/dynamic-style.css')}}">

    @yield('style')
    
    @if(!empty(get_static_option('site_rtl_enabled')) || get_user_lang_direction() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/rtl.css')}}">
    @endif
    
    @yield('og-meta')
    
    {!! get_static_option('site_header_script') !!}
</head>
<body class="dizzcox_version_{{getenv('XGENIOUS_DIZCOXX_VERSION')}} {{get_static_option('item_license_status')}} apps_key_{{getenv('XGENIOUS_API_KEY')}} gwm-body">

<!-- Preloader -->
@include('frontend.partials.preloader')

<!-- Admin Topbar -->
@if(auth()->guard('admin')->check())
    <div class="dizzcox_admin_bar">
        <div class="left-content-part">
            <ul class="admin-links">
                <li><a href="{{route('admin.home')}}"><i class="fas fa-tachometer-alt"></i> {{__('Dashboard')}}</a></li>
                <li><a href="{{route('admin.general.site.identity')}}"><i class="fas fa-sliders-h"></i> {{__('General Settings')}}</a></li>
                <li><a href="{{route('admin.menu')}}"><i class="fas fa-bars"></i> {{__('Menu Edit')}}</a></li>
                @yield('edit_link')
            </ul>
        </div>
        <div class="right-content-part">
            <div class="author-details-wrap">
                <h6>{{auth()->guard('admin')->user()->name}}</h6>
                <div class="author-link">
                    <a href="{{route('admin.profile.update')}}">{{__('Edit Profile')}}</a>
                    <a href="{{route('admin.password.change')}}">{{__('Password Change')}}</a>
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Navbar (New GWM Component) -->
@include('frontend.partials.navbar-gwm')

<!-- Page Content -->
@yield('content')

<!-- Footer (New GWM Component) -->
@include('frontend.partials.footer-gwm')

<!-- Scripts -->
<script src="{{asset('assets/frontend/js/lazyloadimage.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery-migrate-3.1.0.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/dynamic-script.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('assets/frontend/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.waypoints.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/wow.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/common/js/countdown.jquery.js')}}"></script>

<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- GWM New Frontend Script -->
<script src="{{asset('assets/js/gwm-main.js')}}?v=2.0"></script>

<!-- Legacy Scripts (Kept for compatibility) -->
<script src="{{asset('assets/frontend/js/main.js')}}"></script>

<!-- Custom JS from Admin -->
@yield('scripts')

</body>
</html>
