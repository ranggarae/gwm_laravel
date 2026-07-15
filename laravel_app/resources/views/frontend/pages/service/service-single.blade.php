@extends('frontend.frontend-page-master')
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.services.single',$service_item->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$service_item->title}}" />
    {!! render_og_meta_image_by_attachment_id($service_item->image) !!}
@endsection
@section('site-title')
    {{$service_item->title}} -  {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
 @endsection
 @section('page-title')
      {{$service_item->title}}
@endsection
@section('edit_link')
    <li><a href="{{route('admin.services.edit',$service_item->id)}}"><i class="far fa-edit"></i> {{__('Edit Service')}}</a></li>
@endsection
@section('breadcrumb')
    <li><a href="{{route('frontend.services.category',['id' => $service_item->categories_id, 'any' => Str::slug(get_service_category($service_item->categories_id))])}}">{{get_service_category($service_item->categories_id)}}</a></li>
    <li>{{$service_item->title}}</li>
@endsection
@section('meta-tags')
    <meta name="description" content="{{$service_item->meta_description}}">
    <meta name="tags" content="{{$service_item->meta_tags}}">
@endsection
@section('content')

    <div class="page-content service-details padding-top-120 padding-bottom-115">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="service-details-item">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($service_item->image,'','large') !!}
                        </div>
                        <h2 class="main-title">{{$service_item->title}}</h2>
                       <div class="service-description">
                           {!! $service_item->description !!}
                       </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-widget">
                        <div class="widget widget_search">
                            <form action="{{route('frontend.services.search')}}" method="get" class="search-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="s" placeholder="{{get_static_option('service_single_page_'.$user_select_lang_slug.'_search_placeholder_text')}}">
                                </div>
                                <button class="submit-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_nav_menu">
                            <h3 class="widget-title">{{get_static_option('service_single_page_'.$user_select_lang_slug.'_category_title')}}</h3>
                            <ul>
                                @foreach($service_category as $data)
                                    <li @if($data->id == $service_item->category->id ) class="active" @endif><a href="{{route('frontend.services.category',['id' => $data->id, 'any' => Str::slug($data->name)])}}">{{$data->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget widget_recent_posts">
                            <h4 class="widget-title">{{get_static_option('service_single_page_'.$user_select_lang_slug.'_recent_services_title')}}</h4>
                            <ul class="recent_post_item">
                                @foreach($recent_services as $data)
                                    <li class="single-recent-post-item">
                                        <div class="thumb">
                                            {!! render_image_markup_by_attachment_id($data->image,'','thumb') !!}
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="{{route('frontend.services.single',$data->slug)}}">{{$data->title}}</a></h4>
                                            <span class="time">{{date_format($data->created_at,'d M y')}}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
