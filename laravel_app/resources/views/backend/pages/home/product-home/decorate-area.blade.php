@extends('backend.admin-master')
@section('site-title')
    {{__('Decorate Area')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
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
                        <h4 class="header-title">{{__('Decorate Area Settings')}}</h4>
                        <form action="{{route('admin.product.home.decorate.area')}}" method="post" enctype="multipart/form-data">
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
                                        <label for="home_page_08_{{$lang->slug}}_decorate_area_title">{{__('Title')}}</label>
                                        <input type="text" name="home_page_08_{{$lang->slug}}_decorate_area_title" class="form-control" value="{{get_static_option('home_page_08_'.$lang->slug.'_decorate_area_title')}}" id="home_page_08_{{$lang->slug}}_decorate_area_title">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <input type="hidden" name="home_page_08_{{$lang->slug}}_decorate_area_description" value="{{get_static_option('home_page_08_'.$lang->slug.'_decorate_area_description')}}">
                                        <div class="summernote" data-content='{{get_static_option('home_page_08_'.$lang->slug.'_decorate_area_description')}}'></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>{{__('Right Image')}}</label>
                                @php $background_image_upload_btn_label = 'Upload Image'; @endphp
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @php
                                            $background_img = get_attachment_image_by_id(get_static_option('home_page_08_decorate_area_right_image'),null,false);
                                        @endphp
                                        @if (!empty($background_img))
                                            <div class="attachment-preview">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img class="avatar user-thumb" src="{{$background_img['img_url']}}" >
                                                    </div>
                                                </div>
                                            </div>
                                            @php $background_image_upload_btn_label = 'Change Image'; @endphp
                                        @endif
                                    </div>
                                    <input type="hidden" name="home_page_08_decorate_area_right_image" value="{{get_static_option('home_page_08_decorate_area_right_image')}}">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-imgid="{{get_static_option('home_page_08_decorate_area_right_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__($background_image_upload_btn_label)}}
                                    </button>
                                </div>
                                <small>{{__('recommended image size is 925x445 pixel')}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')

    <script>
        $(document).ready(function (){
            $('.summernote').summernote({
                height: 200,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }
        });
    </script>
@endsection