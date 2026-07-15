@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
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
    {{__('Package Order Management')}}
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
                        <h4 class="header-title">{{__('Package Order Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-orders-tab" data-toggle="tab" href="#all_orders_panel" role="tab" aria-selected="true">{{__('All Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-orders-tab" data-toggle="tab" href="#pending_orders_panel" role="tab" aria-selected="false">{{__('Pending Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="inprogress-orders-tab" data-toggle="tab" href="#inprogress_orders_panel" role="tab" aria-selected="false">{{__('In Progress Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-orders-tab" data-toggle="tab" href="#completed_orders_panel" role="tab" aria-selected="false">{{__('Completed Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="form-builder-tab" data-toggle="tab" href="#form_builder_panel" role="tab" aria-selected="false">{{__('Form Builder')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings_panel" role="tab" aria-selected="false">{{__('Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="orderTabsContent">
                            <!-- All Orders Tab -->
                            <div class="tab-pane fade show active" id="all_orders_panel" role="tabpanel" aria-labelledby="all-orders-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" class="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default order-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Package Name')}}</th>
                                            <th>{{__('Package Price')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Order Status')}}</th>
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
                                                <td>{{$data->package_name}}</td>
                                                <td>{{amount_with_currency_symbol($data->package_price)}}</td>
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
                                                    @elseif($data->status == 'canceled')
                                                        <span class="alert alert-danger text-capitalize">{{$data->status}}</span>
                                                    @elseif($data->status == 'in_progress')
                                                        <span class="alert alert-info text-capitalize">{{$data->status}}</span>
                                                    @else
                                                        <span class="alert alert-success text-capitalize">{{$data->status}}</span>
                                                    @endif
                                                </td>
                                                @php
                                                    $all_custom_fields = [];
                                                    $all_custom_fields_un = unserialize($data->custom_fields);
                                                    $all_custom_fields = json_encode($all_custom_fields_un);
                                                @endphp
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this?')}}</h6>
                                                   <form method='post' action='{{route('admin.order.manage.delete',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#user_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                    >
                                                        <i class="ti-email"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_order_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-paystatus="{{$data->payment_status}}"
                                                       data-packageid="{{$data->package_id}}"
                                                       data-packageprice="{{$data->package_price}}"
                                                       data-packagename="{{$data->package_name}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#order_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 order_status_change_btn"
                                                    >
                                                        {{__("Update Status")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pending Orders Tab -->
                            <div class="tab-pane fade" id="pending_orders_panel" role="tabpanel" aria-labelledby="pending-orders-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" class="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default order-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Package Name')}}</th>
                                            <th>{{__('Package Price')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Order Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_orders as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->package_name}}</td>
                                                <td>{{amount_with_currency_symbol($data->package_price)}}</td>
                                                <td>
                                                    <span class="alert alert-warning text-capitalize">{{$data->payment_status}}</span>
                                                </td>
                                                <td>
                                                    <span class="alert alert-warning text-capitalize">{{$data->status}}</span>
                                                </td>
                                                @php
                                                    $all_custom_fields = [];
                                                    $all_custom_fields_un = unserialize($data->custom_fields);
                                                    $all_custom_fields = json_encode($all_custom_fields_un);
                                                @endphp
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this?')}}</h6>
                                                   <form method='post' action='{{route('admin.order.manage.delete',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#user_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                    >
                                                        <i class="ti-email"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_order_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-paystatus="{{$data->payment_status}}"
                                                       data-packageid="{{$data->package_id}}"
                                                       data-packageprice="{{$data->package_price}}"
                                                       data-packagename="{{$data->package_name}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#order_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 order_status_change_btn"
                                                    >
                                                        {{__("Update Status")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- In Progress Orders Tab -->
                            <div class="tab-pane fade" id="inprogress_orders_panel" role="tabpanel" aria-labelledby="inprogress-orders-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" class="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default order-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Package Name')}}</th>
                                            <th>{{__('Package Price')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Order Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($in_progress_orders as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->package_name}}</td>
                                                <td>{{amount_with_currency_symbol($data->package_price)}}</td>
                                                <td>
                                                    @if($data->payment_status == 'pending')
                                                        <span class="alert alert-warning text-capitalize">{{$data->payment_status}}</span>
                                                    @else
                                                        <span class="alert alert-success text-capitalize">{{$data->payment_status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="alert alert-info text-capitalize">{{$data->status}}</span>
                                                </td>
                                                @php
                                                    $all_custom_fields = [];
                                                    $all_custom_fields_un = unserialize($data->custom_fields);
                                                    $all_custom_fields = json_encode($all_custom_fields_un);
                                                @endphp
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this?')}}</h6>
                                                   <form method='post' action='{{route('admin.order.manage.delete',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#user_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                    >
                                                        <i class="ti-email"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_order_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-paystatus="{{$data->payment_status}}"
                                                       data-packageid="{{$data->package_id}}"
                                                       data-packageprice="{{$data->package_price}}"
                                                       data-packagename="{{$data->package_name}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#order_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 order_status_change_btn"
                                                    >
                                                        {{__("Update Status")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Completed Orders Tab -->
                            <div class="tab-pane fade" id="completed_orders_panel" role="tabpanel" aria-labelledby="completed-orders-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" class="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default order-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Package Name')}}</th>
                                            <th>{{__('Package Price')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Order Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($completed_orders as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->package_name}}</td>
                                                <td>{{amount_with_currency_symbol($data->package_price)}}</td>
                                                <td>
                                                    @if($data->payment_status == 'pending')
                                                        <span class="alert alert-warning text-capitalize">{{$data->payment_status}}</span>
                                                    @else
                                                        <span class="alert alert-success text-capitalize">{{$data->payment_status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="alert alert-success text-capitalize">{{$data->status}}</span>
                                                </td>
                                                @php
                                                    $all_custom_fields = [];
                                                    $all_custom_fields_un = unserialize($data->custom_fields);
                                                    $all_custom_fields = json_encode($all_custom_fields_un);
                                                @endphp
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this?')}}</h6>
                                                   <form method='post' action='{{route('admin.order.manage.delete',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#user_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                    >
                                                        <i class="ti-email"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_order_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-paystatus="{{$data->payment_status}}"
                                                       data-packageid="{{$data->package_id}}"
                                                       data-packageprice="{{$data->package_price}}"
                                                       data-packagename="{{$data->package_name}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#order_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 order_status_change_btn"
                                                    >
                                                        {{__("Update Status")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Form Builder Tab -->
                            <div class="tab-pane fade" id="form_builder_panel" role="tabpanel" aria-labelledby="form-builder-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__("Order Form Builder")}}</h4>
                                                <form action="{{route('admin.form.builder.order')}}" method="Post">
                                                    @csrf
                                                    {!! render_drag_drop_form_builder_markup(get_static_option('order_page_form_fields')) !!}
                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                                <ul id="sortable_02" class="available-form-field">
                                                    <li class="ui-state-default" type="text"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Text')}}</li>
                                                    <li class="ui-state-default" type="email"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Email')}}</li>
                                                    <li class="ui-state-default" type="tel"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Tel')}}</li>
                                                    <li class="ui-state-default" type="url"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('URL')}}</li>
                                                    <li class="ui-state-default" type="select"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Select')}}</li>
                                                    <li class="ui-state-default" type="checkbox"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Check Box')}}</li>
                                                    <li class="ui-state-default" type="file"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('File')}}</li>
                                                    <li class="ui-state-default" type="textarea"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Textarea')}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Tab -->
                            <div class="tab-pane fade" id="settings_panel" role="tabpanel" aria-labelledby="settings-tab">
                                <h5 class="mb-3">{{__('Order Page Settings')}}</h5>
                                <form action="{{route('admin.order.page')}}" method="post" class="mb-5">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-order" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                            <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-order-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                        <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-order-{{$lang->slug}}" role="tabpanel" >
                                            <div class="form-group">
                                                <label for="order_page_{{$lang->slug}}_form_title">{{__('Order Form Title')}}</label>
                                                <input type="text" name="order_page_{{$lang->slug}}_form_title" value="{{get_static_option('order_page_'.$lang->slug.'_form_title')}}" class="form-control" id="order_page_{{$lang->slug}}_form_title">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="order_page_form_mail">{{__('Email Address For Order Message')}}</label>
                                        <input type="text" name="order_page_form_mail" value="{{get_static_option('order_page_form_mail')}}" class="form-control" id="order_page_form_mail">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>

                                <hr>
                                <h5 class="mb-3 mt-4">{{__('Success Page Settings')}}</h5>
                                <form action="{{route('admin.order.success.page')}}" method="post" class="mb-5">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-success" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-success-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-success-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>{{__('Title')}}</label>
                                                    <input type="text" name="site_order_success_page_{{$lang->slug}}_title" class="form-control" value="{{get_static_option('site_order_success_page_'.$lang->slug.'_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Subtitle')}}</label>
                                                    <input type="text" name="site_order_success_page_{{$lang->slug}}_subtitle" class="form-control" value="{{get_static_option('site_order_success_page_'.$lang->slug.'_subtitle')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Description')}}</label>
                                                    <textarea name="site_order_success_page_{{$lang->slug}}_description" class="form-control" rows="5">{{get_static_option('site_order_success_page_'.$lang->slug.'_description')}}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Success Page')}}</button>
                                </form>

                                <hr>
                                <h5 class="mb-3 mt-4">{{__('Cancel Page Settings')}}</h5>
                                <form action="{{route('admin.order.cancel.page')}}" method="post">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-cancel" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-cancel-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-cancel-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>{{__('Title')}}</label>
                                                    <input type="text" name="site_order_cancel_page_{{$lang->slug}}_title" class="form-control" value="{{get_static_option('site_order_cancel_page_'.$lang->slug.'_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Subtitle')}}</label>
                                                    <input type="text" name="site_order_cancel_page_{{$lang->slug}}_subtitle" class="form-control" value="{{get_static_option('site_order_cancel_page_'.$lang->slug.'_subtitle')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Description')}}</label>
                                                    <textarea name="site_order_cancel_page_{{$lang->slug}}_description" class="form-control" rows="5">{{get_static_option('site_order_cancel_page_'.$lang->slug.'_description')}}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Cancel Page')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="view_order_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="view-order-details-info p-4">
                   <h4 class="title mb-3">{{__('View Order Details Information')}}</h4>
                   <div class="view-order-top-wrap mb-3">
                       <div class="status-wrap">
                           Order Status: <span class="order-status-span"></span>
                       </div>
                       <div class="data-wrap">
                           Order Date: <span class="order-date-span"></span>
                       </div>
                   </div>
                   <div class="table-responsive">
                       <table class="order-all-custom-fields table table-striped table-bordered"></table>
                   </div>
               </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail To Order Sender')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.order.manage.send.mail')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">{{__('Name')}}</label>
                            <input type="text" class="form-control" name="name" placeholder="{{__('Enter name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{__('Email')}}</label>
                            <input type="text" class="form-control" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="Subject">{{__('Subject')}}</label>
                            <input type="text" class="form-control" name="subject" value="{{__('Your order Replay From {site}')}}">
                            <small class="info-text">{{__('{site} will be replaced by site title')}}</small>
                        </div>
                        <div class="form-group">
                            <label>{{__('Message')}}</label>
                            <input type="hidden" name="message">
                            <div class="summernote"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Send Mail')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="order_status_change_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('order Status Change')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.order.manage.change.status')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label for="order_status">{{__('order Status')}}</label>
                            <select name="order_status" class="form-control" id="order_status">
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="in_progress">{{__('In Progress')}}</option>
                                <option value="canceled">{{__('Canceled')}}</option>
                                <option value="completed">{{__('Completed')}}</option>
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
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Keep active tab on refresh
            $('#orderTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#orderTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabOrder', id);
            });
            var activeTab = window.localStorage.getItem('activeTabOrder');
            if (activeTab) {
                $('#orderTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // View Details Modal
            $(document).on('click','.view_order_details_btn',function (e) {
                e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var parent = $('#view_order_details_modal');
                var statusClass = allData.status == 'pending' ? 'alert alert-warning' : 'alert alert-success';

                parent.find('.order-status-span').text(allData.status).attr('class', 'order-status-span ' + statusClass);
                parent.find('.order-date-span').text(allData.date);
                parent.find('.order-all-custom-fields').html('');
                $.each(allData.customfield,function (index,value) {
                    if(index == 'package'){
                        var paymentStatusClass = allData.paystatus == 'pending' ? 'alert alert-warning' : 'alert alert-success';

                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">Package ID</td> <td class="fvalue">'+value+'</td></tr>');
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">Package Name</td> <td class="fvalue">'+allData.packagename+'</td></tr>');
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">Package Price</td> <td class="fvalue">'+allData.packageprice+'</td></tr>');
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">Payment Status</td> <td class="fvalue"><span class="'+paymentStatusClass+' text-capitalize">'+allData.paystatus+'</span></td></tr>');
                    }else if(index == 'selected_payment_gateway'){
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">Payment Gateway</td> <td class="fvalue">'+value+'</td></tr>');
                    }
                    else{
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">'+index.replace('-',' ')+'</td> <td class="fvalue">'+value+'</td></tr>');
                    }
                });

                if(allData.attachment){
                    $.each(allData.attachment,function (index,value) {
                        parent.find('.order-all-custom-fields tbody').append('<tr class="attachment_list"><td class="fname">'+index.replace('-',' ')+'</td><td class="fvalue"><a href="{{url('/')}}/'+value+'" download>'+value.substr(26)+'</a></td></tr>');
                    });
                }
            });

            // Update Status Modal
            $(document).on('click','.order_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#order_status_change_modal');
                form.find('#order_id').val(el.data('id'));
                form.find('#order_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });

            // DataTables
            $('.order-datatable').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            });

            // Summernote
            $('.summernote').summernote({
                height: 250,
                codemirror: {
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            // Bulk Delete
            $(document).on('click','.bulk_delete_btn',function (e) {
                e.preventDefault();
                var parentTab = $(this).closest('.tab-pane');
                var bulkOption = parentTab.find('.bulk_option').val();
                var allCheckbox = parentTab.find('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.order.bulk.action')}}",
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
                var value = $(this).is(':checked');
                var allChek = $(this).closest('table').find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Drag and drop form builder js
            $("#sortable").sortable({
                axis: "y",
                placeholder: "sortable-placeholder",
                out: function(event,ui){
                    setTimeout(function(){
                        var allShortableList = $("#sortable li");

                        allShortableList.each(function (index,value) {
                            var el = $(this);
                            el.find('.field-required').attr('name','field_required['+index+']');
                            el.find('.mime-type').attr('name','mimes_type['+index+']');
                        });
                    },500);
                }
            }).disableSelection();
            
            $("#sortable_02").sortable({
                connectWith: '#sortable',
                helper: "clone",
                remove: function (e, li) {
                    var value = li.item.context.attributes.type.value;
                    var random = Math.floor(Math.random(9999) * 999999);
                    var formFiledLength = $('#sortable li').length - 1;

                    var markup = render_drag_drop_form_field_markup(value,random,formFiledLength);
                    li.item.clone()
                        .prop('id', value + '_' + random)
                        .text('')
                        .append(markup)
                        .insertAfter(li.item);
                    $(this).sortable('cancel');
                    return li.item.clone();
                }
            }).disableSelection();

            $('body').on('change paste keyup', '.field-placeholder', function (e) {
                $(this).parent().parent().parent().prev().find('.placeholder-name').text($(this).val());
            });
            $('body').on('click', '.remove-fields', function (e) {
                $(this).parent().remove();
                $( "#sortable" ).sortable( "refreshPositions" );
            });

            function render_drag_drop_form_field_markup(type,random,formFiledLength){
                var markup = '';
                markup += '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>\n <span class="remove-fields">x</span>\n<a data-toggle="collapse" href="#collapseExample-' + random + '" role="button" aria-expanded="false" aria-controls="collapseExample">\n' +
                    type + ': <span class="placeholder-name"></span>\n</a>\n' +
                    '<div class="collapse" id="collapseExample-' + random + '">\n' +
                    '<div class="card card-body margin-top-30">\n' +
                    '<input type="hidden" class="form-control" name="field_type[]" value="' + type + '">' +
                    '<div class="form-group">\n' +
                    '<label>Name</label>\n' +
                    '<input type="text" class="form-control" name="field_name[]" placeholder="enter field name" >\n</div>\n' +
                    '<div class="form-group">\n <label>Placeholder/Label</label>\n' +
                    ' <input type="text" class="form-control field-placeholder"  name="field_placeholder[]" placeholder="enter field name" >\n' +
                    '</div>\n<div class="form-group">\n<label ><strong>Required</strong></label>\n<label class="switch">\n' +
                    '<input type="checkbox" class="field-required" name="field_required['+formFiledLength+']" >\n' +
                    '<span class="slider onff"></span>\n</label>\n</div>';
                if(type == 'select'){
                    markup += '<div class="form-group">\n' +
                        '<label>Options</label>\n' +
                        '<textarea name="select_options[]"  class="form-control max-height-120" cols="30" rows="10" ></textarea>\n' +
                        '<small>separate option by new line </small>\n' +
                        '</div>\n' ;
                }
                if(type == 'file'){
                    markup +=  '<div class="form-group">\n' +
                        '<label>File Type</label>\n' +
                        '<select name="mimes_type['+formFiledLength+']" class="form-control mime-type">\n' +
                        '<option value="mimes:jpg,jpeg,png" >jpg,jpeg,png</option>\n' +
                        '<option value="mimes:txt,pdf">txt,pdf</option>\n' +
                        '<option value="mimes:zip">zip</option>\n' +
                        '<option value="mimes:doc,docx">doc,docx</option>\n' +
                        '</select>\n' +
                        '</div>';
                }

                markup += '</div>\n  </div>';

                return markup;
            }
        } );
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
