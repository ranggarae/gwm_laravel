@extends('backend.admin-master')
@section('site-title')
    {{__('Payment Settings')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Payment Gateway Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        <form action="{{route('admin.general.payment.settings')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="site_global_currency">{{__('Site Global Currency')}}</label>
                                        @php  $all_currency = [
        'USD' => '$','EUR' => '€','INR' => '₹','IDR' => 'Rp','AUD' => 'A$','SGD' => 'S$','JPY' => '¥','GBP' => '£','MYR' => 'RM','PHP' => '₱','THB' => '฿','KRW' => '₩','NGN' => '₦','GHS' => 'GH₵','BRL' => 'R$',
        'BIF' => 'FBu','CAD' => 'C$','CDF' => 'FC','CVE' => 'Esc','GHP' => 'GH₵','GMD' => 'D','GNF' => 'FG','KES' => 'K','LRD' => 'L$','MWK' => 'MK','MZN' => 'MT','RWF' => 'R₣','SLL' => 'Le','STD' => 'Db','TZS' => 'TSh','UGX' => 'USh','XAF' => 'FCFA','XOF' => 'CFA','ZMK' => 'ZK','ZMW' => 'ZK','ZWD' => 'Z$',
        'AED' => 'د.إ','AFN' => '؋','ALL' => 'L','AMD' => '֏','ANG' => 'NAf','AOA' => 'Kz','ARS' => '$','AWG' => 'ƒ','AZN' => '₼','BAM' => 'KM','BBD' => 'Bds$','BDT' => '৳','BGN' => 'Лв','BMD' => '$','BND' => 'B$','BOB' => 'Bs','BSD'=>'B$','BWP' => 'P','BZD' => '$',
        'CHF' => 'CHf','CNY' => '¥','CLP' => '$','COP' => '$','CRC' => '₡','CZK' => 'Kč','DJF' => 'Fdj','DKK' => 'Kr','DOP' => 'RD$','DZD' => 'دج','EGP' => 'E£','ETB' => 'ብር','FJD' => 'FJ$','FKP' => '£','GEL' => 'ლ','GIP' => '£','GTQ' => 'Q',
        'GYD' => 'G$','HKD' => 'HK$','HNL' => 'L','HRK' => 'kn','HTG' => 'G','HUF' => 'Ft','ILS' => '₪','ISK' => 'kr','JMD' => '$','KGS' => 'Лв','KHR' => '៛','KMF' => 'CF','KYD' => '$','KZT' => '₸','LAK' => '₭','LBP'=> 'ل.ل.','LKR' => 'ரூ','LSL' => 'L',
        'MAD' => 'MAD','MDL' =>'L','MGA' => 'Ar','MKD' => 'Ден','MMK' => 'K','MNT' => '₮','MOP' => 'MOP$','MRO' => 'MRU','MUR' => '₨','MVR' => 'Rf','MXN' => 'Mex$','NAD' => 'N$','NIO' => 'C$','NOK' => 'kr','NPR' => 'रू','NZD' => '$','PAB' => 'B/.','PEN' => 'S/','PGK' => 'K',
        'PKR' => '₨','PLN' => 'zł','PYG' => '₲','QAR' => 'QR','RON' => 'lei','RSD' => 'din','RUB' => '₽','SAR' => 'SR','SBD' => 'Si$','SCR' => 'SR','SEK' => 'kr','SHP' => '£','SOS' => 'Sh.so.','SRD' => '$','SZL' => 'E','TJS' => 'ЅM',
        'TRY' => '₺','TTD' => 'TT$','TWD' => 'NT$','UAH' => '₴','UYU' => '$U','UZS' => 'so\'m','VND' => '₫','VUV' => 'VT','WST' => 'WS$','XCD' => '$','XPF' => '₣','YER' => '﷼','ZAR' => 'R','ZMW' => 'ZK'
    ];
                                        @endphp
                                        <select name="site_global_currency" class="form-control"
                                                id="site_global_currency">
                                            @foreach($all_currency as $cur => $symbol)
                                                <option value="{{$cur}}"
                                                        @if(get_static_option('site_global_currency') == $cur) selected @endif>{{$cur.' ( '.$symbol.' )'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="site_currency_symbol_position">{{__('Currency Symbol Position')}}</label>
                                        @php $all_currency_position = ['left','right']; @endphp
                                        <select name="site_currency_symbol_position" class="form-control"
                                                id="site_currency_symbol_position">
                                            @foreach($all_currency_position as $cur)
                                                <option value="{{$cur}}"
                                                        @if(get_static_option('site_currency_symbol_position') == $cur) selected @endif>{{ucwords($cur)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="site_default_payment_gateway">{{__('Default Payment Gateway')}}</label>
                                        <select name="site_default_payment_gateway" class="form-control" >
                                            @php
                                                 $all_gateways = ['paypal','manual_payment','midtrans','xendit','tripay'];
                                            @endphp
                                            @foreach($all_gateways as $gateway)
                                                @if(!empty(get_static_option($gateway.'_gateway')))
                                                <option value="{{$gateway}}" @if(get_static_option('site_default_payment_gateway') == $gateway) selected @endif>{{ucwords(str_replace('_',' ',$gateway))}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @php $global_currency = get_static_option('site_global_currency');@endphp
                                    @if($global_currency != 'USD')
                                    <div class="form-group">
                                        <label for="site_{{strtolower($global_currency)}}_to_usd_exchange_rate">{{__($global_currency.' to USD Exchange Rate')}}</label>
                                        <input type="text" class="form-control"
                                               name="site_{{strtolower($global_currency)}}_to_usd_exchange_rate"
                                               value="{{get_static_option('site_'.$global_currency.'_to_usd_exchange_rate')}}">
                                        <span class="info-text">{{__('enter '.$global_currency.' to USD exchange rate. eg: 1'.$global_currency.' = ? USD')}}</span>
                                    </div>
                                    @endif


                                    <div class="accordion-wrapper">
                                        <div id="accordion-payment">
                                            <div class="card">
                                                <div class="card-header" id="cash_on_delivery_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#pcash_on_delivery_settings_content" aria-expanded="false" >
                                                            <span class="page-title"> {{__('Cash On Delivery Settings (only for product order)')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="pcash_on_delivery_settings_content" class="collapse"  data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="cash_on_delivery_gateway"><strong>{{__('Enable Cash On Delivery')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="cash_on_delivery_gateway"  @if(!empty(get_static_option('cash_on_delivery_gateway'))) checked @endif id="cash_on_delivery_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Cash On Delivery Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paypal_img = get_attachment_image_by_id(get_static_option('cash_on_delivery_preview_logo'),null,true);
                                                                        $paypal_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paypal_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$paypal_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paypal_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="cash_on_delivery_preview_logo" name="cash_on_delivery_preview_logo" value="{{get_static_option('cash_on_delivery_preview_logo')}}">
                                                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                                                    {{__($paypal_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="paypal_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#paypal_settings_content"
                                                                aria-expanded="true">
                                                            <span class="page-title"> {{__('Paypal Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="paypal_settings_content" class="collapse show"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="payment-notice alert alert-warning">
                                                            <p>{{__("Available Currency For Paypal is, ['AUD','BRL','CAD','CNY','CZK','DKK','EUR','HKD','HUF','INR','ILS','JPY','MYR','MXN','TWD','NZD','NOK','PHP','PLN','GBP','RUB','SGD','SEK','CHF','THB','USD']")}}</p>
                                                            <p>{{__('if your currency is not available in paypal, it will convert you currency value to USD value based on your currency exchange rate.')}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paypal_gateway"><strong>{{__('Enable Paypal')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="paypal_gateway"
                                                                       @if(!empty(get_static_option('paypal_gateway'))) checked
                                                                       @endif id="paypal_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paypal_test_mode"><strong>{{__('Enable Test Mode For Paypal')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="paypal_test_mode"
                                                                       @if(!empty(get_static_option('paypal_test_mode'))) checked
                                                                       @endif >
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Paypal Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paypal_img = get_attachment_image_by_id(get_static_option('paypal_preview_logo'),null,true);
                                                                        $paypal_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paypal_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$paypal_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paypal_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="paypal_preview_logo"
                                                                       name="paypal_preview_logo"
                                                                       value="{{get_static_option('paypal_preview_logo')}}">
                                                                <button type="button"
                                                                        class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select Paypal Image"
                                                                        data-modaltitle="Upload Paypal Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($paypal_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="paypal_business_email">{{__('Paypal Business Email')}}</label>
                                                            <input type="text" name="paypal_business_email"
                                                                   id="paypal_business_email" class="form-control"
                                                                   value="{{get_static_option('paypal_business_email')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="midtrans_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#midtrans_settings_content"
                                                                aria-expanded="false">
                                                            <span class="page-title"> {{__('Midtrans Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="midtrans_settings_content" class="collapse"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="payment-notice alert alert-warning">
                                                                <p>{{__("Available Currency For Midtrans is IDR")}}</p>
                                                            </div>
                                                            <label for="midtrans_gateway"><strong>{{__('Enable Midtrans')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="midtrans_gateway"
                                                                       @if(!empty(get_static_option('midtrans_gateway'))) checked
                                                                       @endif id="midtrans_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Midtrans Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $midtrans_img = get_attachment_image_by_id(get_static_option('midtrans_preview_logo'),null,true);
                                                                        $midtrans_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($midtrans_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$midtrans_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $midtrans_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="midtrans_preview_logo"
                                                                       name="midtrans_preview_logo"
                                                                       value="{{get_static_option('midtrans_preview_logo')}}">
                                                                <button type="button"
                                                                        class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select Midtrans Image"
                                                                        data-modaltitle="Upload Midtrans Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($midtrans_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="midtrans_server_key">{{__('Midtrans Server Key')}}</label>
                                                            <input type="text" name="midtrans_server_key"
                                                                   id="midtrans_server_key" class="form-control"
                                                                   value="{{get_static_option('midtrans_server_key')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="midtrans_client_key">{{__('Midtrans Client Key')}}</label>
                                                            <input type="text" name="midtrans_client_key"
                                                                   id="midtrans_client_key" class="form-control"
                                                                   value="{{get_static_option('midtrans_client_key')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="midtrans_env">{{__('Midtrans Environment (production/sandbox)')}}</label>
                                                            <input type="text" name="midtrans_env"
                                                                   id="midtrans_env" class="form-control"
                                                                   value="{{get_static_option('midtrans_env')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="bri_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#bri_settings_content"
                                                                aria-expanded="false">
                                                            <span class="page-title"> {{__('BRI SNAP Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="bri_settings_content" class="collapse"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="payment-notice alert alert-warning">
                                                                <p>{{__("Available Currency For BRI SNAP is IDR")}}</p>
                                                            </div>
                                                            <label for="bri_gateway"><strong>{{__('Enable BRI SNAP')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="bri_gateway"
                                                                       @if(!empty(get_static_option('bri_gateway'))) checked
                                                                       @endif id="bri_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('BRI Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $bri_img = get_attachment_image_by_id(get_static_option('bri_preview_logo'),null,true);
                                                                        $bri_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($bri_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$bri_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $bri_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="bri_preview_logo"
                                                                       name="bri_preview_logo"
                                                                       value="{{get_static_option('bri_preview_logo')}}">
                                                                <button type="button" class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select BRI Image"
                                                                        data-modaltitle="Upload BRI Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($bri_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bri_client_id">{{__('BRI Client ID')}}</label>
                                                            <input type="text" name="bri_client_id"
                                                                   id="bri_client_id" class="form-control"
                                                                   value="{{get_static_option('bri_client_id')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bri_client_secret">{{__('BRI Client Secret')}}</label>
                                                            <input type="text" name="bri_client_secret"
                                                                   id="bri_client_secret" class="form-control"
                                                                   value="{{get_static_option('bri_client_secret')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bri_env">{{__('BRI Environment (production/sandbox)')}}</label>
                                                            <input type="text" name="bri_env"
                                                                   id="bri_env" class="form-control"
                                                                   value="{{get_static_option('bri_env')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="xendit_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#xendit_settings_content"
                                                                aria-expanded="false">
                                                            <span class="page-title"> {{__('Xendit Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="xendit_settings_content" class="collapse"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="payment-notice alert alert-warning">
                                                                <p>{{__("Available Currency For Xendit is IDR")}}</p>
                                                            </div>
                                                            <label for="xendit_gateway"><strong>{{__('Enable Xendit')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="xendit_gateway"
                                                                       @if(!empty(get_static_option('xendit_gateway'))) checked
                                                                       @endif id="xendit_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Xendit Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $xendit_img = get_attachment_image_by_id(get_static_option('xendit_preview_logo'),null,true);
                                                                        $xendit_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($xendit_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$xendit_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $xendit_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="xendit_preview_logo"
                                                                       name="xendit_preview_logo"
                                                                       value="{{get_static_option('xendit_preview_logo')}}">
                                                                <button type="button"
                                                                        class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select Xendit Image"
                                                                        data-modaltitle="Upload Xendit Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($xendit_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="xendit_secret_key">{{__('Xendit Secret API Key')}}</label>
                                                            <input type="text" name="xendit_secret_key"
                                                                   id="xendit_secret_key" class="form-control"
                                                                   value="{{get_static_option('xendit_secret_key')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="xendit_env">{{__('Xendit Environment (production/test)')}}</label>
                                                            <input type="text" name="xendit_env"
                                                                   id="xendit_env" class="form-control"
                                                                   value="{{get_static_option('xendit_env')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="tripay_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#tripay_settings_content"
                                                                aria-expanded="false">
                                                            <span class="page-title"> {{__('Tripay Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="tripay_settings_content" class="collapse"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <div class="payment-notice alert alert-warning">
                                                                <p>{{__("Available Currency For Tripay is IDR")}}</p>
                                                            </div>
                                                            <label for="tripay_gateway"><strong>{{__('Enable Tripay')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="tripay_gateway"
                                                                       @if(!empty(get_static_option('tripay_gateway'))) checked
                                                                       @endif id="tripay_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Tripay Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $tripay_img = get_attachment_image_by_id(get_static_option('tripay_preview_logo'),null,true);
                                                                        $tripay_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($tripay_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$tripay_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $tripay_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="tripay_preview_logo"
                                                                       name="tripay_preview_logo"
                                                                       value="{{get_static_option('tripay_preview_logo')}}">
                                                                <button type="button"
                                                                        class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select Tripay Image"
                                                                        data-modaltitle="Upload Tripay Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($tripay_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tripay_api_key">{{__('Tripay API Key')}}</label>
                                                            <input type="text" name="tripay_api_key"
                                                                   id="tripay_api_key" class="form-control"
                                                                   value="{{get_static_option('tripay_api_key')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tripay_private_key">{{__('Tripay Private Key')}}</label>
                                                            <input type="text" name="tripay_private_key"
                                                                   id="tripay_private_key" class="form-control"
                                                                   value="{{get_static_option('tripay_private_key')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tripay_merchant_code">{{__('Tripay Merchant Code')}}</label>
                                                            <input type="text" name="tripay_merchant_code"
                                                                   id="tripay_merchant_code" class="form-control"
                                                                   value="{{get_static_option('tripay_merchant_code')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tripay_env">{{__('Tripay Environment (production/sandbox)')}}</label>
                                                            <input type="text" name="tripay_env"
                                                                   id="tripay_env" class="form-control"
                                                                   value="{{get_static_option('tripay_env')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="manual_payment_settings">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button"
                                                                data-toggle="collapse"
                                                                data-target="#manual_payment_settings_content"
                                                                aria-expanded="false">
                                                            <span class="page-title"> {{__('Manual Payment Settings')}}</span>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="manual_payment_settings_content" class="collapse"
                                                     data-parent="#accordion-payment">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="manual_payment_gateway"><strong>{{__('Enable/Disable Manual Payment')}}</strong></label>
                                                            <label class="switch">
                                                                <input type="checkbox" name="manual_payment_gateway"
                                                                       @if(!empty(get_static_option('manual_payment_gateway'))) checked
                                                                       @endif id="manual_payment_gateway">
                                                                <span class="slider onff"></span>
                                                            </label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_logo"><strong>{{__('Manual Payment Logo')}}</strong></label>
                                                            <div class="media-upload-btn-wrapper">
                                                                <div class="img-wrap">
                                                                    @php
                                                                        $paytm_img = get_attachment_image_by_id(get_static_option('manual_payment_preview_logo'),null,false);
                                                                        $paytm_image_btn_label = 'Upload Image';
                                                                    @endphp
                                                                    @if (!empty($paytm_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb"
                                                                                         src="{{$paytm_img['img_url']}}"
                                                                                         alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @php  $paytm_image_btn_label = 'Change Image'; @endphp
                                                                    @endif
                                                                </div>
                                                                <input type="hidden" id="manual_payment_preview_logo"
                                                                       name="manual_payment_preview_logo"
                                                                       value="{{get_static_option('manual_payment_preview_logo')}}">
                                                                <button type="button"
                                                                        class="btn btn-info media_upload_form_btn"
                                                                        data-btntitle="Select Manual Payment Logo Image"
                                                                        data-modaltitle="Upload Manual Payment Logo Image"
                                                                        data-toggle="modal"
                                                                        data-target="#media_upload_modal">
                                                                    {{__($paytm_image_btn_label)}}
                                                                </button>
                                                            </div>
                                                            <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png. Recommended image size 160x50')}}</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_manual_payment_name">{{__('Manual Payment Name')}}</label>
                                                            <input type="text" name="site_manual_payment_name"
                                                                   id="site_manual_payment_name"
                                                                   value="{{get_static_option('site_manual_payment_name')}}"
                                                                   class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="site_manual_payment_description">{{__('Manual Payment Description')}}</label>
                                                            <input type="hidden" name="site_manual_payment_description" value="{{get_static_option('site_manual_payment_description')}}">
                                                            <div class="summernote" data-content='{{get_static_option('site_manual_payment_description')}}'></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        $(document).ready(function ($) {

            $('.summernote').summernote({
                height: 200,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }
        });

    </script>
@endsection
