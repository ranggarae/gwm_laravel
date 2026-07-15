@extends('frontend.frontend-page-master')
@section('page-title')
    {{get_static_option('quote_page_'.$user_select_lang_slug.'_page_title')}}
@endsection
@section('breadcrumb')
    <li>{{get_static_option('quote_page_'.$user_select_lang_slug.'_page_title')}}</li>
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('quote_page_'.$user_select_lang_slug.'_meta_tags')}}">
    <meta name="tags" content="{{get_static_option('quote_page_'.$user_select_lang_slug.'_meta_description')}}">
@endsection
@section('content')
    <section class="order-service-page-content-area padding-100">
        <div class="container">
            <div class="row">
                @foreach($all_contact_info as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact-info-02">
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
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="quote-content-area padding-top-70">
                        <h3 class="quote-title">{{get_static_option('quote_page_'.get_user_lang().'_form_title')}}</h3>
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
                        @if(env('APP_ENV') == 'development' )
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                You can build this form using admin panel <strong>Drag & Drop Form Builder</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{route('frontend.quote.message')}}" method="post" enctype="multipart/form-data" class="contact-form quote-form">
                            @csrf
                            <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            <div class="row">
                                <div class="col-lg-12">
                                @php
                                    $form_fields = json_decode(get_static_option('quote_page_form_fields'));
                                    $select_index = 0;
                                    $options = [];
                                @endphp
                                @foreach($form_fields->field_type as $key => $value)
                                        @if(!empty($value))
                                            @if($value == 'select') @php $options = explode(';',$form_fields->select_options[$select_index]);@endphp @endif
                                            @php $required = isset($form_fields->field_required->$key) ? $form_fields->field_required->$key : '' @endphp
                                            @php $mimes = isset($form_fields->mimes_type->$key) ? $form_fields->mimes_type->$key : '' @endphp
                                            {!! get_field_by_type($value,$form_fields->field_name[$key],$form_fields->field_placeholder[$key],$options,$required,$mimes) !!}
                                            @if($value == 'select') @php $select_index++@endphp @endif
                                        @endif
                                @endforeach
                                </div>

                                <div class="col-lg-12">
                                    <div class="btn-wrapper text-center">
                                        <button class="submit-btn" type="submit">{{__('Send Quote')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function(token) {
                document.getElementById('gcaptcha_token').value = token;
            });
        });
    </script>
@endsection