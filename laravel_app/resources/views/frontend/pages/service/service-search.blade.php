@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Search For:')}} {{$search_term}}
@endsection
@section('breadcrumb')
    <li>{{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}</li>
    <li>{{__('Search For:')}} {{$search_term}} </li>
@endsection
@section('site-title')
    {{__('Search For:')}} {{$search_term}}
@endsection

@section('content')
    <section class="service-area service-page padding-120">
        <div class="container">
            <div class="row">
                @if(count($all_services) > 0)
                @foreach($all_services as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-work-item-02 margin-bottom-30 gray-bg">
                            <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                            </div>
                            <div class="content">
                                <a href="{{route('frontend.services.single',$data->slug)}}"><h4 class="title">{{$data->title}}</h4></a>
                                <div class="post-description">
                                    <p>{{$data->excerpt}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        {{$all_services->links()}}
                    </div>
                </div>
                @else
                 <div class="col-lg-12">
                    <div class="alert alert-warning">{{__('nothing found related to:')}} {{$search_term}}</div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
