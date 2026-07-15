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
    {{__('Quote Management')}}
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
                        <h4 class="header-title">{{__('Quote Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="quoteTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-quotes-tab" data-toggle="tab" href="#all_quotes_panel" role="tab" aria-selected="true">{{__('All Quotes')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-quotes-tab" data-toggle="tab" href="#pending_quotes_panel" role="tab" aria-selected="false">{{__('Pending Quotes')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="completed-quotes-tab" data-toggle="tab" href="#completed_quotes_panel" role="tab" aria-selected="false">{{__('Completed Quotes')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="form-builder-tab" data-toggle="tab" href="#form_builder_panel" role="tab" aria-selected="false">{{__('Form Builder')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="page-settings-tab" data-toggle="tab" href="#page_settings_panel" role="tab" aria-selected="false">{{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="quoteTabsContent">
                            <!-- All Quotes Tab -->
                            <div class="tab-pane fade show active" id="all_quotes_panel" role="tabpanel" aria-labelledby="all-quotes-tab">
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
                                    <table class="table table-default quote-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_quotes as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>
                                                    @if($data->status == 'pending')
                                                        <span class="alert alert-warning text-capitalize">{{$data->status}}</span>
                                                    @elseif($data->status == 'canceled')
                                                        <span class="alert alert-danger text-capitalize">{{$data->status}}</span>
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
                                                   <h6>{{__('Are you sure to delete this quote?')}}</h6>
                                                   <form method='post' action='{{route('admin.quote.manage.delete',$data->id)}}'>
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
                                                       data-target="#view_quote_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_quote_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#quote_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 quote_status_change_btn"
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

                            <!-- Pending Quotes Tab -->
                            <div class="tab-pane fade" id="pending_quotes_panel" role="tabpanel" aria-labelledby="pending-quotes-tab">
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
                                    <table class="table table-default quote-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_quotes as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
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
                                                   <h6>{{__('Are you sure to delete this quote?')}}</h6>
                                                   <form method='post' action='{{route('admin.quote.manage.delete',$data->id)}}'>
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
                                                       data-target="#view_quote_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_quote_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#quote_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 quote_status_change_btn"
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

                            <!-- Completed Quotes Tab -->
                            <div class="tab-pane fade" id="completed_quotes_panel" role="tabpanel" aria-labelledby="completed-quotes-tab">
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
                                    <table class="table table-default quote-datatable">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($completed_quotes as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
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
                                                   <h6>{{__('Are you sure to delete this quote?')}}</h6>
                                                   <form method='post' action='{{route('admin.quote.manage.delete',$data->id)}}'>
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
                                                       data-target="#view_quote_details_modal"
                                                       data-status="{{$data->status}}"
                                                       data-customfield="{{$all_custom_fields}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_quote_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-status="{{$data->status}}"
                                                       data-toggle="modal"
                                                       data-target="#quote_status_change_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 quote_status_change_btn"
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
                                                <h4 class="header-title">{{__("Quote Form Builder")}}</h4>
                                                <form action="{{route('admin.form.builder.quote')}}" method="Post">
                                                    @csrf
                                                    {!! render_drag_drop_form_builder_markup(get_static_option('quote_page_form_fields')) !!}
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

                            <!-- Page Settings Tab -->
                            <div class="tab-pane fade" id="page_settings_panel" role="tabpanel" aria-labelledby="page-settings-tab">
                                <form action="{{route('admin.quote.page')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                            <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30" id="nav-tabContent">
                                        @foreach($all_languages as $key => $lang)
                                        <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                            <div class="form-group">
                                                <label for="quote_page_{{$lang->slug}}_page_title">{{__('Quote Page Title')}}</label>
                                                <input type="text" name="quote_page_{{$lang->slug}}_page_title" value="{{get_static_option('quote_page_'.$lang->slug.'_page_title')}}" class="form-control" id="quote_page_{{$lang->slug}}_page_title">
                                            </div>
                                            <div class="form-group">
                                                <label for="quote_page_{{$lang->slug}}_form_title">{{__('Quote Form Title')}}</label>
                                                <input type="text" name="quote_page_{{$lang->slug}}_form_title" value="{{get_static_option('quote_page_'.$lang->slug.'_form_title')}}" class="form-control" id="quote_page_{{$lang->slug}}_form_title">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="quote_page_form_mail">{{__('Email Address For Quote Message')}}</label>
                                        <input type="text" name="quote_page_form_mail" value="{{get_static_option('quote_page_form_mail')}}" class="form-control" id="quote_page_form_mail">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="view_quote_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="view-quote-details-info p-4">
                   <h4 class="title mb-3">{{__('View Quote Details Information')}}</h4>
                   <div class="view-quote-top-wrap mb-3">
                       <div class="status-wrap">
                           {{__('Status:')}} <span class="quote-status-span"></span>
                       </div>
                       <div class="data-wrap">
                          {{__('Date:')}} <span class="quote-date-span"></span>
                       </div>
                   </div>
                   <div class="table-responsive">
                       <table class="quote-all-custom-fields table table-striped table-bordered"></table>
                   </div>
               </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail To Quote Sender')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.quote.manage.send.mail')}}" method="post">
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
                            <input type="text" class="form-control" name="subject" value="{{__('Your Quote Replay From {site}')}}">
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

    <div class="modal fade" id="quote_status_change_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Quote Status Change')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.quote.manage.change.status')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="quote_id" id="quote_id">
                        <div class="form-group">
                            <label for="quote_status">{{__('Quote Status')}}</label>
                            <select name="quote_status" class="form-control" id="quote_status">
                                <option value="pending">{{__('Pending')}}</option>
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
            $('#quoteTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#quoteTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabQuote', id);
            });
            var activeTab = window.localStorage.getItem('activeTabQuote');
            if (activeTab) {
                $('#quoteTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // View Details Modal
            $(document).on('click','.view_quote_details_btn',function (e) {
                e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var parent = $('#view_quote_details_modal');
                var statusClass = allData.status == 'pending' ? 'alert alert-warning' : 'alert alert-success';

                parent.find('.quote-status-span').text(allData.status).attr('class', 'quote-status-span ' + statusClass);
                parent.find('.quote-date-span').text(allData.date);
                parent.find('.quote-all-custom-fields').html('');
                $.each(allData.customfield,function (index,value) {
                    parent.find('.quote-all-custom-fields').append('<tr><td class="fname">'+index.replace('-',' ')+'</td> <td class="fvalue">'+value+'</td></tr>');
                });
                if(allData.attachment){
                    $.each(allData.attachment,function (index,value) {
                        parent.find('.quote-all-custom-fields').append('<tr class="attachment_list"><td class="fname">'+index.replace('-',' ')+'</td><td class="fvalue"><a href="'+value+'" download>'+value.substr(26)+'</a></td></tr>');
                    });
                }
            });

            // Update Status Modal
            $(document).on('click','.quote_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#quote_status_change_modal');
                form.find('#quote_id').val(el.data('id'));
                form.find('#quote_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });

            // DataTables
            $('.quote-datatable').DataTable( {
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
                        'url' : "{{route('admin.quote.manage.bulk.action')}}",
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
