<!-- Industrial Bold Variant -->
<style>
    /* Industrial Theme Overrides */
    .gwm-industrial .gwm-glass {
        background: #ffffff;
        border-radius: 0;
        border-left: 4px solid var(--color-blue);
        box-shadow: var(--shadow-md);
    }
    .gwm-industrial .card {
        border-radius: 0;
        border: none;
        border-bottom: 3px solid transparent;
        transition: border-bottom-color var(--transition-normal);
    }
    .gwm-industrial .card:hover {
        border-bottom-color: var(--color-blue);
    }
    .gwm-industrial .gwm-img-zoom-container,
    .gwm-industrial .gwm-btn {
        border-radius: 0 !important;
    }
    .gwm-industrial .gwm-section-heading {
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .gwm-industrial .gwm-section-subtitle {
        color: var(--color-navy);
        background-color: var(--color-silver);
        padding: 5px 15px;
        display: inline-block;
        font-size: 0.75rem;
    }
</style>

<div class="gwm-industrial">
    <!-- Hero Slider Section -->
    <header class="gwm-hero-slider position-relative">
        <div id="gwmIndustrialSlider" class="carousel slide" data-ride="carousel" data-interval="6000">
            <div class="carousel-inner">
                @foreach($all_header_slider as $key => $data)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="gwm-hero-slide-item d-flex align-items-center" 
                         {!! render_background_image_markup_by_attachment_id($data->image) !!} 
                         style="min-height: 100vh; background-size: cover; background-position: center; position: relative;">
                        <!-- Hard industrial dark overlay -->
                        <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(15, 23, 42, 0.75); z-index:1;"></div>
                        <div class="container position-relative" style="z-index: 2;">
                            <div class="row">
                                <div class="col-lg-9 col-md-11">
                                    <div class="gwm-hero-content text-white">
                                        <div class="mb-3 gwm-animate-slide-up">
                                            <span class="d-inline-block bg-primary text-white font-weight-bold px-3 py-1 text-uppercase tracking-wider small">
                                                {{ __('Industrial Solutions') }}
                                            </span>
                                        </div>
                                        <h1 class="display-3 font-weight-bold mb-4 gwm-animate-slide-up gwm-delay-100 text-uppercase" style="font-family: var(--font-heading);">
                                            {{$data->title}}
                                        </h1>
                                        <div class="gwm-hero-btns gwm-animate-slide-up gwm-delay-200 mt-5">
                                            @if(!empty($data->btn_01_status))
                                                <a href="{{$data->btn_01_url}}" class="gwm-btn gwm-btn-primary gwm-hover-grow btn-lg mr-3 text-uppercase font-weight-bold">
                                                    {{$data->btn_01_text}} <i class="fas fa-chevron-right ml-2 text-white-50"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('frontend.contact') }}" class="gwm-btn gwm-btn-outline gwm-hover-grow btn-lg text-white border-white text-uppercase font-weight-bold">
                                                {{ __('Get a Quote') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Bold Slider Controls -->
            <a class="carousel-control-prev" href="#gwmIndustrialSlider" role="button" data-slide="prev" style="width: 5%; background: linear-gradient(to right, rgba(0,0,0,0.5), transparent);">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 30px; height: 30px;"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#gwmIndustrialSlider" role="button" data-slide="next" style="width: 5%; background: linear-gradient(to left, rgba(0,0,0,0.5), transparent);">
                <span class="carousel-control-next-icon" aria-hidden="true" style="width: 30px; height: 30px;"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    <!-- Key Features Section -->
    @if(!empty(get_static_option('home_page_key_feature_section_status')))
    <section class="gwm-section gwm-bg-primary pt-0 pb-0">
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                @foreach($all_key_features->take(3) as $key => $data)
                <div class="col-lg-4 col-md-4" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="p-5 h-100 {{ $key % 2 == 0 ? 'gwm-bg-navy' : 'gwm-bg-navy-light' }} text-white text-center text-lg-left d-flex flex-column justify-content-center" style="border-right: 1px solid rgba(255,255,255,0.05); min-height: 250px;">
                        <i class="{{$data->icon}} mb-4" style="font-size: 2.5rem; color: var(--color-blue-light);"></i>
                        <h4 class="title font-weight-bold mb-3 text-uppercase">{{$data->title}}</h4>
                        <p class="gwm-text-silver mb-0">{{$data->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Services Section -->
    @if(!empty(get_static_option('home_page_service_section_status')))
    <section class="gwm-section pt-5 pb-5 gwm-bg-light">
        <div class="container pt-5">
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8" data-aos="fade-right">
                    <span class="gwm-section-subtitle mb-2">{{ __('Core Capabilities') }}</span>
                    <h2 class="gwm-section-heading font-weight-bold">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_service_area_title')}}</h2>
                </div>
                <div class="col-lg-4 text-lg-right mt-3 mt-lg-0" data-aos="fade-left">
                    <a href="{{ route('frontend.service') }}" class="gwm-btn gwm-btn-outline gwm-text-navy border-dark font-weight-bold text-uppercase">{{ __('View All Services') }}</a>
                </div>
            </div>
            <div class="row">
                @foreach($all_service as $key => $data)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="card h-100 shadow-sm gwm-hover-lift bg-white">
                        <div class="card-body p-5">
                            <i class="{{$data->icon}} gwm-text-secondary mb-4" style="font-size: 3rem;"></i>
                            <h4 class="card-title font-weight-bold gwm-text-primary text-uppercase mb-3">
                                <a href="{{route('frontend.services.single', $data->slug)}}" class="gwm-text-primary">{{$data->title}}</a>
                            </h4>
                            <p class="card-text gwm-text-gray mb-4">{{$data->excerpt}}</p>
                            <a href="{{route('frontend.services.single', $data->slug)}}" class="font-weight-bold gwm-text-primary text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                                {{ __('Details') }} <i class="fas fa-arrow-right ml-1 gwm-text-secondary"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Works / Portfolio Section -->
    @if(!empty(get_static_option('home_page_recent_work_section_status')))
    <section class="gwm-section pt-5 pb-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12 text-center" data-aos="fade-up">
                    <span class="gwm-section-subtitle mb-2">{{ __('Industrial Showcase') }}</span>
                    <h2 class="gwm-section-heading font-weight-bold">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_recent_work_title')}}</h2>
                </div>
            </div>
            <div class="row">
                @foreach($all_work->take(6) as $key => $data)
                <div class="col-lg-4 col-md-6 mb-4 px-lg-2 px-3" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="position-relative overflow-hidden gwm-hover-grow gwm-img-zoom-container shadow-sm bg-dark">
                        <div style="opacity: 0.7;">
                            {!! render_image_markup_by_attachment_id($data->image, 'w-100') !!}
                        </div>
                        <div class="position-absolute w-100 p-4 text-white" style="bottom: 0; left:0; z-index: 2;">
                            <h4 class="font-weight-bold text-uppercase mb-2"><a href="{{route('frontend.work.single', $data->slug)}}" class="text-white">{{$data->title}}</a></h4>
                            <div class="gwm-cats text-primary font-weight-bold small text-uppercase">
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

    <!-- Counter Section -->
    @if(!empty(get_static_option('home_page_counterup_section_status')))
    <section class="gwm-section position-relative py-5 gwm-bg-primary">
        <div class="container py-4">
            <div class="row">
                @foreach($all_counterup as $data)
                <div class="col-lg-3 col-md-6 text-center text-white mb-4 mb-lg-0" data-aos="fade-up" style="border-right: 1px solid rgba(255,255,255,0.1);">
                    <h2 class="display-4 font-weight-bold mb-2 text-secondary"><span class="gwm-counter-number">{{$data->number}}</span>{{$data->extra_text}}</h2>
                    <h6 class="text-uppercase tracking-wider text-silver" style="letter-spacing: 2px;">{{$data->title}}</h6>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Remove last border -->
    <style>
        .gwm-industrial .row > div:last-child { border-right: none !important; }
    </style>
    @endif

    <!-- Call to Action Section -->
    @if(!empty(get_static_option('home_page_call_to_action_section_status')))
    <section class="gwm-section gwm-bg-light text-center py-5">
        <div class="container py-5" data-aos="fade-up">
            <h2 class="display-4 font-weight-bold mb-4 gwm-text-primary text-uppercase">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_title')}}</h2>
            <p class="lead gwm-text-gray mb-5 mx-auto" style="max-width: 700px;">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_description')}}</p>
            <a href="{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_url')}}" class="gwm-btn gwm-btn-primary btn-lg text-uppercase font-weight-bold px-5 py-3 shadow">
                {{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_title')}}
            </a>
        </div>
    </section>
    @endif


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
</div>
