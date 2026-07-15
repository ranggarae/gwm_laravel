@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('breadcrumb')
    <li>{{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_tags')}}">
    <meta name="tags" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_description')}}">
@endsection
@section('content')
    <div class="page-content contact-page padding-top-120 padding-bottom-120">
        <div class="container">
            <div class="row">
                @if(get_static_option('contact_page_form_section_status') == 'on')
                <div class="col-lg-6">
                    <div class="left-content-area">
                        <div class="section-title desktop-left margin-bottom-50">
                            <h2 class="title">{{get_static_option('contact_page_'.$user_select_lang_slug.'_form_section_title')}}</h2>
                            <p>{{get_static_option('contact_page_'.$user_select_lang_slug.'_form_section_description')}}</p>
                        </div>
                        @include('backend.partials.message')
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li>{{$message}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('frontend.contact.message')}}" method="post" enctype="multipart/form-data" id="contact_form_submit" class="contact-form">
                            @csrf
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            <div class="row">
                                <div class="col-lg-12">
                                    {!! render_form_field_for_frontend(get_static_option('contact_page_form_fields')) !!}
                                </div>
                                <div class="col-lg-12">
                                    <button class="submit-btn" type="submit">{{__('Send Message')}}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                @endif
                <div class="col-lg-6">
                    <div class="right-content-area">
                        @if(get_static_option('contact_page_contact_info_section_status') == 'on')
                        <ul class="contact-info-list">
                            @foreach($all_contact_info as $data)
                                <li class="single-contact-info">
                                    <div class="icon">
                                        <i class="{{$data->icon}}"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">{{$data->title}}</h4>
                                        @php $desc = explode(';',$data->description) @endphp
                                        @foreach($desc as $item)
                                            <span class="details">{{$item}}</span>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                        @if(get_static_option('contact_page_google_map_section_status') == 'on')
                        <div id="map"  class="contact_page_map margin-top-40">
                            {!! render_embed_google_map(get_static_option('contact_page_map_section_address'),20) !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @if(!empty(get_static_option('site_google_captcha_v3_site_key')))
     <script src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function(token) {
                document.getElementById('gcaptcha_token').value = token;
            });
        });
    </script>
    @endif
@endsection