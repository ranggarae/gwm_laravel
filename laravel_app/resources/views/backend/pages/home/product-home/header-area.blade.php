@extends('backend.admin-master')
@section('site-title')
    {{__('Header Slider Area')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
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
                        <h4 class="header-title">{{__('Header Slider Area Settings')}}</h4>
                        <form action="{{route('admin.product.home.header.slider')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @php
                            $all_icon_fields =  get_static_option('home_08_header_bg_image');
                            $all_icon_fields = !empty($all_icon_fields) ? unserialize($all_icon_fields) : [get_static_option('site_logo')];
                            $button_url_fields =  get_static_option('home_page_08_header_slider_button_url');
                            $button_url_fields = !empty($button_url_fields) ? unserialize($button_url_fields) : ['#'];
                            @endphp
                            @foreach($all_icon_fields as $index => $icon_field)
                            <div class="iconbox-repeater-wrapper">
                                <div class="all-field-wrap">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        @foreach($all_languages as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$lang->slug}}_{{$key + $index}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content margin-top-30" id="myTabContent">
                                        @foreach($all_languages as $key => $lang)
                                            @php
                                                $all_title_fields = get_static_option('home_page_08_'.$lang->slug.'_header_slider_title');
                                                $all_title_fields = !empty($all_title_fields) ? unserialize($all_title_fields) : ['volunteers'];
                                                $all_button_text_fields = get_static_option('home_page_08_'.$lang->slug.'_header_slider_button_text');
                                                $all_button_text_fields = !empty($all_button_text_fields) ? unserialize($all_button_text_fields) : ['Shop Now'];
                                                $all_description_fields = get_static_option('home_page_08_'.$lang->slug.'_header_slider_description');
                                                $all_description_fields = !empty($all_description_fields) ? unserialize($all_description_fields) : ['Do so written as raising parlors spirits mr elderly. Made late in of high left hold.'];
                                            @endphp

                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$lang->slug}}_{{$key + $index}}" role="tabpanel" >
                                                <div class="form-group">
                                                    <label for="home_page_08_{{$lang->slug}}_header_slider_title">{{__('Title')}}</label>
                                                    <input type="text" name="home_page_08_{{$lang->slug}}_header_slider_title[]" class="form-control" value="{{$all_title_fields[$index]}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="home_page_08_{{$lang->slug}}_header_slider_description">{{__('Description')}}</label>
                                                    <textarea name="home_page_08_{{$lang->slug}}_header_slider_description[]" class="form-control max-height-120" rows="10" >{{$all_description_fields[$index]}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="home_page_08_{{$lang->slug}}_header_slider_button_text">{{__('Button Text')}}</label>
                                                    <input type="text" name="home_page_08_{{$lang->slug}}_header_slider_button_text[]" class="form-control" value="{{isset($all_button_text_fields[$index]) ? $all_button_text_fields[$index] : ''}}">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="home_page_08_header_slider_button_url">{{__('Button URL')}}</label>
                                            <input type="text" name="home_page_08_header_slider_button_url[]" class="form-control" value="{{$button_url_fields[$index]}}">
                                        </div>

                                            <div class="form-group">
                                                <label for="home_08_header_bg_image">{{__('Image')}} </label>
                                                @php $signature_image_upload_btn_label = 'Upload Image'; @endphp
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap">
                                                        @php
                                                            $signature_img = get_attachment_image_by_id($icon_field,null,false);
                                                        @endphp
                                                        @if (!empty($signature_img))
                                                            <div class="attachment-preview">
                                                                <div class="thumbnail">
                                                                    <div class="centered">
                                                                        <img class="avatar user-thumb" src="{{$signature_img['img_url']}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php $signature_image_upload_btn_label = 'Change Image'; @endphp
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="home_08_header_bg_image[]" value="{{$icon_field}}">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-imgid="{{$icon_field}}" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__($signature_image_upload_btn_label)}}
                                                    </button>
                                                </div>
                                                <small>{{__('recommended image size is 1920x1000 pixel')}}</small>
                                            </div>
                                    </div>
                                    <div class="action-wrap">
                                        <span class="add"><i class="ti-plus"></i></span>
                                        <span class="remove"><i class="ti-trash"></i></span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>

        $(document).ready(function ($){
           "use strict";


            $(document).on('click','.all-field-wrap .action-wrap .add',function (e){
                e.preventDefault();

                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');
                var clonedData = parent.clone();
                var containerLength = container.length;
                clonedData.find('#myTab').attr('id','mytab_'+containerLength);
                clonedData.find('#myTabContent').attr('id','myTabContent_'+containerLength);
                var allTab =  clonedData.find('.tab-pane');
                allTab.each(function (index,value){
                    var el = $(this);
                    var oldId = el.attr('id');
                    el.attr('id',oldId+containerLength);
                });
                var allTabNav =  clonedData.find('.nav-link');
                allTabNav.each(function (index,value){
                    var el = $(this);
                    var oldId = el.attr('href');
                    el.attr('href',oldId+containerLength);
                });

                parent.parent().append(clonedData);

                if (containerLength > 0){
                    parent.parent().find('.remove').show(300);
                }

            });

            $(document).on('click','.all-field-wrap .action-wrap .remove',function (e){
                e.preventDefault();

                var el = $(this);
                var parent = el.parent().parent();
                var container = $('.all-field-wrap');

                if (container.length > 1){
                    el.show(300);
                    parent.hide(300);
                    parent.remove();
                }else{
                    el.hide(300);
                }
            });

        });

    </script>
@endsection

