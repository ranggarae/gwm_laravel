@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('testimonial_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('testimonial_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('testimonial_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('testimonial_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('breadcrumb')
    <li>{{get_static_option('testimonial_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('content')
    <section class="testimonial-page padding-bottom-90 padding-top-120">
        <div class="container">
            <div class="row">
               <div class="col-lg-12">
                   @if(count($all_testimonial) > 0)
                    <div class="row">
                        @foreach($all_testimonial as $data)
                            <div class="col-lg-4">
                                <div class="single-testimonial-item-10 testimonial-page">
                                    <div class="top-part">
                                        <div class="thumb">
                                            {!! render_image_markup_by_attachment_id($data->image) !!}
                                        </div>
                                        <div class="author">
                                            <h4 class="title">{{$data->name}}</h4>
                                            <span class="designation">{{$data->designation}}</span>
                                        </div>
                                    </div>
                                    <div class="bottom-part">
                                        <i class="fas fa-quote-left"></i>
                                        <p>{{$data->description}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                   @else
                       <div class="alert alert-warning">{{__('No Testimonial Found')}}</div>
                   @endif
               </div>
            </div>
        </div>
    </section>
@endsection
