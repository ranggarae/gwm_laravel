@extends('backend.admin-master')
@section('site-title')
    {{__('Featured Event Area')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
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
                        <h4 class="header-title">{{__('Featured Event Area Settings')}}</h4>
                        <form action="{{route('admin.event.home.featured.event')}}" method="post" enctype="multipart/form-data">
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
                                        <label for="home_page_07_{{$lang->slug}}_featured_area_button_title">{{__('Button Text')}}</label>
                                        <input type="text" name="home_page_07_{{$lang->slug}}_featured_area_button_title" class="form-control" value="{{get_static_option('home_page_07_'.$lang->slug.'_featured_area_button_title')}}" >
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="home_page_07_featured_event">{{__('Select Feared Event')}}</label>
                                <select name="home_page_07_featured_event" class="form-control nice-select wide">
                                    <option value="">{{__('Select Event')}}</option>
                                    @foreach($all_events as $event)
                                        <option value="{{$event->id}}" @if($event->id == get_static_option('home_page_07_featured_event')) selected @endif>{{$event->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script>
        $(document).ready(function ($){
           "user strict";

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }

        });
    </script>
@endsection
