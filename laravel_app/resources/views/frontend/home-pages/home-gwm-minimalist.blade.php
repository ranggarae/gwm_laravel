<!-- Minimalist Professional Variant -->
<style>
    /* Minimalist Theme Overrides */
    .gwm-minimalist {
        font-weight: 400;
    }
    .gwm-minimalist .gwm-section {
        padding: var(--space-4xl) 0;
    }
    .gwm-minimalist .card {
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-gray-200);
        box-shadow: none;
        transition: all var(--transition-normal);
        background: transparent;
    }
    .gwm-minimalist .card:hover {
        border-color: var(--color-blue);
        box-shadow: var(--shadow-sm);
        transform: translateY(-2px);
    }
    .gwm-minimalist .gwm-section-heading {
        font-weight: 500;
        letter-spacing: -0.5px;
    }
    .gwm-minimalist .gwm-section-subtitle {
        color: var(--color-gray-500);
        font-weight: 500;
        letter-spacing: 2px;
    }
    .gwm-minimalist .gwm-btn-primary {
        background-color: var(--color-gray-900);
        box-shadow: none;
    }
    .gwm-minimalist .gwm-btn-primary:hover {
        background-color: var(--color-blue);
    }
</style>

<div class="gwm-minimalist bg-white">
    <!-- Hero Slider Section -->
    <header class="gwm-hero-slider position-relative">
        <div id="gwmMinimalistSlider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">
            <div class="carousel-inner">
                @foreach($all_header_slider as $key => $data)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="gwm-hero-slide-item d-flex align-items-center bg-white" style="min-height: 90vh;">
                        <div class="container position-relative" style="z-index: 2;">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-12 mb-5 mb-lg-0 pr-lg-5">
                                    <div class="gwm-hero-content text-dark">
                                        <h1 class="display-4 font-weight-bold mb-4 gwm-animate-slide-up gwm-text-primary" style="font-family: var(--font-heading); letter-spacing: -1px;">
                                            {{$data->title}}
                                        </h1>
                                        <p class="lead mb-5 gwm-animate-slide-up gwm-delay-100 gwm-text-gray font-weight-normal" style="line-height: 1.8;">
                                            {{$data->description}}
                                        </p>
                                        <div class="gwm-hero-btns gwm-animate-slide-up gwm-delay-200">
                                            @if(!empty($data->btn_01_status))
                                                <a href="{{$data->btn_01_url}}" class="gwm-btn gwm-btn-primary btn-lg mr-3 rounded-pill px-4 font-weight-normal">
                                                    {{$data->btn_01_text}}
                                                </a>
                                            @endif
                                            <a href="{{ route('frontend.about') }}" class="gwm-btn gwm-btn-outline gwm-text-primary border-dark btn-lg rounded-pill px-4 font-weight-normal">
                                                {{ __('Explore') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 gwm-animate-fade-in gwm-delay-300">
                                    <div class="rounded-lg overflow-hidden shadow-lg">
                                        {!! render_image_markup_by_attachment_id($data->image, 'w-100') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </header>

    <!-- Navbar Color Override for Minimalist (since hero is white) -->
    <style>
        .gwm-navbar-transparent-start .navbar-nav li a { color: var(--color-gray-700) !important; }
        .gwm-navbar-transparent-start .navbar-brand img { filter: invert(1); } /* Dark logo if original is white */
        .gwm-navbar-solid .navbar-brand img { filter: none; }
    </style>

    <!-- Services Section -->
    @if(!empty(get_static_option('home_page_service_section_status')))
    <section class="gwm-section border-top">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6" data-aos="fade-up">
                    <span class="gwm-section-subtitle mb-3 d-block">{{ __('Services') }}</span>
                    <h2 class="gwm-section-heading gwm-text-primary">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_service_area_title')}}</h2>
                </div>
                <div class="col-lg-6 d-flex align-items-end" data-aos="fade-up" data-aos-delay="100">
                    <p class="gwm-text-gray mb-0 pb-2">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_service_area_description')}}</p>
                </div>
            </div>
            <div class="row">
                @foreach($all_service as $key => $data)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <a href="{{route('frontend.services.single', $data->slug)}}" class="text-decoration-none">
                        <div class="card h-100 p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="{{$data->icon}} gwm-text-secondary mr-3" style="font-size: 2rem;"></i>
                                <h5 class="card-title mb-0 font-weight-bold gwm-text-primary">{{$data->title}}</h5>
                            </div>
                            <p class="card-text gwm-text-gray font-weight-normal">{{$data->excerpt}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Works / Portfolio Section -->
    @if(!empty(get_static_option('home_page_recent_work_section_status')))
    <section class="gwm-section border-top gwm-bg-gray-50">
        <div class="container">
            <div class="row mb-5 text-center justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <span class="gwm-section-subtitle d-block mb-3">{{ __('Selected Works') }}</span>
                    <h2 class="gwm-section-heading gwm-text-primary">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_recent_work_title')}}</h2>
                </div>
            </div>
            <div class="row">
                @foreach($all_work->take(6) as $key => $data)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="card border-0 bg-transparent">
                        <div class="rounded-lg overflow-hidden mb-3 gwm-hover-grow">
                            <a href="{{route('frontend.work.single', $data->slug)}}">
                                {!! render_image_markup_by_attachment_id($data->image, 'w-100') !!}
                            </a>
                        </div>
                        <div class="pt-2">
                            <h5 class="font-weight-bold mb-1"><a href="{{route('frontend.work.single', $data->slug)}}" class="gwm-text-primary">{{$data->title}}</a></h5>
                            <div class="gwm-text-gray small">
                                @php $all_cat_of_post = get_work_category_by_id($data->id); @endphp
                                @if(!empty($all_cat_of_post))
                                    @foreach($all_cat_of_post as $cat_id => $work_cat)
                                        <span class="mr-2">{{$work_cat}}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Key Features Section (Text focus) -->
    @if(!empty(get_static_option('home_page_key_feature_section_status')))
    <section class="gwm-section border-top">
        <div class="container">
            <div class="row">
                @foreach($all_key_features as $key => $data)
                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="pr-lg-4">
                        <h4 class="title font-weight-bold mb-3 gwm-text-primary d-flex align-items-center">
                            <i class="{{$data->icon}} gwm-text-gray-400 mr-3" style="font-size: 1.5rem;"></i>
                            {{$data->title}}
                        </h4>
                        <p class="gwm-text-gray font-weight-normal" style="line-height: 1.7;">{{$data->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Call to Action Section -->
    @if(!empty(get_static_option('home_page_call_to_action_section_status')))
    <section class="gwm-section border-top text-center" style="padding: var(--space-4xl) 0;">
        <div class="container" data-aos="fade-up">
            <h2 class="display-4 font-weight-bold mb-4 gwm-text-primary" style="letter-spacing: -1px;">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_title')}}</h2>
            <p class="lead gwm-text-gray mb-5 mx-auto font-weight-normal" style="max-width: 600px;">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_description')}}</p>
            <a href="{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_url')}}" class="gwm-btn gwm-btn-primary rounded-pill btn-lg px-5">
                {{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_title')}}
            </a>
        </div>
    </section>
    @endif
</div>


<!-- Legacy Theme Additional Sections -->

@if(!empty(get_static_option('home_page_about_us_section_status')))
<div class="header-bottom-area section-bg-1 padding-top-110 padding-bottom-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="right-content-area"
                     {!! render_background_image_markup_by_attachment_id(get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_background_image')) !!}
                >
                    <h4 class="title">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_title')}}</h4>
                    <p> {{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_description')}}</p>
                    <div class="sign">
                        {!! render_image_markup_by_attachment_id(get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_signature_image')) !!}
                    </div>
                    <h4 class="name">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_signature_text')}}</h4>
                    @if(get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_status'))
                    <div class="btn-wrapper desktop-left mt-4">
                        <a href="{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_url')}}" class="boxed-btn btn-rounded">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_title')}}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(!empty(get_static_option('home_page_price_plan_section_status')))
<section class="price-plan-area  padding-top-110 padding-bottom-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title desktop-center margin-bottom-55">
                    <h2 class="title">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_price_plan_section_title')}}</h2>
                    <p>{{get_static_option('home_page_01_'.$user_select_lang_slug.'_price_plan_section_description')}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="price-carousel">
                    @foreach($all_price_plan as $data)
                    <div class="pricing-table-15">
                        <div class="price-header">
                            <div class="icon"><i class="{{$data->icon}}"></i></div>
                            <h3 class="title">{{$data->title}}</h3>
                        </div>

                        <div class="price">
                            <span class="dollar"></span>{{amount_with_currency_symbol($data->price)}}<span class="month">{{$data->type}}</span>
                        </div>
                        <div class="price-body">
                            <ul>
                                @php
                                    $features = explode(';',$data->features);
                                @endphp
                                @foreach($features as $item)
                                <li>{{$item}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="price-footer">
                            @if(!empty($data->url_status))
                            <a class="order-btn" href="{{route('frontend.plan.order',$data->id)}}">{{$data->btn_text}}</a>
                            @else
                            <a class="order-btn" href="{{$data->btn_url}}">{{$data->btn_text}}</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_team_member_section_status')))
<section class="meet-the-team-area section-bg-1 padding-top-110 padding-bottom-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title desktop-center margin-bottom-55">
                    <h2 class="title">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_team_member_section_title')}}</h2>
                    <p>{{get_static_option('home_page_01_'.$user_select_lang_slug.'_team_member_section_description')}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="team-carousel">
                    @foreach($all_team_members as $data)
                    <div class="single-team-member-one">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                            <div class="hover">
                                @php
                                    $social_fields = array(
                                        'icon_one' => 'icon_one_url',
                                        'icon_two' => 'icon_two_url',
                                        'icon_three' => 'icon_three_url',
                                    );
                                @endphp
                                <ul class="social-icon">
                                    @foreach($social_fields as $key => $value)
                                    <li><a href="{{$data->$value}}"><i class="{{$data->$key}}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="content">
                            <h4 class="name">{{$data->name}}</h4>
                            <span class="designation">{{$data->designation}}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_testimonial_section_status')))
<section class="testimonial-area testimonial-bg padding-top-110 padding-bottom-120"
    {!! render_background_image_markup_by_attachment_id(get_static_option('home_01_testimonial_bg')) !!}
>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="testimonial-carousel">
                    @foreach($all_testimonial as $data)
                    <div class="single-testimonial-item white">
                        <div class="icon">
                            <i class="flaticon-quote"></i>
                        </div>
                        <p>{{$data->description}} </p>
                        <div class="author-meta">
                            <h4 class="name">{{$data->name}}</h4>
                            <span class="designation">{{$data->designation}}</span>
                        </div>
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($data->image,'','full') !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_latest_news_section_status')))
<section class="latest-news padding-top-110 padding-bottom-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title desktop-center margin-bottom-55">
                    <h2 class="title">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_latest_news_title')}}</h2>
                    <p>{{get_static_option('home_page_01_'.$user_select_lang_slug.'_latest_news_description')}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="latest-news-carousel">
                    @foreach($all_blog as $data)
                        <div class="single-blog-grid-01">
                            <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{{route('frontend.blog.single',$data->slug)}}">{{$data->title}}</a></h4>
                                <ul class="post-meta">
                                    <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fa fa-calendar"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                    <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fa fa-user"></i> {{render_blog_author($data->author)}}</a></li>
                                    <li>
                                        <div class="cats"><i class="fa fa-calendar"></i>
                                            {!! get_blog_category_by_id($data->id,'link') !!}
                                        </div>
                                    </li>
                                </ul>
                                <p>{{$data->excerpt}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_brand_logo_section_status')))
    <div class="brand-logo-area section-bg-1 padding-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-carousel">
                        @foreach($all_brand_logo as $data)
                            <div class="single-carousel">
                                @if(!empty($data->url)) <a href="{{$data->url}}"> @endif
                                {!! render_image_markup_by_attachment_id($data->image) !!}
                                @if(!empty($data->url))</a> @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(!empty(get_static_option('home_page_newsletter_section_status')))
@include('frontend.partials.newsletter')
@endif