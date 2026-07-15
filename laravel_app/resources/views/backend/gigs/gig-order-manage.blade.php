@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
    </style>
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
@endsection
@section('site-title')
    {{__('All Gig Orders')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mt-5">
                            <div class="card">
                                <div class="card-body">
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
                                    <h4 class="header-title">{{__('All Gig Orders')}}</h4>
                                    <div class="bulk-delete-wrapper">
                                        <div class="select-box-wrap">
                                            <select name="bulk_option" id="bulk_option">
                                                <option value="">{{{__('Bulk Action')}}}</option>
                                                <option value="delete">{{{__('Delete')}}}</option>
                                            </select>
                                            <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                        </div>
                                        <div class="select-box-wrap">
                                            <form action="" method="get">
                                                <select name="payment_status">
                                                    <option value="">{{{__('Payment Status')}}}</option>
                                                    <option @if($payment_status == 'complete') selected @endif value="complete">{{{__('Payment Complete')}}}</option>
                                                    <option @if($payment_status == 'pending') selected @endif value="pending">{{{__('Payment Pending')}}}</option>
                                                </select>
                                                <select name="order_status" >
                                                    <option value="">{{{__('Order Status Status')}}}</option>
                                                    <option @if($order_status == 'in_progress') selected @endif value="in_progress">{{{__('Order In Progress')}}}</option>
                                                    <option @if($order_status == 'complete') selected @endif value="complete">{{{__('Order Complete')}}}</option>
                                                    <option @if($order_status == 'pending') selected @endif value="pending">{{{__('Order Pending')}}}</option>
                                                    <option @if($order_status == 'cancel') selected @endif value="cancel">{{{__('Order Cancel')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" type="submit">{{__('Filter')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="data-tables datatable-primary table-responsive">
                                        <table id="all_user_table" >
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th>
                                                    <div class="mark-all-checkbox">
                                                        <input type="checkbox" class="all-checkbox">
                                                    </div>
                                                </th>
                                                <th>{{__('ID')}}</th>
                                                <th>{{__('Gig Info')}}</th>
                                                <th>{{__('Name')}}</th>
                                                <th>{{__('Email')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_gigs as $data)
                                                <tr>
                                                    <td>
                                                        <div class="bulk-checkbox-wrapper">
                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$data->id}}</td>
                                                    <td>
                                                        <div class="gig-order-info">
                                                            <ul>
                                                                <li><strong>{{__('Gig Name:')}}</strong> {{get_gig_name($data->gig_id)}}</li>
                                                                <li><strong>{{__('Package Name:')}}</strong> {{$data->selected_plan_title}}</li>
                                                                <li><strong>{{__('Package Price:')}}</strong> {{amount_with_currency_symbol($data->selected_plan_price)}}</li>
                                                                <li><strong>{{__('Revisions:')}}</strong> <span class="alert-success">{{$data->selected_plan_revisions.' '.__('Time Revisions')}}</span></li>
                                                                <li><strong>{{__('Payment Gateway:')}}</strong> {{str_replace('_',' ',$data->selected_payment_gateway)}}</li>
                                                                <li><strong>{{__('Payment Status:')}}</strong> <span class="@if($data->payment_status == 'complete') alert-success @else alert-warning @endif">{{ucwords($data->payment_status)}}</span></li>
                                                                <li><strong>{{__('Order Status:')}}</strong> <span class="@if($data->order_status == 'complete') alert-success @else alert-info @endif"> {{ucwords(str_replace('_',' ',$data->order_status))}} </span></li>
                                                                <li><strong>{{__('Delivery Date:')}}</strong> <span class="alert-danger">{{get_future_date($data->created_at,$data->selected_plan_delivery_days)}}</span></li>
                                                                @if($data->selected_payment_gateway == 'manual_payment' && $data->payment_status == 'pending')
                                                                <li><strong>{{__('Transaction ID:')}}</strong> <span class="alert-info">{{$data->transaction_id}}</span></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{{$data->full_name}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                    <td>
                                                        <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                       <h6>{{__('Are you sure to delete this order?')}}</h6>
                                                       <form method='post' action='{{route('admin.gigs.orders.delete',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                        </form>
                                                        " data-original-title="">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-secondary btn-xs mb-3 mr-1 gig_order_send_mail_btn" data-toggle="modal" data-gigorderid="{{$data->id}}" data-name="{{$data->full_name}}" data-target="#send_mail_to_customer"><i class="ti-email"></i></a>
                                                        <a href="{{route('admin.gigs.orders.message',$data->id)}}" class="btn btn-primary btn-xs mb-3 mr-1">
                                                            <i class="ti-eye"></i>
                                                        </a>
                                                        <a href="#" data-toggle="modal" data-target="#change_order_status" data-gigorderid="{{$data->id}}" data-status="{{$data->order_status}}"
                                                           class="btn btn-info btn-xs mb-3 mr-1 gig_order_status_change_btn" title="{{__('change status')}}"><i class="ti-pencil"></i></a>
                                                        @if( $data->payment_status == 'pending')
                                                            <form action="{{route('admin.gig.order.reminder.mail')}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{$data->id}}">
                                                                <button class="btn btn-light btn-xs mb-3 mr-1" title="{{__('send reminder mail')}}" type="submit"><i class="ti-bell"></i></button>
                                                            </form>
                                                        @endif
                                                        @if(!empty( $data->payment_status == 'complete'))
                                                            <form action="{{route('frontend.gig.invoice.generate')}}"  method="post">
                                                                @csrf
                                                                <input type="hidden" name="id"  value="{{$data->id}}">
                                                                <button class="btn btn-info" type="submit">{{__('Invoice')}}</button>
                                                            </form>
                                                        @endif
                                                        @if($data->selected_payment_gateway == 'manual_payment' && $data->payment_status == 'pending')
                                                            <a tabindex="0" class="btn btn-success btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                       <h6>{{__('Are you sure to approve this payment?')}}</h6>
                                                       <form method='post' action='{{route('admin.gig.payment.approve',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit'class='btn btn-success btn-sm' value='{{__('Yes,Approve')}}'>
                                                        </form>
                                                        " data-original-title="">
                                                                <i class="ti-check"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Primary table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change_order_status" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Change Order Status')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gig.order.status.change')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="order_id">
                        <div class="form-group">
                            <label for="order_status">{{__('Order Status')}}</label>
                            <select name="order_status" class="form-control">
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="in_progress">{{__('In Progress')}}</option>
                                <option value="cancel">{{__('Cancel')}}</option>
                                <option value="complete">{{__('Complete')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-xs btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="send_mail_to_customer" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gig.order.mail')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="order_id">
                        <div class="form-group">
                            <label for="">{{__('Subject')}}</label>
                            <input type="text" class="form-control" name="subject">
                        </div>
                       <div class="form-group">
                           <label for="">{{__('Message')}}</label>
                           <textarea name="message" cols="30" rows="10" style="display: none;"></textarea>
                           <div class="summernote"></div>
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-xs btn-primary">{{__('Send Mail')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script>
        $(document).ready(function($) {

            $(document).on('click','.gig_order_send_mail_btn',function (e){
               e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var formContainer = $('#send_mail_to_customer form');

                formContainer.find('input[name="order_id"]').val(allData.gigorderid);
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
                if($('.summernote').length > 0){
                    $('.summernote').each(function(index,value){
                        $(this).summernote('code', 'Hello '+allData.name+',');
                    });
                }

            });


            $(document).on('click','.gig_order_status_change_btn',function (e){
               e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var formContainer = $('#change_order_status form');

                formContainer.find('input[name="order_id"]').val(allData.gigorderid);
                formContainer.find('select[name="order_status"] option[value="'+allData.status+'"]').attr('selected',true);
            });

            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.gig.order.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success:function (data) {
                            location.reload();
                        }
                    });
                }

            });

            $('.all-checkbox').on('change',function (e) {
                e.preventDefault();
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                //have write code here fr
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            $('#all_user_table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            } );

        } );
    </script>
@endsection

