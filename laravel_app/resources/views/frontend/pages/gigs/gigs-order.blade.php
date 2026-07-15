@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}} {{__('Order')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('gig_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('breadcrumb')
    <li><a href="{{route('frontend.gigs')}}">{{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}}</a></li>
    <li>{{get_static_option('gig_page_'.$user_select_lang_slug.'_name')}} {{__('Order')}}</li>
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if(!auth()->check())
                        <div class="login-form gig-page">
                            <h4>{{__('login to continue order')}}</h4>
                            <form action="{{route('user.login')}}" method="post" enctype="multipart/form-data" class="account-form" id="login_form_order_page">
                                @csrf
                                <div class="error-wrap"></div>
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="{{__('Username')}}">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                </div>
                                <div class="form-group btn-wrapper">
                                    <button type="submit" id="login_btn" class="submit-btn">{{__('Login')}}</button>
                                </div>
                                <div class="row mb-4 rmber-area">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                            <label class="custom-control-label" for="remember">{{__('Remember Me')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a class="d-block" href="{{route('user.register')}}">{{__('Haven\'t any account?')}}</a>
                                        <a href="{{route('user.forget.password')}}">{{__('Forgot Password?')}}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form action="{{route('frontend.gigs.order.new')}}" method="post" enctype="multipart/form-data" class="gig_order_form">
                            @csrf
                            <input type="hidden" name="gig_id" value="{{$gig_details->id}}">
                            <input type="hidden" name="selected_plan_index" value="{{$index_id}}">
                            <input type="hidden" name="selected_plan_revisions" value="{{$plan_details['revisions']}}">
                            <input type="hidden" name="selected_plan_delivery_days" value="{{ $plan_details['delivery_time']}}">
                            <input type="hidden" name="selected_plan_price" value="{{$plan_details['price']}}">
                            <input type="hidden" name="selected_plan_title" value="{{$plan_details['title']}}">
                            <div class="form-group">
                                <label for="full_name">{{__('Full Name')}}</label>
                                <input type="text" class="form-control" name="full_name" value="{{auth()->user()->name}}">
                            </div>
                            <div class="form-group">
                                <label for="email">{{__('Email')}}</label>
                                <input type="text" class="form-control" name="email" value="{{auth()->user()->email}}">
                            </div>
                            <div class="form-group">
                                <label for="file" class="d-block">{{__('File')}}</label>
                                <input type="file" accept=".zip" name="file">
                                <small class="help-text d-block text-danger">{{__('only zip file is allowed, max: 250mb allowed')}}</small>
                            </div>
                            <div class="form-group">
                                <label for="message">{{__('Message')}}</label>
                                <textarea name="message" class="form-control" cols="10" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="additional_note">{{__('Addition Note')}}</label>
                                <textarea name="additional_note" class="form-control" cols="10" rows="5"></textarea>
                            </div>
                            {!! render_payment_gateway_for_form() !!}
                            @if(!empty(get_static_option('manual_payment_gateway')))
                                <div class="form-group manual_payment_transaction_field">
                                    <div class="label">{{__('Transaction ID')}}</div>
                                    <input type="text" name="transaction_id" placeholder="{{__('transaction')}}" class="form-control">
                                    <span class="help-info">{!! get_manual_payment_description() !!}</span>
                                </div>
                            @endif
                            <button type="submit" class="boxed-btn">{{__('Place Order')}}</button>
                        </form>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="gigs-info-wrap">
                        <div class="gig-price-plan order-page">
                            <h4 class="title">{{strtolower($plan_details['title'])}}</h4>
                            <div class="price-wrap">
                                {{amount_with_currency_symbol($plan_details['price'])}}
                            </div>
                            <div class="description">
                                <p>{{$plan_details['description']}}</p>
                            </div>
                            <ul class="feature-list">
                                @php $featuers = !empty($plan_details['features']) ? explode("\n",$plan_details['features']) : []; @endphp
                                @foreach($featuers as $item)
                                <li>{{$item}}</li>
                                @endforeach
                            </ul>
                            <div class="revision-wrapper">
                                <span class="delivery-time"><i class="far fa-clock"></i> {{$plan_details['delivery_time']}} {{__('Days Delivery')}}</span>
                                <span class="revisions"><i class="fas fa-sync"></i> {{$plan_details['revisions']}} {{__('Time Revisions')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        (function () {
            "use strict";

            $(document).on('click', '#login_btn', function (e) {
                e.preventDefault();
                var formContainer = $('#login_form_order_page');
                var el = $(this);
                var username = formContainer.find('input[name="username"]').val();
                var password = formContainer.find('input[name="password"]').val();
                var remember = formContainer.find('input[name="remember"]').val();

                el.text('Please Wait');

                $.ajax({
                    type: 'post',
                    url: "{{route('user.ajax.login')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        username : username,
                        password : password,
                        remember : remember,
                    },
                    success: function (data){
                        if(data.status == 'invalid'){
                            el.text('Login')
                            formContainer.find('.error-wrap').html('<div class="alert alert-danger">'+data.msg+'</div>');
                        }else{
                            formContainer.find('.error-wrap').html('');
                            el.text('Login Success.. Redirecting ..');
                            location.reload();
                        }
                    },
                    error: function (data){
                        var response = data.responseJSON.errors
                        formContainer.find('.error-wrap').html('<ul class="alert alert-danger"></ul>');
                        $.each(response,function (value,index){
                            formContainer.find('.error-wrap ul').append('<li>'+value+'</li>');
                        });
                        el.text('Login');
                    }
                });
            });

            $(document).on('click','.payment-gateway-wrapper > ul > li',function (e) {
                e.preventDefault();
                var gateway = $(this).data('gateway');
                $(this).addClass('selected').siblings().removeClass('selected');
                $('input[name="selected_payment_gateway"]').val(gateway);
                if(gateway == 'manual_payment'){
                    $('.manual_payment_transaction_field').addClass('show');
                }else{
                    $('.manual_payment_transaction_field').removeClass('show');
                }
            });

        })(jQuery);
    </script>
@endsection


