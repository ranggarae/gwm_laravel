@extends('backend.admin-master')
@section('site-title')
    {{__('Form Section')}}
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
                        <h4 class="header-title">{{__('Form Section Settings')}}</h4>
                        <form action="{{route('admin.contact.page.form.area')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($all_languages as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#home-{{$lang->slug}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="contact_page_{{$lang->slug}}_form_section_title">{{__('Title')}}</label>
                                        <input type="text" name="contact_page_{{$lang->slug}}_form_section_title" value="{{get_static_option('contact_page_'.$lang->slug.'_form_section_title')}}" class="form-control" id="contact_page_{{$lang->slug}}_form_section_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_page_{{$lang->slug}}_form_section_description">{{__('Description')}}</label>
                                        <textarea name="contact_page_{{$lang->slug}}_form_section_description" id="contact_page_{{$lang->slug}}_form_section_description" class="form-control max-height-120" cols="30" rows="10">{{get_static_option('contact_page_'.$lang->slug.'_form_section_description')}}</textarea>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="contact_page_form_email">{{__('Receiving Mail')}}</label>
                                <input type="text" name="contact_page_form_email" value="{{get_static_option('contact_page_form_email')}}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
