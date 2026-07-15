@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Tags:')}} {{$tag_name}}
@endsection
@section('site-title')
    {{__('Tags:')}} {{$tag_name}}
@endsection
@section('breadcrumb')
    <li><a href="route('frontend.blog')">{{get_static_option('blog_page_'.$user_select_lang_slug.'_name')}}</a></li>
    <li>{{__('Tags:')}} {{$tag_name}}</li>
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_tags')}}">
    <meta name="tags" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_description')}}">
@endsection
@section('content')
    <section class="blog-content-area padding-120 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if(count($all_blogs) < 1)
                            <div class="col-lg-12">
                                <div class="alert alert-danger">
                                    {{__('No Post Available In ').$tag_name.__(' Tags')}}
                                </div>
                            </div>
                        @endif
                            @foreach($all_blogs as $data)
                                <div class="col-lg-6 col-md-6">
                                    <div class="single-blog-grid-01 margin-bottom-30">
                                        <div class="thumb">
                                            {!! render_image_markup_by_attachment_id($data->image) !!}
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
                                </div>
                            @endforeach
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper" aria-label="Page navigation ">
                           {{$all_blogs->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
