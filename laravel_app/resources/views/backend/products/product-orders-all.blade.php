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
@endsection
@section('site-title')
    {{__('All Product Orders')}}
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
                                    <h4 class="header-title">{{__('All Product Orders')}}</h4>
                                    <div class="bulk-delete-wrapper">
                                        <div class="select-box-wrap">
                                            <select name="bulk_option" id="bulk_option">
                                                <option value="">{{{__('Bulk Action')}}}</option>
                                                <option value="publish">{{{__('Publish')}}}</option>
                                                <option value="draft">{{{__('Draft')}}}</option>
                                                <option value="delete">{{{__('Delete')}}}</option>
                                            </select>
                                            <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                        </div>
                                    </div>
                                    <div class="data-tables datatable-primary table-responsive">
                                        <table id="all_user_table" >
                                            <thead class="text-capitalize">
                                            <tr>
                                                <th class="no-sort">
                                                    <div class="mark-all-checkbox">
                                                        <input type="checkbox" class="all-checkbox">
                                                    </div>
                                                </th>
                                                <th>{{__('Order ID')}}</th>
                                                <th>{{__('Billing Name')}}</th>
                                                <th>{{__('Billing Email')}}</th>
                                                <th>{{__('Total Amount')}}</th>
                                                <th>{{__('Package Gateway')}}</th>
                                                <th>{{__('Payment Status')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($all_orders as $data)
                                                <tr>
                                                    <td>
                                                        <div class="bulk-checkbox-wrapper">
                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->billing_name}}</td>
                                                    <td>{{$data->billing_email}}</td>
                                                    <td>{{site_currency_symbol()}}{{$data->total}}</td>
                                                    <td><strong>{{ucwords(str_replace('_',' ',$data->payment_gateway))}}</strong></td>
                                                    <td>
                                                        @if($data->payment_status == 'pending')
                                                            <span class="alert alert-warning text-capitalize">{{$data->payment_status}}</span>
                                                        @else
                                                            <span class="alert alert-success text-capitalize">{{$data->payment_status}}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data->status == 'pending')
                                                            <span class="alert alert-warning text-capitalize">{{$data->status}}</span>
                                                        @elseif($data->status == 'in_progress')
                                                            <span class="alert alert-info text-capitalize">{{ucwords(str_replace('_',' ',$data->status))}}</span>
                                                        @elseif($data->status == 'shipped')
                                                            <span class="alert alert-info text-capitalize">{{$data->status}}</span>
                                                        @elseif($data->status == 'complete')
                                                            <span class="alert alert-success text-capitalize">{{$data->status}}</span>
                                                        @elseif($data->status == 'cancel')
                                                            <span class="alert alert-danger text-capitalize">{{$data->status}}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                    <td>
                                                        <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                       <h6>{{__('Are you sure to delete this order?')}}</h6>
                                                       <form method='post' action='{{route('admin.product.payment.delete',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                        </form>
                                                        " data-original-title="">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                        @php $shipping_method = !empty($data->shipping_details->title) ? $data->shipping_details->title : 'not selected'; @endphp
                                                        <a href="{{route('frontend.product.order.view',$data->id)}}" target="_blank"  class="btn btn-lg btn-primary btn-sm mb-3 mr-1"> <i class="ti-eye"></i></a>
                                                        @if( $data->payment_status == 'pending')
                                                            <form action="{{route('admin.product.order.reminder.mail')}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="order_id" value="{{$data->id}}">
                                                                <button class="btn btn-light btn-xs mb-3 mr-1" title="{{__('send reminder mail')}}" type="submit"><i class="ti-bell"></i></button>
                                                            </form>
                                                        @endif
                                                        <a href="#"
                                                           data-id="{{$data->id}}"
                                                           data-status="{{$data->status}}"
                                                           data-toggle="modal"
                                                           data-target="#order_status_change_modal"
                                                           class="btn btn-lg btn-info btn-sm mb-3 mr-1 order_status_change_btn"
                                                        >
                                                            {{__("Update Status")}}
                                                        </a>
                                                        @if(($data->payment_gateway == 'cash_on_delivery' || $data->payment_gateway == 'manual_payment') && $data->payment_status == 'pending')
                                                            <a tabindex="0" class="btn btn-lg btn-success btn-sm mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                       <h6>{{__('Are you sure to approve this payment?')}}</h6>
                                                       <form method='post' action='{{route('admin.products.order.payment.approve',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-success btn-sm' value='{{__('Yes,Please')}}'>
                                                        </form>
                                                        " data-original-title="">
                                                                {{__('Approve Payment')}}
                                                            </a>
                                                        @endif
                                                        @if( $data->payment_status == 'complete')
                                                        <form action="{{route('frontend.product.invoice.generate')}}"  method="post">
                                                            @csrf
                                                            <input type="hidden" name="order_id" id="invoice_generate_order_field" value="{{$data->id}}">
                                                            <button class="btn btn-secondary" type="submit">{{__('Invoice')}}</button>
                                                        </form>
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


    <div class="modal fade" id="order_status_change_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Order Status Change')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.product.order.status.change')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label for="order_status">{{__('order Status')}}</label>
                            <select name="order_status" class="form-control" id="order_status">
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="in_progress">{{__('In Progress')}}</option>
                                <option value="shipped">{{__('Shipped')}}</option>
                                <option value="cancel">{{__('Cancel')}}</option>
                                <option value="complete">{{__('Complete')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Change Status')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function($) {

            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();

                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.product.order.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption
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

            $(document).on('click','#genarate_invoice',function (e) {
                e.preventDefault();

                var doc = new jsPDF();
                var elementHTML = $('#pdf_content_wrapper').html();
                var specialElementHandlers = {
                    '#elementH': function (element, renderer) {
                        return true;
                    }
                };
                doc.fromHTML(elementHTML, 15, 15, {
                    'width': 170,
                    'elementHandlers': specialElementHandlers
                });

                // Save the PDF
                doc.save('sample-document.pdf');

            })
            $('#all_user_table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            } );
            $(document).on('click','.order_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#order_status_change_modal');
                form.find('#order_id').val(el.data('id'));
                form.find('#order_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });

        } );
    </script>
@endsection

