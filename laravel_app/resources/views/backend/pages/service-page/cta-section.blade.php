@extends('backend.admin-master')

@section('site-title')
    {{__('Call TO Action Section')}}
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
                        <h4 class="header-title">{{__('Call To Action Section Settings')}}</h4>
                        <form action="{{route('admin.service.page.cta')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_language as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_language as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel">
                                    <div class="form-group">
                                        <label for="service_page_{{$lang->slug}}_cta_title">{{__('Title')}}</label>
                                        <input type="text" name="service_page_{{$lang->slug}}_cta_title" value="{{get_static_option('service_page_'.$lang->slug.'_cta_title')}}" class="form-control" id="service_page_{{$lang->slug}}_cta_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="service_page_{{$lang->slug}}_cta_description">{{__('Description')}}</label>
                                        <textarea rows="5" name="service_page_{{$lang->slug}}_cta_description" class="form-control" id="service_page_{{$lang->slug}}_cta_description">{{get_static_option('service_page_'.$lang->slug.'_cta_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_page_{{$lang->slug}}_cta_button_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="service_page_{{$lang->slug}}_cta_button_status"  @if(!empty(get_static_option('service_page_'.$lang->slug.'_cta_button_status'))) checked @endif id="service_page_{{$lang->slug}}_cta_button_status">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="service_page_{{$lang->slug}}_cta_button_text">{{__('Button Text')}}</label>
                                        <input type="text" name="service_page_{{$lang->slug}}_cta_button_text" value="{{get_static_option('service_page_'.$lang->slug.'_cta_button_text')}}" class="form-control" id="service_page_{{$lang->slug}}_cta_button_text">
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

