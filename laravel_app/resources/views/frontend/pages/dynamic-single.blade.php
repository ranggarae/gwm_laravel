@extends('frontend.frontend-page-master')
@section('page-meta-data')
<meta name="description" content="{{$page_post->meta_description}}">
    <meta name="tags" content="{{$page_post->meta_tags}}">
@endsection
@section('site-title')
    {{$page_post->title}}
@endsection
@section('page-title')
    {{$page_post->title}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$page_post->meta_tags}}">
    <meta name="tags" content="{{$page_post->meta_description}}">
@endsection
@section('breadcrumb')
    <li>{{__('Pages')}}</li>
    <li>{{$page_post->title}}</li>
@endsection
@section('edit_link')
    <li><a href="{{route('admin.page.edit',$page_post->id)}}"><i class="far fa-edit"></i> {{__('Edit Page')}}</a></li>
@endsection
@section('content')
    <section class="dynamic-page-content-area padding-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dynamic-page-content-wrap">
                        {!! $page_post->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
