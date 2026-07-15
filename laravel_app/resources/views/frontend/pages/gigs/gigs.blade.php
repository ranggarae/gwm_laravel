@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('breadcrumb')
    <li> {{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-archive-top-content-area">
                                <div class="search-form">
                                    <input type="text" class="form-control" id="search_term" placeholder="{{__('Search..')}}" value="{{$search_term}}">
                                    <button type="button" id="product_search_btn"><i class="fas fa-search"></i></button>
                                </div>
                                <div class="product-sorting">
                                    <select id="gig_category">
                                        <option value="">{{__('All Category')}}</option>
                                        @foreach($all_category as $category)
                                        <option value="{{$category->id}}" @if($selected_category == $category->id) selected @endif >{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <select id="gig_sorting_select">
                                        <option value="default" @if($selected_order == '' || $selected_order == 'default') selected @endif >{{__('Newest Gig')}}</option>
                                        <option value="old" @if($selected_order == 'old') selected @endif >{{__('Oldest Gig')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(count($all_gigs) > 0)
                        @foreach($all_gigs as $data)
                            <div class="col-lg-4 col-md-6">
                                <div class="single-gig-item">
                                    <div class="thumb">
                                        {!! render_image_markup_by_attachment_id($data->image,'','grid') !!}
                                        <div class="price-wrap">
                                            {{__("Start From").' '.gig_start_price($data->id)}}
                                        </div>
                                        <a href="{{route('frontend.gigs.single',$data->slug)}}" class="order-btn"><i class="fas fa-shopping-cart"></i></a>
                                    </div>
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('frontend.gigs.single',$data->slug)}}">{{$data->title}}</a></h4>
                                        <p>{!! Str::words(strip_tags($data->description),20) !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                            <div class="col-lg-12">
                                <div class="alert alert-warning">{{__('No Gig Found')}}</div>
                            </div>
                        @endif
                        <div class="col-lg-12 text-center">
                            <nav class="pagination-wrapper " aria-label="Page navigation ">
                                {{$all_gigs->links()}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <form id="product_search_form" class="d-none"  action="{{route('frontend.gigs')}}" method="get">
        <input type="hidden" id="search_query" name="q" value="{{$search_term}}">
        <input type="hidden" name="cat_id" id="category_id" value="{{$selected_category}}">
        <input type="hidden" name="orderby" id="orderby" value="{{$selected_order ? $selected_order : 'default'}}">
        <button id="product_hidden_form_submit_button" type="submit"></button>
    </form>
@endsection
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        (function () {
            "use strict";
            var searchFormSubmit = $('#product_hidden_form_submit_button');
            //search form trigger
            $(document).on('click','#product_search_btn',function (e) {
                e.preventDefault();
                var searchTerms = $('#search_term').val();
                $('#search_query').val(searchTerms)
                searchFormSubmit.trigger('click');
            });
            $(document).on('change','#gig_sorting_select',function (e) {
                var sortVal = $('#gig_sorting_select').val();
                $('#orderby').val(sortVal);
                searchFormSubmit.trigger('click');
            });
            $(document).on('change','#gig_category',function (e) {
                e.preventDefault();
                $('#category_id').val($(this).val());
                searchFormSubmit.trigger('click');
            });

        })(jQuery);
    </script>
@endsection


