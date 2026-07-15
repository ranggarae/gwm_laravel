<!DOCTYPE html>
<html lang="{{get_user_lang()}}"  dir="{{get_user_lang_direction()}}">
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
    <!-- load fonts dynamically -->
    {!! load_google_fonts() !!}
    <!-- all stylesheets -->
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/common/fonts/xg-flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/magnific-popup.css')}}">
    <link rel="stylesheet"  href="{{asset('assets/frontend/css/style.css')}}">
    @if(get_static_option('home_page_variant') == '10')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/jobs-home.css')}}">
    @endif
    @if(get_static_option('home_page_variant') == '05')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/knowledgebase-home.css')}}">
    @endif
    @if(get_static_option('home_page_variant') == '06')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/service-home.css')}}">
    @endif
    @if(get_static_option('home_page_variant') == '09')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/charity-home.css')}}">
    @endif
    @if(get_static_option('home_page_variant') == '07')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/event-home.css')}}">
    @endif
    @if(get_static_option('home_page_variant') == '08')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/product-home.css')}}">
    @endif
    <link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/dynamic-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/jquery.ihavecookies.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/toastr.css')}}">

        <style>
        :root {
            --main-color-one: {{get_static_option('site_color')}};
            --secondary-color: {{get_static_option('site_main_color_two')}};
            --service-color: {{get_static_option('service_site_color')}};
            --knowledge-color: {{get_static_option('knowledgebase_site_color')}};
            --event-color: {{get_static_option('event_site_color')}};
            --charity-color: {{get_static_option('charity_site_color')}};
            --heading-color: {{get_static_option('site_heading_color')}};
            --paragraph-color: {{get_static_option('site_paragraph_color')}};
            @php $heading_font_family = !empty(get_static_option('heading_font')) ? get_static_option('heading_font_family') :  get_static_option('body_font_family') @endphp
            --heading-font: "{{$heading_font_family}}",sans-serif;
            --body-font:"{{get_static_option('body_font_family')}}",sans-serif;
        }
    </style>

    @yield('style')
    @if(!empty(get_static_option('site_rtl_enabled')) || get_user_lang_direction() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/frontend/css/rtl.css')}}">
    @endif
    @yield('og-meta')
    @if(request()->is(get_static_option('about_page_slug')) || request()->is(get_static_option('service_page_slug')) || request()->is(get_static_option('product_page_slug').'-cart') || request()->is(get_static_option('product_page_slug')) || request()->is(get_static_option('work_page_slug')) || request()->is(get_static_option('team_page_slug')) || request()->is(get_static_option('faq_page_slug')) || request()->is(get_static_option('blog_page_slug')) || request()->is(get_static_option('contact_page_slug')) || request()->is('p/*') || request()->is(get_static_option('blog_page_slug').'/*') || request()->is(get_static_option('service_page_slug').'/*') || request()->is(get_static_option('career_with_us_page_slug').'/*') || request()->is(get_static_option('events_page_slug').'/*') || request()->is(get_static_option('knowledgebase_page_slug').'/*')  || request()->is(get_static_option('product_page_slug').'/*')  || request()->is(get_static_option('donation_page_slug').'/*'))
        <title>@yield('site-title') - {{get_static_option('site_'.$user_select_lang_slug.'_title')}} </title>
    @else
        <title>{{get_static_option('site_'.$user_select_lang_slug.'_title')}} - {{get_static_option('site_'.$user_select_lang_slug.'_tag_line')}}</title>
    @endif
    {!! get_static_option('site_header_script') !!}
</head>
<body class="dizzcox_version_{{getenv('XGENIOUS_DIZCOXX_VERSION')}} {{get_static_option('item_license_status')}} apps_key_{{getenv('XGENIOUS_API_KEY')}} ">
@include('frontend.partials.preloader')
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
                    <a href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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


