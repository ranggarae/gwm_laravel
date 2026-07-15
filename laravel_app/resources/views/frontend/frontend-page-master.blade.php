@extends('frontend.frontend-master-gwm')

@section('content')
<section class="breadcrumb-area breadcrumb-bg gwm-breadcrumb-area position-relative"
@php
    $site_breadcrumb_bg = get_attachment_image_by_id(get_static_option('site_breadcrumb_bg'),"full",false);
@endphp
@if (!empty($site_breadcrumb_bg))
style="background-image: url({{$site_breadcrumb_bg['img_url']}}); background-size: cover; background-position: center; padding: 120px 0;"
@endif
>
    <!-- GWM Overlay -->
    <div class="gwm-breadcrumb-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(26, 39, 68, 0.9) 0%, rgba(43, 125, 233, 0.8) 100%); z-index: 1;"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center text-white">
                    <h1 class="page-title font-weight-bold mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 3rem;">@yield('page-title')</h1>
                    <ul class="page-list d-flex justify-content-center align-items-center list-unstyled p-0 m-0" style="font-family: 'Inter', sans-serif;">
                        <li class="mx-2"><a href="{{url('/')}}" class="text-white text-decoration-none hover-white">{{__('Home')}}</a></li>
                        <li class="mx-2 text-white">/</li>
                        @if(request()->is(get_static_option('blog_page_slug').'/*') || request()->is(get_static_option('blog_page_slug').'-category'.'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('blog_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('blog_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('work_page_slug').'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('work_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('work_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('service_page_slug').'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('service_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('service_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('product_page_slug').'/*') || request()->is(get_static_option('product_page_slug').'-cart') || request()->is(get_static_option('product_page_slug').'-category'.'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('product_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('product_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('career_with_us_page_slug').'/*') || request()->is(get_static_option('career_with_us_page_slug').'-category'.'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('career_with_us_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('career_with_us_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('events_page_slug').'/*') || request()->is(get_static_option('events_page_slug')) || request()->is(get_static_option('events_page_slug').'-category'.'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('events_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('events_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('knowledgebase_page_slug').'/*') || request()->is(get_static_option('knowledgebase_page_slug').'-category'.'/*'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('knowledgebase_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('knowledgebase_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('donation_page_slug').'/*') || request()->is(get_static_option('donation_page_slug')))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('donation_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('donation_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @elseif(request()->is(get_static_option('gig_page_slug').'/*') || request()->is(get_static_option('gig_page_slug').'-search'))
                            <li class="mx-2"><a href="{{url('/').'/'.get_static_option('gig_page_slug')}}" class="text-white text-decoration-none hover-white">{{get_static_option('gig_page_' . $user_select_lang_slug . '_name')}}</a></li>
                            <li class="mx-2 text-white">/</li>
                        @endif
                        <li class="mx-2 text-white opacity-75">@yield('breadcrumb')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="gwm-inner-page-content py-5">
    @yield('content')
</div>
@endsection