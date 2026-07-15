@extends('backend.admin-master')
@section('site-title')
    {{__('Latest Job Area')}}
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
                        <h4 class="header-title">{{__('Latest Job Area Settings')}}</h4>
                        <form action="{{route('admin.job.home.latest.job.area')}}" method="post" enctype="multipart/form-data">
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
                                        <label for="home_page_10_{{$lang->slug}}_latest_job_area_title">{{__('Title')}}</label>
                                        <input type="text" name="home_page_10_{{$lang->slug}}_latest_job_area_title" class="form-control" value="{{get_static_option('home_page_10_'.$lang->slug.'_latest_job_area_title')}}" id="home_page_10_{{$lang->slug}}_latest_job_area_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_10_{{$lang->slug}}_latest_job_area_description">{{__('Description')}}</label>
                                        <textarea name="home_page_10_{{$lang->slug}}_latest_job_area_description" class="form-control" rows="10" id="home_page_10_{{$lang->slug}}_latest_job_area_description">{{get_static_option('home_page_10_'.$lang->slug.'_latest_job_area_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_10_{{$lang->slug}}_latest_job_button_title">{{__('Button Text')}}</label>
                                        <input type="text" name="home_page_10_{{$lang->slug}}_latest_job_button_title" class="form-control" value="{{get_static_option('home_page_10_'.$lang->slug.'_latest_job_button_title')}}" id="home_page_10_{{$lang->slug}}_latest_job_button_title">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="home_page_10_latest_job_area_items">{{__('Items')}}</label>
                                <input type="text" name="home_page_10_latest_job_area_items" class="form-control" value="{{get_static_option('home_page_10_latest_job_area_items')}}" id="home_page_10_latest_job_area_items">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


