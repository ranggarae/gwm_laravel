@extends('frontend.frontend-page-master')
@php $img_url = '';@endphp

@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',$work_item->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
    {!! render_og_meta_image_by_attachment_id($work_item->image) !!}
@endsection
@section('site-title')
    {{$work_item->title}} - {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}: {{$work_item->title}}
@endsection
@section('breadcrumb')
    <li>{{$work_item->title}}</li>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$work_item->meta_tags}}">
    <meta name="tags" content="{{$work_item->meta_description}}">
@endsection
@section('edit_link')
    <li><a target="_blank" href="{{route('admin.work.edit',$work_item->id)}}"><i class="far fa-edit"></i> {{__('Edit Works')}}</a></li>
@endsection
@section('content')
    <div class="work-details-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="portfolio-details-item">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($work_item->image,'','large') !!}
                        </div>
                        <div class="post-description">
                            {!! $work_item->description !!}
                        </div>
                        @php $gallery_item = $work_item->gallery ? explode('|',$work_item->gallery) : []; @endphp
                        @if(!empty($gallery_item))
                            <div class="case-study-gallery-wrapper margin-bottom-30 margin-top-40">
                                <h2 class="main-title margin-bottom-30">{{get_static_option('work_single_page_'.$user_select_lang_slug.'_gallery_title')}}</h2>
                                <div class="case-study-gallery-carousel owl-carousel">
                                    @foreach($gallery_item as $gall)
                                        <div class="single-gallery-item">
                                            {!! render_image_markup_by_attachment_id($gall) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project-widget">
                        <div class="project-info-item">
                            <h4 class="title">{{get_static_option('work_single_page_'.$user_select_lang_slug.'_sidebar_title')}}</h4>
                            <ul>
                                <li>{{get_static_option('work_single_page_'.$user_select_lang_slug.'_start_date_text')}} <span class="right">{{$work_item->start_date}} </span></li>
                                <li>{{get_static_option('work_single_page_'.$user_select_lang_slug.'_end_date_text')}} <span class="right"> {{$work_item->end_date}}</span></li>
                                <li>{{get_static_option('work_single_page_'.$user_select_lang_slug.'_clients_text')}} <span class="right">{{$work_item->clients}} </span></li>
                                <li>{{get_static_option('work_single_page_'.$user_select_lang_slug.'_category_text')}} <span class="right">
                                         @php
                                             $all_cat_of_post = get_work_category_by_id($work_item->id);
                                         @endphp
                                        @if(!empty($all_cat_of_post))
                                        @foreach($all_cat_of_post as $key => $work_cat)
                                            <a href="{{route('frontend.works.category',['id' => $key,'any'=> Str::slug($work_cat)])}}">{{$work_cat}}</a>
                                        @endforeach
                                        @endif
                                    </span>
                                </li>
                            </ul>
                            <div class="share-area">
                                <h4 class="title">{{get_static_option('work_single_page_'.$user_select_lang_slug.'_share_text')}}</h4>
                                <ul class="share-icon">
                                    {!! single_post_share(route('frontend.work.single',$work_item->slug),$work_item->title,get_attachment_image_url_by_id($work_item->image)) !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($related_works))
                <div class="col-lg-12">
                    <div class="related-work-area padding-top-100">
                        <div class="section-title margin-bottom-55">
                            <h2 class="title">{{get_static_option('work_single_page_'.$user_select_lang_slug.'_related_work_title')}}</h2>
                        </div>
                        <div class="our-work-carousel">
                            @foreach($related_works as $data)
                                <div class="single-work-item">
                                    <div class="thumb">
                                        {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('frontend.work.single',$data->slug)}}"> {{$data->title}}</a></h4>
                                        <div class="cats">
                                            @php
                                                $all_cat_of_post = get_work_category_by_id($data->id);
                                            @endphp
                                            @foreach($all_cat_of_post as $key => $work_cat)
                                                <a href="{{route('frontend.works.category',['id' => $key,'any'=> Str::slug($work_cat)])}}">{{$work_cat}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

