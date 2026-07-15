@extends('backend.admin-master')
@section('site-title')
    {{__('News Blog Area')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('News Blog Area Settings')}}</h4>
                        <form action="{{route('admin.charity.home.news.blog.area')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($all_languages as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$key}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="home_page_09_{{$lang->slug}}_news_blog_area_title">{{__('Title')}}</label>
                                        <input type="text" name="home_page_09_{{$lang->slug}}_news_blog_area_title" class="form-control" value="{{get_static_option('home_page_09_'.$lang->slug.'_news_blog_area_title')}}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_09_{{$lang->slug}}_news_blog_area_description">{{__('Description')}}</label>
                                        <textarea name="home_page_09_{{$lang->slug}}_news_blog_area_description" class="form-control" cols="30" rows="10">{{get_static_option('home_page_09_'.$lang->slug.'_news_blog_area_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_09_{{$lang->slug}}_news_blog_area_readmore_text">{{__('Read More Text')}}</label>
                                        <input type="text" name="home_page_09_{{$lang->slug}}_news_blog_area_readmore_text" class="form-control" value="{{get_static_option('home_page_09_'.$lang->slug.'_news_blog_area_readmore_text')}}" >
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection