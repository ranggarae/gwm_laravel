@extends('frontend.frontend-page-master')
@section('page-title')
    {{get_static_option('gig_page_' . $user_select_lang_slug . '_name')}} {{__('Order Payment Not Success')}}
@endsection
@section('breadcrumb')
    <li><a href="{{route('frontend.gigs')}}">{{get_static_option('gig_page_' . $user_select_lang_slug . '_name')}}</a></li>
    <li>{{__('Payment not success')}}</li>
@endsection
@section('content')
    <div class="error-page-content padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-success-area">
                        <h1 class="title">{{get_static_option('gig_order_cancel_page_' . $user_select_lang_slug . '_title')}}</h1>
                        <p>{{get_static_option('gig_order_cancel_page_' . $user_select_lang_slug . '_description')}}</p>
                        <div class="btn-wrapper">
                            <a href="{{url('/')}}" class="boxed-btn">{{__('Back To Home')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
