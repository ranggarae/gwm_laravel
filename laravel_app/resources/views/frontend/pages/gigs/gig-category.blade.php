@extends('frontend.frontend-page-master')
@section('page-title')
     {{$category_name}}
@endsection
@section('site-title')
     {{$category_name}}
@endsection
@section('breadcrumb')
    <li>{{$category_name}}</li>
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                @if(count($gigs) > 0)
                @foreach($gigs as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-gig-item">
                            <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                                <div class="price-wrap">
                                    {{__("Start From").' '.gig_start_price($data->id)}}
                                </div>
                                <a href="{{route('frontend.gigs.single',$data->slug)}}" class="order-btn"><i class="fas fa-shopping-cart"></i></a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{{route('frontend.gigs.single',$data->slug)}}">{{$data->title}}</a></h4>
                                <p>{!! Str::words(strip_tags($data->description),20) !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12 text-center">
                    <nav class="pagination-wrapper " aria-label="Page navigation ">
                        {{$gigs->links()}}
                    </nav>
                </div>
                @else
                    <div class="col-lg-12">
                        <div class="alert alert-warning">
                            {{__('No Gig Founds..')}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
