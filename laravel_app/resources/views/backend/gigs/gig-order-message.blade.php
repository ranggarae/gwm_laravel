@extends('backend.admin-master')
@section('site-title')
    {{__('Gig order message')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="gig-chat-message-heading">
                            <div class="header-wrap">
                                <h4 class="header-title">{{__('Gig order message')}}</h4>
                                <a class="btn btn-primary btn-xs" href="{{route('admin.gigs.orders')}}">{{__('All Gig Orders')}}</a>
                            </div>
                            <div class="gig-order-info">
                                <ul>
                                    <li><strong>{{__('Order ID:')}}</strong> #{{$gig_details->id}}</li>
                                    <li><strong>{{__('Gig Name:')}}</strong> {{get_gig_name($gig_details->gig_id)}}</li>
                                    <li><strong>{{__('Package Name:')}}</strong> {{$gig_details->selected_plan_title}}</li>
                                    <li><strong>{{__('Package Price:')}}</strong> {{amount_with_currency_symbol($gig_details->selected_plan_price)}}</li>
                                    <li><strong>{{__('Revisions:')}}</strong> <span class="alert-success">{{$gig_details->selected_plan_revisions.' '.__('Time Revisions')}}</span></li>
                                    <li><strong>{{__('Payment Gateway:')}}</strong> {{str_replace('_',' ',$gig_details->selected_payment_gateway)}}</li>
                                    <li><strong>{{__('Payment Status:')}}</strong> <span class="@if($gig_details->payment_status == 'complete') alert-success @else alert-warning @endif">{{ucwords($gig_details->payment_status)}}</span></li>
                                    <li><strong>{{__('Order Status:')}}</strong> {{ucwords(str_replace('_',' ',$gig_details->order_status))}}</li>
                                    <li><strong>{{__('Delivery Date:')}}</strong> <span class="alert-danger">{{get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)}}</span></li>
                                </ul>
                            </div>
                            <div class="delivery-time-countdown-wrap">
                                <h2 class="title">{{__("Delivery time countdown")}}</h2>
                                <div class="countdown-wrapper">
                                    <div id="countdown"></div>
                                </div>
                            </div>
                            <div class="gig-message-start-wrap">
                                <h2 class="title">{{__('All Conversation')}}</h2>

                                <div class="single-message-item customer">
                                    <div class="top-part">
                                        <div class="thumb">
                                            <span class="title">{{substr(get_username_by_id($gig_details->user_id),0,1)}}</span>
                                            <i class="fas fa-envelope" title="{{__('Notified by email')}}"></i>
                                        </div>
                                        <div class="content">
                                            <h6 class="title">{{get_username_by_id($gig_details->user_id)}}</h6>
                                            <span class="time">{{date_format($gig_details->created_at,'d M Y H:i:s')}}</span>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="span_title">{{__('Message')}}</span>
                                        <p>{{$gig_details->message}}</p>
                                        <span class="span_title">{{__('Additional Note')}}</span>
                                        <p>{{$gig_details->additional_note}}</p>
                                        @if(file_exists('assets/uploads/gig-files/'.$gig_details->file))
                                            <span class="span_title">{{__('Attached File')}}</span>
                                            <a href="{{asset('assets/uploads/gig-files/'.$gig_details->file)}}" download class="anchor-btn">{{$gig_details->file}}</a>
                                        @endif
                                    </div>
                                </div>

                                @if(!empty($gig_message))
                                    <div class="all-message-wrap @if($q == 'all') msg-row-reverse @endif">
                                        @if($q == 'all' && count($gig_message) > 1)
                                            <form action="" method="get">
                                                <input type="hidden" value="all" name="q">
                                                <button class="load_all_conversation" type="submit">{{__('load all message')}}</button>
                                            </form>
                                        @endif
                                        @foreach($gig_message as $msg)
                                            <div class="single-message-item @if($msg->user_type == 'customer') customer @endif">
                                                <div class="top-part">
                                                    <div class="thumb">
                                                    <span class="title">
                                                         @if($msg->user_type == 'customer')
                                                            {{substr(get_username_by_id($msg->user_id),0,1)}}
                                                        @else
                                                            {{substr(get_username_by_admin_id($msg->user_id),0,1)}}
                                                        @endif
                                                    </span>
                                                        @if($msg->notify_mail == 'yes')
                                                            <i class="fas fa-envelope" title="{{__('Notified by email')}}"></i>
                                                        @endif
                                                    </div>
                                                    <div class="content">
                                                        <h6 class="title">
                                                            @if($msg->user_type == 'customer')
                                                                {{get_username_by_id($msg->user_id)}}
                                                            @else
                                                                {{get_username_by_admin_id($msg->user_id)}}
                                                            @endif
                                                        </h6>
                                                        <span class="time">{{date_format($msg->created_at,'d M Y H:i:s')}} | {{$msg->created_at->diffForHumans()}}</span>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="message-content">
                                                        {!! $msg->message !!}
                                                    </div>
                                                    @if(file_exists('assets/uploads/gig-files/'.$msg->file))
                                                        <a href="{{asset('assets/uploads/gig-files/'.$msg->file)}}" download class="anchor-btn">{{$msg->file}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="reply-message-wrap ">
                                <h5 class="title">{{__('Replay To Message')}}</h5>
                                @include('backend.partials.message')
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{route('admin.gigs.orders.message.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$gig_details->id}}" name="gig_order_id">
                                    <input type="hidden" value="admin" name="user_type">
                                    <div class="form-group">
                                        <label for="">{{__('Message')}}</label>
                                        <textarea name="message" class="form-control" style="display: none;" cols="30" rows="5" ></textarea>
                                        <div class="summernote"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">{{__('File')}}</label>
                                        <input type="file" name="file" accept="zip">
                                        <small class="info-text d-block text-danger">{{__('max file size 200mb, only zip file is allowed')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="send_notify_mail" id="send_notify_mail">
                                        <label for="send_notify_mail">{{__('Notify Via Mail')}}</label>
                                    </div>
                                    <button class="btn-primary btn btn-md" type="submit">{{__('Send Message')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/common/js/countdown.jquery.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        $(document).ready(function () {

            $('.summernote').summernote({
                height: 200,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('textarea').val(contents);
                    }
                }
            });

            var year = "{{date('Y',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            var month = "{{date('m',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            var day = "{{date('d',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            var hours = "{{date('h',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            var min = "{{date('i',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            var sec = "{{date('s',strtotime(get_future_date($gig_details->created_at,$gig_details->selected_plan_delivery_days)))}}";
            if (year) {
                $('#countdown').countdown({
                    year: year,
                    month: month,
                    day: day,
                    hour: hours,
                    minute: min,
                    second: sec,
                    labels: true,
                    labelText: {
                        'days': "{{__('days')}}",
                        'hours': "{{__('hours')}}",
                        'minutes': "{{__('min')}}",
                        'seconds': "{{__('sec')}}",
                    }
                });
            }
        });
    </script>
@endsection
