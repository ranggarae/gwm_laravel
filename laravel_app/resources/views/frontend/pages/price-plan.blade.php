@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('price_plan_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('price_plan_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('breadcrumb')
    <li>{{get_static_option('price_plan_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('price_plan_page_'.$user_select_lang_slug.'_meta_tags')}}">
    <meta name="tags" content="{{get_static_option('price_plan_page_'.$user_select_lang_slug.'_meta_description')}}">
@endsection
@section('content')
        <section class="price-plan-page-content  padding-top-110 padding-bottom-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-title desktop-center margin-bottom-55">
                            <h2 class="title">{{get_static_option('price_plan_page_'.$user_select_lang_slug.'_section_title')}}</h2>
                            <p>{{get_static_option('price_plan_page_'.$user_select_lang_slug.'_section_description')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($all_price_plan as $data)
                        <div class="col-lg-4">
                            <div class="pricing-table-15 margin-bottom-30">
                                <div class="price-header">
                                    <div class="icon"><i class="{{$data->icon}}"></i></div>
                                    <h3 class="title">{{$data->title}}</h3>
                                </div>

                                <div class="price">
                                    <span class="dollar"></span>{{amount_with_currency_symbol($data->price)}}<span class="month">{{$data->type}}</span>
                                </div>
                                <div class="price-body">
                                    <ul>
                                        @php
                                            $features = explode(';',$data->features);
                                        @endphp
                                        @foreach($features as $item)
                                            <li>{{$item}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="price-footer">
                                    @if(!empty($data->url_status))
                                        <a class="order-btn" href="{{route('frontend.plan.order',$data->id)}}">{{$data->btn_text}}</a>
                                    @else
                                        <a class="order-btn" href="{{$data->btn_url}}">{{$data->btn_text}}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-lg-12">
                        <div class="price-plan-pagination text-center">
                            {{$all_price_plan->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
