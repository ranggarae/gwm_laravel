@extends('backend.admin-master')
@section('site-title')
    {{__('Featured Product Area')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
    </style>
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
                        <h4 class="header-title">{{__('Featured Product Settings')}}</h4>
                        <form action="{{route('admin.product.home.feature.product')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($all_languages as $key => $lang)
                                    <li class="nav-item">
                                        <a class="nav-link @if($key == 0) active @endif" data-lang="{{$lang->slug}}" data-toggle="tab"
                                           href="#tab_{{$key}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$key}}"
                                         role="tabpanel">
                                        <div class="form-group">
                                            <label for="home_page_08_{{$lang->slug}}_popular_article_title">{{__('Title')}}</label>
                                            <input type="text" name="home_page_08_{{$lang->slug}}_popular_article_title"
                                                   class="form-control"
                                                   value="{{get_static_option('home_page_08_'.$lang->slug.'_popular_article_title')}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_08_{{$lang->slug}}_popular_article_description">{{__('Description')}}</label>
                                            <textarea name="home_page_08_{{$lang->slug}}_popular_article_description"
                                                      class="form-control"
                                                      rows="10">{{get_static_option('home_page_08_'.$lang->slug.'_popular_article_description')}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="home_page_08_{{$lang->slug}}_featured_product_id">{{__('Featured Products')}}</label>
                                            @php
                                                $all_selected_product = get_static_option('home_page_08_'.$lang->slug.'_featured_product_id');
                                                $all_selected_products = !empty($all_selected_product) ? unserialize($all_selected_product) : [];
                                            @endphp
                                            <select name="home_page_08_{{$lang->slug}}_featured_product_id[]" multiple
                                                    class="form-control nice-select wide featured_product_select" data-value="{{json_encode($all_selected_products)}}">
                                                <option value="">{{__('Select Product')}}</option>
                                                @foreach($all_products as $data)
                                                    <option value="{{$data->id}}"
                                                            @if(is_array($all_selected_products) && in_array($data->id,$all_selected_products)) selected @endif >{{$data->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit"
                                    class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
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
        $(document).ready(function () {
            $niceSelect = $('.nice-select');
            if ($niceSelect.length > 0) {
                $niceSelect.niceSelect();
            }
            initProductSelect();
            function initProductSelect(){
                var initTab = $('.nav-link.active');
                loadProductByLang(initTab.data('lang'));
            }

            $(document).on('click', '.nav-link', function (e) {
                e.preventDefault();
                var el = $(this);
                var lang = el.data('lang');
                loadProductByLang(lang)
            });

            function loadProductByLang(lang){
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.product.home.product.by.lang')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        lang: lang
                    },
                    success: function (data) {
                        var navID = $('.nav-link[data-lang="'+lang+'"]').attr('href');
                        var selectField = $(navID).find('select.featured_product_select');
                        selectField.html('');
                        var selectedProduct = selectField.data('value');

                        data.forEach(function (item,index){
                            var selected = $.inArray(item.id.toString(),selectedProduct) !== -1 ? 'selected' : '';
                            selectField.append('<option value="'+item.id+'" '+selected+'>'+item.title+'</option>');
                        });
                        $('.nice-select').niceSelect('update');
                    }
                });
            }

        });
    </script>
@endsection

