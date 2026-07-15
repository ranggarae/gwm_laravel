@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('donor_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('donor_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('donor_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('donor_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('breadcrumb')
    <li>{{get_static_option('donor_page_'.$user_select_lang_slug.'_name')}}</li>
@endsection
@section('content')
    <section class="donor-list padding-bottom-90 padding-top-120">
        <div class="container">
            <div class="row">
                @if(count($all_donation_log) > 0)
                @foreach($all_donation_log as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="single-donor-info margin-bottom-40 donor-list-page">
                        <div class="icon-wrap">
                            <img src="{{asset('assets/frontend/icons/donation.svg')}}" alt="">
                        </div>
                        <div class="content">
                            <h4 class="title">@if($data->donation_type == 'on') {{__('Anonymous')}} @else {{$data->name}} @endif</h4>
                            <div class="bottom-content">
                                <span class="amount">{{amount_with_currency_symbol($data->amount)}}</span>
                                <span class="dated-time">{{date_format($data->created_at,'d M y h:m:s')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="col-lg-12">
                        <div class="alert alert-warning">{{__('No Donor Found')}}</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
