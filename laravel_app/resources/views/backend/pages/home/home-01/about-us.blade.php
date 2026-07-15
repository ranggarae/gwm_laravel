@extends('backend.admin-master')
@section('site-title')
    {{__('About Us Area')}}
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
                        <h4 class="header-title">{{__('About Us Area Settings')}}</h4>
                        <form action="{{route('admin.homeone.about.us')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach(get_all_language() as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$key}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                @foreach(get_all_language() as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_about_us_title">{{__('Title')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_about_us_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_title')}}" id="home_page_01_{{$lang->slug}}_about_us_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_about_us_description">{{__('Description')}}</label>
                                        <textarea name="home_page_01_{{$lang->slug}}_about_us_description" class="form-control" rows="10" id="home_page_01_{{$lang->slug}}_about_us_description">{{get_static_option('home_page_01_'.$lang->slug.'_about_us_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_about_us_button_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="home_page_01_{{$lang->slug}}_about_us_button_status"  @if(!empty(get_static_option('home_page_01_'.$lang->slug.'_about_us_button_status'))) checked @endif id="home_page_01_{{$lang->slug}}_about_us_button_status">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_about_us_button_title">{{__('Button Title')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_about_us_button_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_button_title')}}" id="home_page_01_{{$lang->slug}}_about_us_button_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_about_us_button_url">{{__('Button URL')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_about_us_button_url" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_button_url')}}" id="home_page_01_{{$lang->slug}}_about_us_button_url">
                                    </div>

                                    @if(in_array(get_static_option('home_page_variant'), ['01', '03', 'gwm-corporate', 'gwm-industrial', 'gwm-minimalist']))
                                        <div class="form-group">
                                            <label for="home_page_01_{{$lang->slug}}_about_us_signature_text">{{__('Signature Text')}}</label>
                                            <input type="text" name="home_page_01_{{$lang->slug}}_about_us_signature_text" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_signature_text')}}" id="home_page_01_{{$lang->slug}}_about_us_signature_text">
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('Signature Image')}}</label>
                                            @php $signature_image_upload_btn_label = 'Upload Signature Image'; @endphp
                                            <div class="media-upload-btn-wrapper">
                                                <div class="img-wrap">
                                                    @php
                                                        $signature_img = get_attachment_image_by_id(get_static_option('home_page_01_'.$lang->slug.'_about_us_signature_image'),null,false);
                                                    @endphp
                                                    @if (!empty($signature_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$signature_img['img_url']}}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $signature_image_upload_btn_label = 'Change Signature Image'; @endphp
                                                    @endif
                                                </div>
                                                <input type="hidden" name="home_page_01_{{$lang->slug}}_about_us_signature_image" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_signature_image')}}">
                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Signature Image" data-modaltitle="Upload Signature Image" data-imgid="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_signature_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                    {{__($signature_image_upload_btn_label)}}
                                                </button>
                                            </div>
                                            <small>{{__('recommended image size is 100x30 pixel')}}</small>
                                        </div>
                                    @endif
                                    @if(in_array(get_static_option('home_page_variant'), ['01', 'gwm-corporate', 'gwm-industrial', 'gwm-minimalist']))
                                    <div class="form-group">
                                        <label>{{__('Background Image')}}</label>
                                        @php $background_image_upload_btn_label = 'Upload Background Image'; @endphp
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @php
                                                    $background_img = get_attachment_image_by_id(get_static_option('home_page_01_'.$lang->slug.'_about_us_background_image'),null,false);
                                                @endphp
                                                @if (!empty($background_img))
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="{{$background_img['img_url']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $background_image_upload_btn_label = 'Change Background Image'; @endphp
                                                @endif
                                            </div>
                                            <input type="hidden" name="home_page_01_{{$lang->slug}}_about_us_background_image" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_background_image')}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Background Image" data-modaltitle="Upload Background Image" data-imgid="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_background_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__($background_image_upload_btn_label)}}
                                            </button>
                                        </div>
                                        <small>{{__('recommended image size is 572x470 pixel')}}</small>
                                    </div>
                                    @endif
                                    @if(get_static_option('home_page_variant') == '02' || get_static_option('home_page_variant') == '04')
                                        <div class="form-group">
                                            <label>{{__('Background Image')}}</label>
                                            @php $home_02_background_image_upload_btn_label = 'Upload Background Image'; @endphp
                                            <div class="media-upload-btn-wrapper">
                                                <div class="img-wrap">
                                                    @php
                                                        $home_02_background_img = get_attachment_image_by_id(get_static_option('home_page_02_'.$lang->slug.'_about_us_background_image'),null,false);
                                                    @endphp
                                                    @if (!empty($home_02_background_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$home_02_background_img['img_url']}}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $home_02_background_image_upload_btn_label = 'Change Background Image'; @endphp
                                                    @endif
                                                </div>
                                                <input type="hidden" name="home_page_02_{{$lang->slug}}_about_us_background_image" value="{{get_static_option('home_page_02_'.$lang->slug.'_about_us_background_image')}}">
                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Background Image" data-modaltitle="Upload Background Image" data-imgid="{{get_static_option('home_page_02_'.$lang->slug.'_about_us_background_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                    {{__($home_02_background_image_upload_btn_label)}}
                                                </button>
                                            </div>
                                            <small>{{__('recommended image size is 1920x575 pixel')}}</small>
                                        </div>
                                    @endif
                                    @if(get_static_option('home_page_variant') == '03')
                                        <div class="form-group">
                                            <label>{{__('Right Image')}}</label>
                                            @php $home_01_right_image_upload_btn_label = 'Upload Right Image'; @endphp
                                            <div class="media-upload-btn-wrapper">
                                                <div class="img-wrap">
                                                    @php
                                                        $home_01_right_img = get_attachment_image_by_id(get_static_option('home_page_01_'.$lang->slug.'_about_us_right_image'),null,false);
                                                    @endphp
                                                    @if (!empty($home_01_right_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$home_01_right_img['img_url']}}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $home_01_right_image_upload_btn_label = 'Change Right Image'; @endphp
                                                    @endif
                                                </div>
                                                <input type="hidden" name="home_page_01_{{$lang->slug}}_about_us_right_image" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_right_image')}}">
                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Right Image" data-modaltitle="Upload Right Image" data-imgid="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_right_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                    {{__($home_01_right_image_upload_btn_label)}}
                                                </button>
                                            </div>
                                            <small>{{__('recommended image size is 690x1190 pixel')}}</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="home_page_01_{{$lang->slug}}_about_us_quote_box_title">{{__('Quote Box Title')}}</label>
                                            <input type="text" name="home_page_01_{{$lang->slug}}_about_us_quote_box_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_quote_box_title')}}" id="home_page_01_{{$lang->slug}}_about_us_quote_box_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_01_{{$lang->slug}}_about_us_quote_box_description">{{__('Quote Box Description')}}</label>
                                            <textarea name="home_page_01_{{$lang->slug}}_about_us_quote_box_description" class="form-control" rows="10" id="home_page_01_{{$lang->slug}}_about_us_quote_box_description">{{get_static_option('home_page_01_'.$lang->slug.'_about_us_quote_box_description')}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_01_{{$lang->slug}}_about_us_experience_title">{{__('Experience Title')}}</label>
                                            <input type="text" name="home_page_01_{{$lang->slug}}_about_us_experience_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_experience_title')}}" id="home_page_01_{{$lang->slug}}_about_us_experience_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_01_{{$lang->slug}}_about_us_experience_year">{{__('Experience Year')}}</label>
                                            <input type="text" name="home_page_01_{{$lang->slug}}_about_us_experience_year" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_experience_year')}}" id="home_page_01_{{$lang->slug}}_about_us_experience_year">
                                        </div>
                                        <div class="form-group">
                                            <label >{{__('Experience Background Image')}}</label>
                                            @php $home_01_experience_background_image_upload_btn_label = 'Upload Experience Background Image'; @endphp
                                            <div class="media-upload-btn-wrapper">
                                                <div class="img-wrap">
                                                    @php
                                                        $home_01_experience_background_img = get_attachment_image_by_id(get_static_option('home_page_01_'.$lang->slug.'_about_us_experience_background_image'),null,false);
                                                    @endphp
                                                    @if (!empty($home_01_experience_background_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$home_01_experience_background_img['img_url']}}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $home_01_experience_background_image_upload_btn_label = 'Change Experience Background Image'; @endphp
                                                    @endif
                                                </div>
                                                <input type="hidden" name="home_page_01_{{$lang->slug}}_about_us_experience_background_image" value="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_experience_background_image')}}">
                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Experience Background Image" data-modaltitle="Upload Experience Background Image" data-imgid="{{get_static_option('home_page_01_'.$lang->slug.'_about_us_experience_background_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                    {{__($home_01_experience_background_image_upload_btn_label)}}
                                                </button>
                                            </div>
                                            <small>{{__('recommended image size is 270x310 pixel')}}</small>
                                        </div>
                                    @endif
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
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection

