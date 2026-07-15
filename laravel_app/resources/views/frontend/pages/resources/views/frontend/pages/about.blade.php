@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('about_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('about_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('breadcrumb')
    <li> {{get_static_option('about_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('content')
@if(!empty(get_static_option('about_page_about_us_section_status')))
    <div class="who-we-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="left-content-area">
                        <div class="aboutus-content-block margin-bottom-50">
                            <h4 class="title">{{get_static_option('about_page_'.$user_select_lang_slug.'_about_section_title')}}</h4>
                            <div class="about-page-description" style="margin-top: 20px;">{!! get_static_option('about_page_'.$user_select_lang_slug.'_about_section_description') !!}</div>
                        </div>
                        <div class="row">
                            @foreach($all_service as $data)
                            <div class="col-lg-6">
                                <div class="icon-box-three margin-bottom-25">
                                    <div class="icon">
                                        <i class="{{$data->icon}}"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">{{$data->title}}</h4>
                                        <p>{{$data->excerpt}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="img-wrapper">
                        {!! render_image_markup_by_attachment_id(get_static_option('about_page_'.$user_select_lang_slug.'_about_section_right_image')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(!empty(get_static_option('about_page_know_about_section_status')))
    <section class="our-work-area padding-top-110 padding-bottom-120 section-bg-1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title desktop-center margin-bottom-55">
                        <h2 class="title">{{get_static_option('about_page_'.$user_select_lang_slug.'_know_about_section_title')}}</h2>
                        <p>{{get_static_option('about_page_'.$user_select_lang_slug.'_know_about_section_description')}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($all_know_about as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="single-work-item-02">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                        </div>
                        <div class="content">
                            <a href="{{$data->link}}"><h4 class="title">{{$data->title}}</h4></a>
                            <p>{{$data->description}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@if(!empty(get_static_option('about_page_call_to_action_section_status')))
    <section class="cta-area-one cta-bg-one padding-top-95 padding-bottom-100"
             {!! render_background_image_markup_by_attachment_id(get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_background_image')) !!}
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="left-content-area">
                        <h3 class="title">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_title')}}</h3>
                        <p>{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_description')}}</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="right-content-area">
                        <div class="btn-wrapper">
                            <a href="{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_url')}}" class="boxed-btn btn-rounded white">{{get_static_option('home_page_01_'.$user_select_lang_slug.'_cta_area_button_title')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@if(!empty(get_static_option('about_page_team_member_section_status')))
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
@if(!empty(get_static_option('about_page_testimonial_section_status')))
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
@if(!empty(get_static_option('about_page_latest_news_section_status')))
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
                                        <li><a href="#"><i class="fa fa-calendar"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                        <li><a href="#"><i class="fa fa-user"></i> {{render_blog_author($data->author)}}</a></li>
                                        <li><div class="cats"><i class="fa fa-calendar"></i>{!! get_blog_category_by_id($data->id) !!}</div></li>
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
@if(!empty(get_static_option('about_page_brand_logo_section_status')))
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
@endsection
