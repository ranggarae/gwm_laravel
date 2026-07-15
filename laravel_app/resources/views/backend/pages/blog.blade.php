@extends('backend.admin-master')
@section('site-title')
    {{__('Blog Page Settings')}}
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Blog Page Settings')}}</h4>
                        <form action="{{route('admin.blog.page')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="blog_page_{{$lang->slug}}_title">{{__('Page Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_page_{{$lang->slug}}_title" value="{{get_static_option('blog_page_'.$lang->slug.'_title')}}" name="blog_page_{{$lang->slug}}_title" placeholder="{{__('Page Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_page_{{$lang->slug}}_item">{{__('Post Item')}}</label>
                                        <input type="text" class="form-control"  id="blog_page_{{$lang->slug}}_item" value="{{get_static_option('blog_page_'.$lang->slug.'_item')}}" name="blog_page_{{$lang->slug}}_item" placeholder="{{__('Post Item')}}">
                                        <small class="text-danger">{{__('Enter how many post you want to show in blog page')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_page_{{$lang->slug}}_category_widget_title">{{__('Category Widget Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_page_{{$lang->slug}}_category_widget_title" value="{{get_static_option('blog_page_'.$lang->slug.'_category_widget_title')}}" name="blog_page_{{$lang->slug}}_category_widget_title" placeholder="{{__('Category Widget Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_page_{{$lang->slug}}_recent_post_widget_title">{{__('Recent Post Widget Title')}}</label>
                                        <input type="text" class="form-control"  id="blog_page_{{$lang->slug}}_recent_post_widget_title" name="blog_page_{{$lang->slug}}_recent_post_widget_title" value="{{get_static_option('blog_page_'.$lang->slug.'_recent_post_widget_title')}}" placeholder="{{__('Recent Post Widget Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="blog_page_{{$lang->slug}}_recent_post_widget_item">{{__('Recent Post Widget Item')}}</label>
                                        <input type="text" class="form-control"  id="blog_page_{{$lang->slug}}_recent_post_widget_item" name="blog_page_{{$lang->slug}}_recent_post_widget_item" value="{{get_static_option('blog_page_'.$lang->slug.'_recent_post_widget_item')}}" placeholder="{{__('Recent Post Widget Title')}}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Blog Page Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
