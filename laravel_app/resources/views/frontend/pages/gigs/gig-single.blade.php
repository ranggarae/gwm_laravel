@extends('frontend.frontend-page-master')
@section('site-title')
    {{$gig->title}}
@endsection
@section('page-title')
    {{$gig->title}}
@endsection
@section('style')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
@endsection
@section('breadcrumb')
    <li>{!! get_gigs_category_by_id($gig->category_id,'link') !!}</li>
    <li>{{$gig->title}}</li>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$gig->meta_description}}">
    <meta name="tags" content="{{$gig->meta_tags}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.gigs.single',$gig->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$gig->title}}" />
    {!! render_og_meta_image_by_attachment_id($gig->image) !!}
@endsection
@section('edit_link')
    <li><a href="{{route('admin.gigs.edit',$gig->id)}}"><i class="far fa-edit"></i> {{__('Edit Gig')}}</a></li>
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-gig-details">
                        @if(!empty($gig->gallery))
                        <div class="gallery-wrap">
                            @php
                                $gallery_images = !empty( $gig->gallery) ? explode('|', $gig->gallery) : [];
                            @endphp
                            <div class="thumbnail">
                                <div class="thumbnail-gallery-carousel">
                                    @foreach($gallery_images as $gal_image)
                                    <div class="single-thumb">
                                        {!! render_image_markup_by_attachment_id($gal_image,'','large') !!}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="thumbnail-navigator">
                                @foreach($gallery_images as $gal_image)
                                <div class="single-thumbnail-navigator">
                                    {!! render_image_markup_by_attachment_id($gal_image,'','large') !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="thumbnail">
                            {!! render_image_markup_by_attachment_id($gig->image,'','large') !!}
                            <div class="hover">
                                <a href="{{get_attachment_image_url_by_id($gig->image)}}" class="image-popup"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                        @endif
                        <div class="content-area">
                            <div class="description">
                                {!! $gig->description !!}
                            </div>
                        </div>
                        <div class="faq-area-wrapper">
                            <div class="accordion-wrapper">
                                @php
                                    $all_faqs_title = !empty($gig->faqs_title) ? unserialize($gig->faqs_title) : [];
                                    $all_faqs_description = !empty($gig->faqs_description) ? unserialize($gig->faqs_description) : [];
                                    $rand_number = rand(9999,99999999);
                                @endphp
                                <div id="accordion_{{$rand_number}}">
                                    @if(!empty($all_faqs_title))
                                    @foreach($all_faqs_title as $key => $faq_title)
                                        @if(!empty($faq_title))
                                        <div class="card">
                                            <div class="card-header" id="headingOne_{{$key}}">
                                                <h5 class="mb-0">
                                                    <a data-toggle="collapse" data-target="#collapseOne_{{$key}}" role="button"
                                                       aria-expanded="false" aria-controls="collapseOne_{{$key}}">
                                                        {{$faq_title}}
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseOne_{{$key}}" class="collapse"
                                                 aria-labelledby="headingOne_{{$key}}" data-parent="#accordion_{{$rand_number}}">
                                                <div class="card-body">
                                                    {{$all_faqs_description[$key]}}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="price-plan-wrapper">
                            @php
                                $all_plan_title = !empty($gig->plan_title) ? unserialize($gig->plan_title) : [];
                                $all_plan_price = !empty($gig->plan_price) ? unserialize($gig->plan_price) : [];
                                $all_plan_features = !empty($gig->features) ? unserialize($gig->features) : [];
                                $all_plan_revisions = !empty($gig->revisions) ? unserialize($gig->revisions) : [];
                                $all_plan_delivery_time = !empty($gig->delivery_time) ? unserialize($gig->delivery_time) : [];
                                $all_plan_description = !empty($gig->plan_description) ? unserialize($gig->plan_description) : [];
                            @endphp
                            @if(!empty($all_plan_title))

                            <ul class="nav nav-tabs"  role="tablist">
                                @foreach($all_plan_title as $index => $title)
                                    @php
                                    $active =  $index == 0 ? 'active' : '';
                                    $aria_expanded =  $index == 0 ? 'true' : 'false';
                                    @endphp
                                <li class="nav-item">
                                    <a class="nav-link {{$active}}" id="{{Str::slug($title)}}-tab-{{$index + 1}}" data-toggle="tab" href="#{{Str::slug($title)}}-{{$index + 1}}" role="tab" aria-selected="{{$aria_expanded}}">{{$title}}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                            <div class="tab-content">
                                @foreach($all_plan_title as $index => $title)
                                    @php
                                        $active =  $index == 0 ? 'show active' : '';
                                    @endphp
                                    <div class="tab-pane fade {{$active}}" id="{{Str::slug($title)}}-{{$index + 1}}" role="tabpanel" aria-labelledby="{{Str::slug($title)}}-tab-{{$index + 1}}">
                                        <div class="gig-price-plan">
                                            <div class="price-wrap">
                                                {{amount_with_currency_symbol($all_plan_price[$index])}}
                                            </div>
                                            <div class="description">
                                                <p>
                                                {{$all_plan_description[$index]}}
                                                </p>
                                            </div>
                                            <ul class="feature-list">
                                                @php
                                                   $features =  !empty($all_plan_features[$index]) ? explode("\n",$all_plan_features[$index]) : [];
                                                @endphp
                                                @foreach($features as $item)
                                                <li>{{$item}}</li>
                                                @endforeach
                                            </ul>
                                           <div class="revision-wrapper">
                                               <span class="delivery-time"><i class="far fa-clock"></i> {{$all_plan_delivery_time[$index]}} {{__('Days Delivery')}}</span>
                                               <span class="revisions"><i class="fas fa-sync"></i> {{$all_plan_revisions[$index]}} {{__('Time Revisions')}}</span>
                                           </div>
                                            <a href="{{route('frontend.gigs.order')}}" data-gigid="{{$gig->id}}" data-planindex="{{$index}}" class="boxed-btn gig_order_now_btn">{{get_static_option('gig_single_'.$user_select_lang_slug.'_order_button_title')}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="get-quote-wrapper">
                            <h4 class="title">{{get_static_option('gig_single_'.$user_select_lang_slug.'_quote_title')}}</h4>
                            <a target="_blank" href="{{route('frontend.request.quote')}}" class="boxed-btn">{{get_static_option('gig_single_'.$user_select_lang_slug.'_quote_button_title')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form action="{{route('frontend.gigs.order')}}" method="get" id="gig_order_form" enctype="multipart/form-data">
        <input type="hidden" name="gig_id" value="{{$gig->id}}">
        <input type="hidden" name="gig_select_plan_index" value="0">
    </form>
@endsection
@section('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="{{asset('assets/frontend/js/bootstrap4-rating-input.js')}}"></script>
    <script>
        (function ($) {
            "use strict";

            $(document).on('click','.gig_order_now_btn',function (e){
               e.preventDefault();
                var el = $(this);
                var gigid = el.data('gigid');
                var planindex = el.data('planindex');

                $('input[name="gig_select_plan_index"]').val(planindex);

                $('#gig_order_form').submit();
            });


            var rtlEnable = $('html').attr('dir');
            var sliderRtlValue = typeof rtlEnable === 'undefined' ||  rtlEnable === 'ltr' ? false : true ;

            $(document).ready(function () {

                $('.thumbnail-gallery-carousel').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    fade: true,
                    asNavFor: '.thumbnail-navigator',
                    rtl: sliderRtlValue,
                    prevArrow: '<div class="prev-arrow"><i class="fas fa-long-arrow-alt-left"></i></div>',
                    nextArrow: '<div class="next-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>',
                });
                $('.thumbnail-navigator').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.thumbnail-gallery-carousel',
                    dots: false,
                    arrows: true,
                    centerMode: false,
                    focusOnSelect: true,
                    rtl: sliderRtlValue,
                    prevArrow: '<div class="prev-arrow"><i class="fas fa-long-arrow-alt-left"></i></div>',
                    nextArrow: '<div class="next-arrow"><i class="fas fa-long-arrow-alt-right"></i></div>',
                });

            });

        })(jQuery)
    </script>
@endsection
