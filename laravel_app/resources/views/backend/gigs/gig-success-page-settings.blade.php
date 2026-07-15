@extends('backend.admin-master')
@section('site-title')
    {{__('Gig Success Page Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Gig Success Page Settings")}}</h4>
                        <form action="{{route('admin.gigs.success.page.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                        <a class="nav-item nav-link @if($key == 0) active @endif" id="nav-home-tab" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_title">{{__('Title')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_title')}}" >
                                            <small class="info-help">{{__('[id] will be replaced by order id')}}</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_name_title">{{__('Gig Name Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_name_title"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_name_title')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_order_date_text">{{__('Order Date Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_order_date_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_order_date_text')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_order_delivery_date_text">{{__('Order Delivery Date Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_order_delivery_date_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_order_delivery_date_text')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_total_revisions_text">{{__('Total Revision Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_total_revisions_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_total_revisions_text')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_payment_gateway_text">{{__('Payment Gateway Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_payment_gateway_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_payment_gateway_text')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_payment_status_text">{{__('Payment Status Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_payment_status_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_payment_status_text')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_order_success_page_{{$lang->slug}}_gig_ordered_plan_text">{{__('Ordered Plan Text')}}</label>
                                            <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_ordered_plan_text"  class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_ordered_plan_text')}}" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
