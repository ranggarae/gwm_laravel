@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Order Success')}}
@endsection
@section('breadcrumb')
    <li><a href="{{route('frontend.gigs')}}">{{get_static_option('gig_page_' . $user_select_lang_slug . '_name')}}</a></li>
    <li>{{__('Order Success')}}</li>
@endsection
@section('content')
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="gig-order-success-page-wrap">
                        <div class="description">
                            <h4>
                                @php
                                $gig_title = get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_title');
                                @endphp
                                {{str_replace('[id]','#'.$gig_order_details->id,$gig_title)}}
                            </h4>
                        </div>
                        <div class="gigs-info-wrap">
                            <div class="billing-info-wrap">
                                <ul>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_name_title')}}:</strong> {{get_gig_name($gig_order_details->gig_id)}}</li>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_order_date_text')}}:</strong> {{date_format($gig_order_details->created_at,'d M Y')}}</li>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_order_delivery_date_text')}}:</strong> {{get_future_date($gig_order_details->created_at,$gig_order_details->selected_plan_delivery_days)}}</li>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_total_revisions_text')}}:</strong> {{$gig_order_details->selected_plan_revisions}} {{__('Time Revisions')}}</li>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_payment_gateway_text')}}:</strong> {{ucwords(str_replace('_',' ',$gig_order_details->selected_payment_gateway))}}</li>
                                    <li><strong>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_payment_status_text')}}:</strong> {{$gig_order_details->payment_status}}</li>
                                </ul>
                            </div>
                            <div class="gig-price-plan order-page">
                                <h2>{{get_static_option('gig_order_success_page_'.$user_select_lang_slug.'_gig_ordered_plan_text')}}</h2>
                                <h4 class="title">{{$gig_order_details->selected_plan_title}}</h4>
                                <div class="price-wrap">
                                    {{amount_with_currency_symbol($gig_order_details->selected_plan_price)}}
                                </div>
                                @php
                                    $gig_details = \App\Gig::find($gig_order_details->gig_id);
                                    $all_plan_features = !empty($gig_details->features) ? unserialize($gig_details->features) : [];
                                    $all_plan_description = !empty($gig_details->plan_description) ? unserialize($gig_details->plan_description) : [];
                                    $selected_plan_features = explode("\n",$all_plan_features[$gig_order_details->selected_plan_index]);
                                @endphp

                                <div class="description">
                                    <p>{{$all_plan_description[$gig_order_details->selected_plan_index]}}</p>
                                </div>

                                <ul class="feature-list">
                                    @foreach($selected_plan_features as $item)
                                        <li>{{$item}}</li>
                                    @endforeach
                                </ul>

                                <div class="revision-wrapper">
                                    <span class="delivery-time"><i class="far fa-clock"></i> {{$gig_order_details->selected_plan_delivery_days}} {{__('Days Delivery')}}</span>
                                    <span class="revisions"><i class="fas fa-sync"></i> {{$gig_order_details->selected_plan_revisions}} {{__('Time Revisions')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrapper margin-top-40">
                            <a href="{{route('user.home')}}" class="boxed-btn">{{__('Go to Dashboard')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
