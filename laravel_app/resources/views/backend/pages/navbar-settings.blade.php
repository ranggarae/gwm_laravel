@extends('backend.admin-master')

@section('site-title')
    {{__('Navbar Settings')}}
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
                        <h4 class="header-title">{{__('Navbar Button Settings')}}</h4>
                        <form action="{{route('admin.navbar.settings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="navbar_button">{{__('Button Show/Hide')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="navbar_button"  @if(!empty(get_static_option('navbar_button'))) checked @endif id="navbar_button">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach( get_all_language() as $key => $value)
                                    <a class="nav-item nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#nav_{{$key}}" role="tab" aria-selected="true">{{$value->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-20" id="nav-tabContent">
                                @foreach( get_all_language() as $key => $value)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="navbar_{{$value->slug}}_button_text">{{__('Button Text')}}</label>
                                        <input type="text" name="navbar_{{$value->slug}}_button_text" class="form-control" value="{{get_static_option('navbar_'.$value->slug.'_button_text')}}" id="navbar_{{$value->slug}}_button_text">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="navbar_button_custom_url_status">{{__('Button Custom URL')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="navbar_button_custom_url_status"  @if(!empty(get_static_option('navbar_button_custom_url_status'))) checked @endif id="navbar_button_custom_url_status">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="navbar_button_custom_url">{{__('Quote Button URL')}}</label>
                                <input type="text" name="navbar_button_custom_url" class="form-control" value="{{get_static_option('navbar_button_custom_url')}}" id="navbar_button_custom_url">
                            </div>
                            <h4 class="header-title margin-top-40">{{__('Navbar Style Settings For Inner Pages')}}</h4>
                            <input type="hidden" name="site_header_type" id="header_type" value="{{get_static_option('site_header_type')}}">
                            <div class="img-select">
                                <div class="img-wrap">
                                    <img src="{{asset('assets/frontend/navbar-variant/navbar-01.png')}}" style="width: 100%" data-header_type="navbar" alt="">
                                </div>
                            </div>
                            <div class="img-select">
                                <div class="img-wrap">
                                    <img src="{{asset('assets/frontend/navbar-variant/navbar-02.png')}}" style="width: 100%" data-header_type="navbar-01" alt="">
                                </div>
                            </div>
                            <div class="img-select">
                                <div class="img-wrap">
                                    <img src="{{asset('assets/frontend/navbar-variant/navbar-03.png')}}" style="width: 100%" data-header_type="navbar-02" alt="">
                                </div>
                            </div>
                            <div class="img-select">
                                <div class="img-wrap">
                                    <img src="{{asset('assets/frontend/navbar-variant/navbar-04.png')}}" style="width: 100%" data-header_type="navbar-03" alt="">
                                </div>
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
    <script>
        (function($){
            "use strict";

            $(document).ready(function () {

                var imgSelect = $('.img-select');
                var id = $('#header_type').val();
                imgSelect.removeClass('selected');
                $('img[data-header_type="'+id+'"]').parent().parent().addClass('selected');

                $(document).on('click','.img-select img',function (e) {
                    e.preventDefault();
                    imgSelect.removeClass('selected');
                    $(this).parent().parent().addClass('selected').siblings();
                    $('#header_type').val($(this).data('header_type'));
                });



            })

        })(jQuery);
    </script>
@endsection