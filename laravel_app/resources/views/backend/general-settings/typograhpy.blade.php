@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('site-title')
    {{__('Typography Settings')}}
@endsection

@php
$body_font_family = '';
$body_font_variant = '';

$heading_font_family = '';
$heading_font_variant = '';
    foreach ($google_fonts as $font_family => $font_variant){
    $select_body_fonts = !empty(get_static_option('body_font_family')) ?  get_static_option('body_font_family') : 'Poppins';
    $select_heading_fonts = !empty(get_static_option('heading_font_family')) ?  get_static_option('heading_font_family') : 'Poppins';
    $body_font_family_selected = (get_static_option('body_font_family') == $font_family) || $select_body_fonts == $font_family ? 'selected' : '' ;
    $heading_font_family_selected = (get_static_option('heading_font_family') == $font_family) || $select_heading_fonts == $font_family ? 'selected' : '' ;
    $body_font_family .= sprintf('<option value="%1$s" %2$s>%3$s</option>',$font_family,$body_font_family_selected,$font_family);
    $heading_font_family .= sprintf('<option value="%1$s" %2$s>%3$s</option>',$font_family,$heading_font_family_selected,$font_family);

        if ($select_body_fonts == $font_family){
            foreach ($font_variant->variants as $variant){
            $body_font_variant_selected_arr = !empty(get_static_option('body_font_variant')) ? unserialize(get_static_option('body_font_variant')) : ['regular'];
            $body_font_variant_select = in_array($variant,$body_font_variant_selected_arr) ? 'selected' : '';
            $body_font_variant .= sprintf('<option value="%1$s" %2$s>%3$s</option>',$variant,$body_font_variant_select,$variant);
            }
        }
        if ($select_heading_fonts == $font_family){
            foreach ($font_variant->variants as $variant){
             $heading_font_variant_selected_arr = !empty(get_static_option('heading_font_variant')) ? unserialize(get_static_option('heading_font_variant')) : ['regular'];
            $heading_font_variant_select = in_array($variant,$heading_font_variant_selected_arr) ? 'selected' : '';
            $heading_font_variant .= sprintf('<option value="%1$s" %2$s>%3$s</option>',$variant,$heading_font_variant_select,$variant);
            }
        }
    }
@endphp

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Body Typography Settings")}}</h4>
                        <form action="{{route('admin.general.typography.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="body_font_family">{{__('Font Family')}}</label>
                                <select class="form-control nice-select wide" name="body_font_family" id="body_font_family">
                                    {!! $body_font_family !!}
                                </select>
                            </div>
                            <div class="form-group margin-top-50">
                                <label for="body_font_variant">{{__('Font Variant')}}</label>
                                <select class="form-control nice-select wide" multiple id="body_font_variant" name="body_font_variant[]">
                                    {!! $body_font_variant !!}
                                </select>
                            </div>
                            <h4 class="header-title margin-top-80">{{__("Heading Typography Settings")}}</h4>
                            <div class="form-group">
                                <label for="heading_font">{{__('Heading Font')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="heading_font"  @if(!empty(get_static_option('heading_font'))) checked @endif id="heading_font">
                                    <span class="slider"></span>
                                </label>
                                <small>{{__('Use different font family for heading tags ( h1,h2,h3,h4,h5,h6)')}}</small>
                            </div>
                            <div class="form-group">
                                <label for="heading_font_family">{{__('Font Family')}}</label>
                                <select class="form-control nice-select wide" name="heading_font_family" id="heading_font_family">
                                    {!! $heading_font_family !!}
                                </select>
                            </div>
                            <div class="form-group margin-top-50">
                                <label for="heading_font_variant">{{__('Font Variant')}}</label>
                                <select class="form-control nice-select wide" multiple name="heading_font_variant[]" id="heading_font_variant">
                                    {!! $heading_font_variant !!}
                                </select>
                            </div>
                            <button type="submit" id="typography_submit_btn" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
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
        (function($){
            "use strict";
            $(document).ready(function(){

                //load font variant

                $(document).on('change','#body_font_family',function (e) {
                    e.preventDefault();
                     var fontFamily =  $(this).val();
                    $('#typography_submit_btn').attr('disabled',true);
                    $.ajax({
                        url: "{{route('admin.general.typography.single')}}",
                        type: "POST",
                        data:{
                            _token: "{{csrf_token()}}",
                            font_family : fontFamily
                        },
                        success:function (data) {
                            var variantSelector = $('#body_font_variant');
                            variantSelector.html('');
                            $.each(data.variants,function (index,value) {
                                variantSelector.append('<option value="'+value+'">'+value+'</option>');
                            });
                            variantSelector.niceSelect('update');
                            $('#typography_submit_btn').attr('disabled',false);
                        }
                    });
                });
                $(document).on('change','#heading_font_family',function (e) {
                    e.preventDefault();
                    var fontFamily =  $(this).val();
                    $('#typography_submit_btn').attr('disabled',true);
                    $.ajax({
                        url: "{{route('admin.general.typography.single')}}",
                        type: "POST",
                        data:{
                            _token: "{{csrf_token()}}",
                            font_family : fontFamily
                        },
                        success:function (data) {
                            var variantSelector = $('#heading_font_variant');
                            variantSelector.html('');
                            $.each(data.variants,function (index,value) {
                                variantSelector.append('<option value="'+value+'">'+value+'</option>');
                            });

                            variantSelector.niceSelect('update');
                            $('#typography_submit_btn').attr('disabled',false);
                        }
                    });

                });

                if($('.nice-select').length > 0){
                    $('.nice-select').niceSelect();
                }
                var dependendFields = $('select[name="heading_font_family"],#heading_font_variant');
                if(!$('input[name="heading_font"]').prop('checked')){
                    dependendFields.parent().hide()
                }
                $(document).on('change','input[name="heading_font"]',function (e) {
                    if(!$(this).prop('checked')){
                        dependendFields.parent().hide();
                    }else{
                        dependendFields.parent().show();
                    }
                });

                $(document).on('click','#typography_submit_btn',function (e) {
                    e.preventDefault();
                    $(this).text('Updating...').prop('disabled',true);
                    $(this).parent().submit();
                })
            });
        }(jQuery));
    </script>
@endsection
