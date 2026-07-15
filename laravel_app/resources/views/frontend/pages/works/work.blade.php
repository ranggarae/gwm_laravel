@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('breadcrumb')
    <li>{{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('meta-tags')
    <meta name="description" content="{{get_static_option('work_page_'.$user_select_lang_slug.'_meta_tags')}}">
    <meta name="tags" content="{{get_static_option('work_page_'.$user_select_lang_slug.'_meta_description')}}">
@endsection
@section('content')
    <div class="page-content portfolio padding-top-120 padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="portfolio-masonry-wrapper">
                        <ul class="portfolio-menu">
                            <li class="active" data-filter="*">{{get_static_option('work_page_'.$user_select_lang_slug.'_all_cat_text')}}</li>
                            @foreach($all_work_category as $data)
                                <li data-filter=".{{Str::slug($data->name)}}">{{$data->name}}</li>
                            @endforeach
                        </ul>
                        <div class="portfolio-masonry">
                            @foreach($all_work as $data)
                                <div class="col-lg-4 col-md-6 masonry-item {{get_work_category_by_id($data->id,'slug')}}">
                                    <div class="single-work-item">
                                        <div class="thumb">
                                            {!! render_image_markup_by_attachment_id($data->image,'masonry-image','grid') !!}
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="{{route('frontend.work.single',$data->slug)}}"> {{$data->title}}</a></h4>
                                            <div class="cats">
                                                @php
                                                    $all_cat_of_post = get_work_category_by_id($data->id);
                                                @endphp
                                                @if(!empty($all_cat_of_post))
                                                @foreach($all_cat_of_post as $key => $work_cat)
                                                    <a href="{{route('frontend.works.category',['id' => $key,'any'=> Str::slug($work_cat)])}}">{{$work_cat}}</a>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="post-pagination-wrapper">
                        {{$all_work->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
