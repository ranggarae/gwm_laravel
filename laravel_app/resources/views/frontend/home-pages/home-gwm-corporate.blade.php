<!-- Corporate Modern Variant -->

<style>
/* Custom Styles for GWM Corporate Modern Variant */
.gwm-corporate-style {
    --color-navy: #1C2A4A;
    --color-blue: #0056B3;
    --color-gold: #c5a866;
    --color-gray-50: #f8fafc;
    --color-gray-100: #f1f5f9;
    --color-gray-200: #e2e8f0;
    --color-gray-600: #475569;
    --color-gray-700: #334155;
    --color-gray-900: #0f172a;
}



/* Hero Area CSS (Static, non-slider, tall overlay layout with fade to white) */
.gwm-hero-area {
    position: relative;
    width: 100%;
    overflow: hidden;
    background-color: #1C2A4A;
}
.gwm-hero-img-wrap {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}
.gwm-hero-img-wrap img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block;
}
.gwm-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(28, 42, 74, 0.4) 0%, rgba(28, 42, 74, 0.7) 65%, rgba(255, 255, 255, 1) 100%);
    z-index: 2;
}

/* 1. Key Features Card Style (Solid White) */
.gwm-key-features-section {
    position: relative;
    margin-top: -60px; /* Lowered down, but still overlapping the hero transition zone */
    z-index: 100;
}
.gwm-glass-card {
    background: #ffffff !important; /* Solid White */
    border: 1px solid #e2e8f0 !important; /* Border-gray-200 */
    border-radius: var(--radius-lg);
    box-shadow: 0 8px 30px 0 rgba(28, 42, 74, 0.05);
    transition: all 0.3s ease;
    padding: 35px 30px;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.gwm-glass-card:hover {
    background: #ffffff !important;
    transform: translateY(-5px);
    box-shadow: 0 15px 40px 0 rgba(28, 42, 74, 0.08);
    border-color: #cbd5e1 !important;
}

/* 2. Portfolio Styles */
.gwm-portfolio-card {
    position: relative;
    border-radius: var(--radius-lg);
    background: #fff;
    transition: all 0.3s ease;
}
.gwm-portfolio-card .thumb {
    height: 340px;
    overflow: hidden;
    border-radius: var(--radius-lg);
}
.gwm-portfolio-card .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}
.gwm-portfolio-card:hover .thumb img {
    transform: scale(1.05);
}
.gwm-portfolio-card .content-box {
    margin-top: -50px;
    position: relative;
    background: #ffffff;
    border-radius: var(--radius-lg);
    padding: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    z-index: 5;
    margin-left: 20px;
    margin-right: 20px;
    border: 1px solid rgba(0,0,0,0.03);
}

/* Image Fix for Blog */
.gwm-img-zoom-container img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
</style>

<!-- Hero Section (Dynamic Slider, Aspect Ratio Preserved with explicit height padding) -->
<header class="gwm-hero-area position-relative">
    <div id="gwmCorporateSlider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5000">
        <div class="carousel-inner">
            @foreach($all_header_slider as $key => $data)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="min-height: 600px;">
                <!-- Full Image Background -->
                <div class="gwm-hero-img-wrap position-absolute w-100 h-100" style="top: 0; left: 0;">
                    {!! render_image_markup_by_attachment_id($data->image, 'w-100 h-100') !!}
                    <div class="gwm-hero-overlay"></div>
                </div>
                
                <!-- Text Content Overlaid -->
                <div class="position-relative w-100 h-100 d-flex align-items-center" style="z-index: 10; min-height: 600px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-10">
                                <!-- Adjusted padding since navbar is no longer fixed on top of this element -->
                                <div class="gwm-hero-content text-white" style="padding-top: 80px; padding-bottom: 120px;">
                                    <h1 class="display-4 font-weight-bold mb-4 gwm-animate-slide-up" style="font-family: var(--font-heading); text-shadow: 0 2px 10px rgba(0,0,0,0.3); font-size: 3.2rem; color: #ffffff !important;">
                                        {{$data->title}}
                                    </h1>
                                    <p class="lead mb-5 gwm-animate-slide-up gwm-delay-100" style="text-shadow: 0 1px 5px rgba(0,0,0,0.2); font-size: 1.15rem; line-height: 1.6; max-width: 650px; color: rgba(255, 255, 255, 0.9) !important;">
                                        {{$data->description}}
                                    </p>
                                    <div class="gwm-hero-btns gwm-animate-slide-up gwm-delay-200">
                                        @if(!empty($data->btn_01_status))
                                            <a href="{{$data->btn_01_url}}" class="gwm-btn rounded-pill text-white px-5 py-3" style="background-color: #0056B3 !important; font-weight: 600; border: none !important; font-size: 1rem; box-shadow: var(--shadow-lg);">
                                                {{$data->btn_01_text}}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Controls -->
        @if(count($all_header_slider) > 1)
        <a class="carousel-control-prev" href="#gwmCorporateSlider" role="button" data-slide="prev" style="z-index: 15; width: 5%;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#gwmCorporateSlider" role="button" data-slide="next" style="z-index: 15; width: 5%;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        @endif
    </div>
</header>

<!-- Key Features Section (Solid White Cards) -->
@if(!empty(get_static_option('home_page_key_feature_section_status')))
<section class="gwm-key-features-section">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($all_key_features as $key => $data)
            <div class="col-lg-4 col-md-6 mb-4" data-gwm-anim="scale-spring" data-gwm-delay="{{ ($key + 1) * 150 }}">
                <div class="gwm-glass-card">
                    <div class="icon-wrap mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(0, 86, 179, 0.08); border-radius: 50%;">
                        <i class="{{$data->icon}}" style="font-size: 1.8rem; color: #0056B3;"></i>
                    </div>
                    <h4 class="font-weight-bold mb-3" style="color: #1C2A4A; font-family: var(--font-heading); font-size: 1.25rem;">{{$data->title}}</h4>
                    <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.6;">{{$data->description}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- About Us Section (2 Columns) -->
@if(!empty(get_static_option('home_page_about_us_section_status')))
<section class="gwm-section bg-white py-5" style="margin-top: 50px;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-gwm-anim="clip-left">
                <h2 class="font-weight-bold mb-4" style="color: #1C2A4A; font-family: var(--font-heading);">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_title')}}</h2>
                <p class="mb-4 text-muted" style="line-height: 1.8; font-size: 0.95rem;">
                    {{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_description')}}
                </p>
                @if(get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_status'))
                <a href="{{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_url')}}" class="gwm-btn rounded-pill px-4" style="background-color: #1C2A4A; color: white;">
                    {{get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_button_title')}}
                </a>
                @endif
            </div>
            <div class="col-lg-6 text-center" data-gwm-anim="clip-right" data-gwm-delay="200">
                <div class="about-img-wrap pl-lg-4">
                    {!! render_image_markup_by_attachment_id(get_static_option('home_page_01_'.$user_select_lang_slug.'_about_us_background_image'), 'img-fluid rounded shadow-sm', 'full') !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Services Section (Sektor Strategic Kami) -->
@if(!empty(get_static_option('home_page_service_section_status')))
<section class="gwm-section py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-gwm-anim="blur-in">
                <h2 class="gwm-section-heading font-weight-bold" style="color: #1C2A4A; font-family: var(--font-heading);">Sektor Strategic Kami</h2>
                <p class="gwm-text-gray mt-2">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_service_area_description')}}</p>
            </div>
        </div>
        <div class="row">
            @foreach($all_service as $key => $data)
            <div class="col-lg-4 col-md-6 mb-4" data-gwm-anim="rise-rotate" data-gwm-delay="{{ ($key + 1) * 100 }}">
                <div class="p-5 rounded shadow-sm border-0 h-100" style="background-color: #f1f5f9; transition: all 0.3s ease; border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrap mr-4 d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 60px; height: 60px; flex-shrink: 0; min-width: 60px;">
                            <i class="{{$data->icon}}" style="font-size: 1.5rem; color: #0056B3;"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1" style="color: #1C2A4A;">
                                <a href="{{route('frontend.services.single', $data->slug)}}" style="color: #1C2A4A;">{{$data->title}}</a>
                            </h5>
                            <p class="mb-0 text-muted small" style="line-height: 1.4;">{{$data->excerpt}}</p>
                        </div>
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
<section class="gwm-section bg-white py-5">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-gwm-anim="blur-in">
                <h2 class="gwm-section-heading font-weight-bold" style="color: #1C2A4A; font-family: var(--font-heading);">Portfolio</h2>
                <p class="gwm-text-gray mt-2">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_recent_work_description')}}</p>
            </div>
        </div>
        <div class="row">
            @foreach($all_work->take(6) as $key => $data)
            <div class="col-lg-6 col-md-6 mb-5" data-gwm-anim="blur-in" data-gwm-delay="{{ ($key + 1) * 150 }}">
                <div class="gwm-portfolio-card">
                    <div class="thumb">
                        {!! render_image_markup_by_attachment_id($data->image, 'w-100 h-100 object-fit-cover') !!}
                    </div>
                    <div class="content-box">
                        <h4 class="font-weight-bold mb-2">
                            <a href="{{route('frontend.work.single', $data->slug)}}" style="color: #1C2A4A;">{{$data->title}}</a>
                        </h4>
                        <p class="text-muted small mb-0">{{$data->excerpt ?? Str::limit(strip_tags($data->description), 80)}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-gwm-anim="fade-scale">
            <a href="{{ route('frontend.work') }}" class="gwm-btn rounded-pill px-4 text-white" style="background-color: #0056B3;">{{ __('View All Projects') }}</a>
        </div>
    </div>
</section>
@endif

<!-- Counter Section -->
@if(!empty(get_static_option('home_page_counterup_section_status')))
<section class="gwm-section position-relative gwm-gradient-overlay py-5" {!! render_background_image_markup_by_attachment_id(get_static_option('home_01_counterup_bg_image')) !!} style="background-attachment: fixed; background-size: cover; background-position: center;">
    <div class="position-absolute w-100 h-100 top-0 left-0" style="background-color: rgba(28, 42, 74, 0.85); z-index: 1;"></div>
    <div class="container position-relative py-3" style="z-index: 2;">
        <div class="row">
            @foreach($all_counterup as $data)
            <div class="col-lg-3 col-md-6 text-center text-white mb-4 mb-lg-0" data-gwm-anim="counter-roll" data-gwm-delay="{{ $loop->index * 150 }}">
                <i class="{{$data->icon}} mb-3" style="font-size: 2.5rem; color: #c5a866;"></i>
                <h2 class="display-4 font-weight-bold mb-0"><span class="gwm-counter-number">{{$data->number}}</span>{{$data->extra_text}}</h2>
                <h6 class="text-uppercase tracking-wider mt-2" style="letter-spacing: 2px; font-size: 0.85rem;">{{$data->title}}</h6>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Price Plan Section -->
@if(!empty(get_static_option('home_page_price_plan_section_status')))
<section class="price-plan-area py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center">
                <h2 class="title font-weight-bold" style="color: #1C2A4A; font-family: var(--font-heading);">Harga Kami</h2>
                <p class="text-muted">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_price_plan_section_description')}}</p>
            </div>
        </div>
        <div class="row align-items-center">
            @foreach($all_price_plan as $key => $data)
                <div class="col-lg-4 mb-4" data-gwm-anim="drift-up" data-gwm-delay="{{ ($key + 1) * 150 }}">
                    <div class="card h-100 border-0 p-4 text-center shadow-sm" 
                         style="border-radius: var(--radius-lg); border: 1px solid #e2e8f0 !important;">
                        
                        <div class="price-header mb-4">
                            <div class="icon mb-3" style="font-size: 2.2rem; color: #0056B3;">
                                <i class="{{$data->icon}}"></i>
                            </div>
                            <h4 class="title font-weight-bold" style="color: #1C2A4A;">{{$data->title}}</h4>
                        </div>

                        <div class="price-body mb-4">
                            <ul class="list-unstyled">
                                @php
                                    $features = explode(';',$data->features);
                                @endphp
                                @foreach($features as $item)
                                    <li class="py-2 border-bottom text-muted" style="font-size: 0.9rem;">{{$item}}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="price-footer mt-auto">
                            @if(!empty($data->url_status))
                                <a class="gwm-btn rounded-pill w-100 text-white" style="background-color: #0056B3;" href="{{route('frontend.plan.order',$data->id)}}">{{$data->btn_text}}</a>
                            @else
                                <a class="gwm-btn rounded-pill w-100 text-white" style="background-color: #0056B3;" href="{{$data->btn_url}}">{{$data->btn_text}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Team Members Section -->
@if(!empty(get_static_option('home_page_team_member_section_status')))
<section class="meet-the-team-area py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center">
                <h2 class="title font-weight-bold" style="color: #1C2A4A; font-family: var(--font-heading);">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_team_member_section_title')}}</h2>
                <p class="text-muted">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_team_member_section_description')}}</p>
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

<!-- Testimonial Section -->
@if(!empty(get_static_option('home_page_testimonial_section_status')))
<section class="testimonial-area testimonial-bg py-5" {!! render_background_image_markup_by_attachment_id(get_static_option('home_01_testimonial_bg')) !!} style="background-size: cover; background-position: center;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="testimonial-carousel">
                    @foreach($all_testimonial as $data)
                    <div class="single-testimonial-item white">
                        <div class="icon mb-3">
                            <i class="flaticon-quote" style="font-size: 3rem; color: #c5a866;"></i>
                        </div>
                        <p class="lead mb-4 text-white">{{$data->description}} </p>
                        <div class="author-meta">
                            <h5 class="name font-weight-bold text-white mb-1">{{$data->name}}</h5>
                            <span class="designation text-silver small">{{$data->designation}}</span>
                        </div>
                        <div class="thumb mt-4">
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

<!-- Latest News Section (Berita Terbaru) -->
@if(!empty(get_static_option('home_page_latest_news_section_status')))
<section class="latest-news py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center">
                <h2 class="title font-weight-bold" style="color: #1C2A4A; font-family: var(--font-heading);">Berita Terbaru</h2>
                <p class="text-muted">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_latest_news_description')}}</p>
            </div>
        </div>
        <div class="row">
            @foreach($all_blog->take(2) as $key => $data)
                <div class="col-lg-6 col-md-6 mb-4" data-gwm-anim="drift-up" data-gwm-delay="{{ ($key + 1) * 200 }}">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: var(--radius-lg);">
                        <div class="gwm-img-zoom-container" style="height: 260px; overflow: hidden;">
                            {!! render_image_markup_by_attachment_id($data->image, 'w-100 h-100 object-fit-cover') !!}
                        </div>
                        <div class="card-body p-4" style="background-color: #f8fafc;">
                            <div class="d-flex text-muted small mb-2">
                                <span class="mr-3"><i class="far fa-calendar-alt mr-2" style="color: #0056B3;"></i>{{date_format($data->created_at,'d M y')}}</span>
                                <span><i class="far fa-user mr-2" style="color: #0056B3;"></i>{{render_blog_author($data->author)}}</span>
                            </div>
                            <h4 class="card-title font-weight-bold mb-3">
                                <a href="{{route('frontend.blog.single',$data->slug)}}" style="color: #1C2A4A;">{{$data->title}}</a>
                            </h4>
                            <p class="card-text text-muted small mb-0">{{$data->excerpt}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Brand Logo Section -->
@if(!empty(get_static_option('home_page_brand_logo_section_status')))
<div class="brand-logo-area py-5" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brand-carousel">
                    @foreach($all_brand_logo as $data)
                        <div class="single-carousel text-center px-3" style="opacity: 0.6; transition: opacity 0.3s ease;">
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
<style>
    .brand-carousel .single-carousel:hover { opacity: 1 !important; }
</style>
@endif

<!-- Newsletter Section -->
@if(!empty(get_static_option('home_page_newsletter_section_status')))
<section class="gwm-newsletter-section py-5" style="background-color: #f1f5f9; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-gwm-anim="slide-mask">
                <h3 class="font-weight-bold mb-2" style="color: #1C2A4A;">Signup From Newsletter</h3>
                <p class="mb-0 text-muted" style="font-size: 0.95rem;">Subscribe to our newsletter to receive the latest updates, news, and insights.</p>
            </div>
            <div class="col-lg-6" data-gwm-anim="clip-right" data-gwm-delay="200">
                <form action="{{route('frontend.subscribe.newsletter')}}" method="POST" class="gwm-newsletter-inline-form position-relative">
                    @csrf
                    <div class="d-flex">
                        <input type="email" name="email" class="form-control rounded-pill px-4" placeholder="Enter your email address" required style="height: 50px; background-color: #fff; color: #333; border: 1px solid #cbd5e1; padding-right: 120px; font-size: 0.95rem;">
                        <button type="submit" class="gwm-btn position-absolute rounded-pill text-white" style="right: 5px; top: 5px; height: 40px; padding: 0 25px; font-size: 0.9rem; background-color: #0056B3;">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endif