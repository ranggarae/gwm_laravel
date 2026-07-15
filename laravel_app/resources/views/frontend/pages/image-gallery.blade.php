@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('breadcrumb')
    <li>{{get_static_option('image_gallery_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('content')
    <section class="image-gallery padding-bottom-90 padding-top-120">
        <div class="container">
            <div class="row">
               <div class="col-lg-12">
                   @if(count($gallery_images) > 0)
                       <ul class="gallery-masonry-nav">
                           <li data-filter="*" class="active"> {{__('All')}}</li>
                           @foreach($categories as $data)
                               <li data-filter=".{{Str::slug($data->title)}}">{{$data->title}}</li>
                           @endforeach
                       </ul>
                       <div class="gallery-masonry">
                           @foreach($gallery_images as $data)
                               <div class="col-lg-4 masonry-item {{Str::slug(get_gallery_category($data->category_id))}}">
                                   <div class="single-image-gallery-item">
                                       <div class="thumb">
                                           {!! render_image_markup_by_attachment_id($data->image,'masonry-image') !!}
                                           <div class="hover">
                                               @php
                                                   $gallery_img = get_attachment_image_by_id($data->image,null,true);
                                                   $img_url = !empty($gallery_img) ? $gallery_img['img_url'] : '';
                                               @endphp
                                               <a href="{{$img_url}}" class="image-popup" title="{{$data->title}}"><i class="fas fa-search"></i></a>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           @endforeach
                       </div>
                   @else
                       <div class="alert alert-warning">{{__('No Image Found')}}</div>
                   @endif
               </div>
            </div>
        </div>
    </section>
@endsection
