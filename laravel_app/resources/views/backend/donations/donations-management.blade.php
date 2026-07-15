@extends('backend.admin-master')
@section('site-title')
    {{__('Donations Management')}}
@endsection
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
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
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
                        <h4 class="header-title">{{__('Donations Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="donationTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-donations-tab" data-toggle="tab" href="#all_donations_panel" role="tab" aria-selected="true">{{__('All Donations')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-donation-tab" data-toggle="tab" href="#add_donation_panel" role="tab" aria-selected="false">{{__('Add New Donation')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-logs-tab" data-toggle="tab" href="#payment_logs_panel" role="tab" aria-selected="false">{{__('Payment Logs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings_panel" role="tab" aria-selected="false">{{__('Settings')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="report-tab" data-toggle="tab" href="#report_panel" role="tab" aria-selected="false">{{__('Report')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="donationTabsContent">
                            <!-- All Donations Panel -->
                            <div class="tab-pane fade show active" id="all_donations_panel" role="tabpanel" aria-labelledby="all-donations-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" id="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_donations as $key => $event)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40" id="myTabContent">
                                    @php $b=0; @endphp
                                    @foreach($all_donations as $key => $donation)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default">
                                                    <thead>
                                                    <th class="no-sort">
                                                        <div class="mark-all-checkbox">
                                                            <input type="checkbox" class="all-checkbox">
                                                        </div>
                                                    </th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Title')}}</th>
                                                    <th>{{__('Image')}}</th>
                                                    <th>{{__('Amount')}}</th>
                                                    <th>{{__('Raised')}}</th>
                                                    <th>{{__('Date')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($donation as $data)
                                                        <tr>
                                                            <td>
                                                                <div class="bulk-checkbox-wrapper">
                                                                    <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                </div>
                                                            </td>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->title}}</td>
                                                            <td>
                                                               <div class="img-wrap">
                                                                   @php
                                                                       $event_img = get_attachment_image_by_id($data->image,'thumbnail',true);
                                                                   @endphp
                                                                   @if (!empty($event_img))
                                                                       <div class="attachment-preview">
                                                                           <div class="thumbnail">
                                                                               <div class="centered">
                                                                                   <img class="avatar user-thumb" src="{{$event_img['img_url']}}" alt="">
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   @endif
                                                               </div>
                                                            </td>
                                                            <td>{{site_currency_symbol()}}{{$data->amount}}</td>
                                                            <td>{{site_currency_symbol()}}{{$data->raised ? $data->raised : 0}}</td>
                                                            <td>{{date("d - M - Y", strtotime($data->created_at))}}</td>
                                                            <td>
                                                                @if($data->status == 'draft')
                                                                    <span class="alert alert-warning" >{{__('Draft')}}</span>
                                                                @else
                                                                    <span class="alert alert-success">{{__('Publish')}}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                                   role="button"
                                                                   data-toggle="popover"
                                                                   data-trigger="focus"
                                                                   data-html="true"
                                                                   title=""
                                                                   data-content="
                                                               <h6>{{__('Are you sure to delete this donation?')}}</h6>
                                                               <form method='post' action='{{route('admin.donations.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                </form>
                                                                ">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.donations.edit',$data->id)}}">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-info btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.donations.single',$data->slug)}}">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <form action="{{route('admin.donations.clone')}}" method="post" style="display: inline-block">
                                                                    @csrf
                                                                    <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                    <button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary btn-sm mb-3 mr-1"><i class="far fa-copy"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @php $b++; @endphp
                                    @endforeach
                                </div>
                            </div>

                            <!-- Add New Donation Panel -->
                            <div class="tab-pane fade" id="add_donation_panel" role="tabpanel" aria-labelledby="add-donation-tab">
                                <form action="{{route('admin.donations.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language"><strong>{{__('Language')}}</strong></label>
                                                <select name="lang" id="language" class="form-control">
                                                    @foreach($all_languages as $lang)
                                                        <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">{{__('Title')}}</label>
                                                <input type="text" class="form-control"  id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control"  id="slug" name="slug" value="{{old('slug')}}" placeholder="{{__('slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="donation_content" >
                                                <div class="summernote"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">{{__('Amount')}}</label>
                                                <input type="text" class="form-control"  id="amount" name="amount" placeholder="{{__('amount')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                                <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput"  id="meta_tags">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description">{{__('Meta Description')}}</label>
                                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">{{__('Image')}}</label>
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap"></div>
                                                    <input type="hidden" name="image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Donation Image" data-modaltitle="Upload Donation Image" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__('Upload Image')}}
                                                    </button>
                                                </div>
                                                <small>{{__('Recommended image size 1920x1280')}}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" id="status"  class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New donation')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Payment Logs Panel -->
                            <div class="tab-pane fade" id="payment_logs_panel" role="tabpanel" aria-labelledby="payment-logs-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option_log" id="bulk_option_log">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_log">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="data-tables datatable-primary table-responsive">
                                    <table class="table table-default" id="payment_logs_table">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox-log">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Payer Name')}}</th>
                                            <th>{{__('Payer Email')}}</th>
                                            <th>{{__('Donation Name')}}</th>
                                            <th>{{__('Donated Amount')}}</th>
                                            <th>{{__('Payment Gateway')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_donation_logs as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox-log" name="bulk_delete_log[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->email}}</td>
                                                <td>
                                                    @if(!empty($data->donation))
                                                    {{$data->donation->title}}
                                                    @else
                                                    <div class="alert alert-warning">{{__('This Donation Is not available or Removed')}}</div>
                                                    @endif
                                                </td>
                                                <td>{{site_currency_symbol()}}{{$data->amount}}</td>
                                                <td><strong>{{ucwords(str_replace('_',' ',$data->payment_gateway))}}</strong></td>
                                                <td>
                                                    @if($data->status == 'pending')
                                                        <span class="alert alert-warning text-capitalize text-center d-block py-1">{{$data->status}}</span>
                                                    @else
                                                        <span class="alert alert-success text-capitalize text-center d-block py-1">{{$data->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this payment logs?')}}</h6>
                                                   <form method='post' action='{{route('admin.donations.payment.delete',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                   </form>
                                                    ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_quote_details_modal"
                                                       data-email="{{$data->email}}"
                                                       data-name="{{$data->name}}"
                                                       @if(!empty($data->donation))
                                                       data-donation_name="{{$data->donation->title}}"
                                                       @endif
                                                       data-donate_amount="{{site_currency_symbol()}}{{$data->amount}}"
                                                       data-payment_gateway="{{ucwords(str_replace('_',' ',$data->payment_gateway))}}"
                                                       data-transaction_id="{{$data->transaction_id}}"
                                                       data-status="{{$data->status}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       class="btn btn-primary btn-xs mb-3 mr-1 view_quote_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    @if($data->payment_gateway == 'manual_payment' && $data->status == 'pending')
                                                    <a tabindex="0" class="btn btn-success btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to approve this payment?')}}</h6>
                                                   <form method='post' action='{{route('admin.donations.payment.approve',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-success btn-sm' value='{{__('Yes,Please')}}'>
                                                   </form>
                                                    ">
                                                        <i class="ti-check"></i>
                                                    </a>
                                                    @endif
                                                    @if(!empty($data->donation))
                                                    <form action="{{route('frontend.donation.invoice.generate')}}" method="post" style="display: inline-block">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}">
                                                        <button class="btn btn-xs btn-secondary mb-3" type="submit">{{__('Invoice')}}</button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Settings Panel -->
                            <div class="tab-pane fade" id="settings_panel" role="tabpanel" aria-labelledby="settings-tab">
                                <ul class="nav nav-tabs" id="settingSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-settings-tab" data-toggle="tab" href="#general_settings_sub" role="tab">{{__('General')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="single-settings-tab" data-toggle="tab" href="#single_settings_sub" role="tab">{{__('Single Page')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="success-settings-tab" data-toggle="tab" href="#success_settings_sub" role="tab">{{__('Success Page')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="cancel-settings-tab" data-toggle="tab" href="#cancel_settings_sub" role="tab">{{__('Cancel Page')}}</a>
                                    </li>
                                </ul>

                                <div class="tab-content margin-top-40" id="settingSubTabsContent">
                                    <!-- General Settings -->
                                    <div class="tab-pane fade show active" id="general_settings_sub" role="tabpanel">
                                        <form action="{{route('admin.donations.page.settings')}}" method="POST">
                                            @csrf
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab-general" role="tablist">
                                                    @foreach($all_languages as $key => $lang)
                                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-general-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                                    @endforeach
                                                </div>
                                            </nav>
                                            <div class="tab-content margin-top-30" id="nav-tabContent-general">
                                                @foreach($all_languages as $key => $lang)
                                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-general-{{$lang->slug}}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="donation_button_{{$lang->slug}}_text">{{__('Donation Button Text')}}</label>
                                                            <input type="text" name="donation_button_{{$lang->slug}}_text"  class="form-control" value="{{get_static_option('donation_button_'.$lang->slug.'_text')}}" id="donation_button_{{$lang->slug}}_text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_raised_{{$lang->slug}}_text">{{__('Raised Text')}}</label>
                                                            <input type="text" name="donation_raised_{{$lang->slug}}_text"  class="form-control" value="{{get_static_option('donation_raised_'.$lang->slug.'_text')}}" id="donation_raised_{{$lang->slug}}_text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_goal_{{$lang->slug}}_text">{{__('Goal Text')}}</label>
                                                            <input type="text" name="donation_goal_{{$lang->slug}}_text"  class="form-control" value="{{get_static_option('donation_goal_'.$lang->slug.'_text')}}" id="donation_goal_{{$lang->slug}}_text">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label for="donor_page_post_items">{{__('Donation Items')}}</label>
                                                <input type="text" name="donor_page_post_items"  class="form-control" value="{{get_static_option('donor_page_post_items')}}" id="donor_page_post_items">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                        </form>
                                    </div>

                                    <!-- Single Page Settings -->
                                    <div class="tab-pane fade" id="single_settings_sub" role="tabpanel">
                                        <form action="{{route('admin.donations.single.page.settings')}}" method="POST">
                                            @csrf
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab-single" role="tablist">
                                                    @foreach($all_languages as $key => $lang)
                                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-single-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                                    @endforeach
                                                </div>
                                            </nav>
                                            <div class="tab-content margin-top-30" id="nav-tabContent-single">
                                                @foreach($all_languages as $key => $lang)
                                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-single-{{$lang->slug}}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="donation_single_{{$lang->slug}}_form_title">{{__('Donation Form Title')}}</label>
                                                            <input type="text" name="donation_single_{{$lang->slug}}_form_title"  class="form-control" value="{{get_static_option('donation_single_'.$lang->slug.'_form_title')}}" id="donation_single_{{$lang->slug}}_form_title">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_single_{{$lang->slug}}_form_button_text">{{__('Form Button Title')}}</label>
                                                            <input type="text" name="donation_single_{{$lang->slug}}_form_button_text"  class="form-control" value="{{get_static_option('donation_single_'.$lang->slug.'_form_button_text')}}" id="donation_single_{{$lang->slug}}_form_button_text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_single_{{$lang->slug}}_recently_donated_title">{{__('Recently Donated Title')}}</label>
                                                            <input type="text" name="donation_single_{{$lang->slug}}_recently_donated_title"  class="form-control" value="{{get_static_option('donation_single_'.$lang->slug.'_recently_donated_title')}}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label for="donation_custom_amount">{{__('Custom Donation Amount')}}</label>
                                                <input type="text" name="donation_custom_amount"  class="form-control" value="{{get_static_option('donation_custom_amount')}}" id="donation_custom_amount">
                                                <small>{{__('Separate amount by comma (,)')}}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="donation_default_amount">{{__('Default Donation Amount')}}</label>
                                                <input type="text" name="donation_default_amount"  class="form-control" value="{{get_static_option('donation_default_amount')}}" id="donation_default_amount">
                                            </div>
                                            <div class="form-group">
                                                <label for="donation_notify_mail">{{__('Donation Notify Email')}}</label>
                                                <input type="text" name="donation_notify_mail"  class="form-control" value="{{get_static_option('donation_notify_mail')}}" id="donation_notify_mail">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                        </form>
                                    </div>

                                    <!-- Success Page Settings -->
                                    <div class="tab-pane fade" id="success_settings_sub" role="tabpanel">
                                        <form action="{{route('admin.donations.payment.success.page.settings')}}" method="POST">
                                            @csrf
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab-success" role="tablist">
                                                    @foreach($all_languages as $key => $lang)
                                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-success-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                                    @endforeach
                                                </div>
                                            </nav>
                                            <div class="tab-content margin-top-30" id="nav-tabContent-success">
                                                @foreach($all_languages as $key => $lang)
                                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-success-{{$lang->slug}}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="donation_success_page_{{$lang->slug}}_title">{{__('Title')}}</label>
                                                            <input type="text" name="donation_success_page_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('donation_success_page_'.$lang->slug.'_title')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_success_page_{{$lang->slug}}_subtitle">{{__('Subtitle')}}</label>
                                                            <input type="text" name="donation_success_page_{{$lang->slug}}_subtitle"  class="form-control" value="{{get_static_option('donation_success_page_'.$lang->slug.'_subtitle')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_success_page_{{$lang->slug}}_description">{{__('Description')}}</label>
                                                            <textarea name="donation_success_page_{{$lang->slug}}_description"  class="form-control" cols="30" rows="5">{{get_static_option('donation_success_page_'.$lang->slug.'_description')}}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                        </form>
                                    </div>

                                    <!-- Cancel Page Settings -->
                                    <div class="tab-pane fade" id="cancel_settings_sub" role="tabpanel">
                                        <form action="{{route('admin.donations.payment.cancel.page.settings')}}" method="POST">
                                            @csrf
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab-cancel" role="tablist">
                                                    @foreach($all_languages as $key => $lang)
                                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-cancel-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                                    @endforeach
                                                </div>
                                            </nav>
                                            <div class="tab-content margin-top-30" id="nav-tabContent-cancel">
                                                @foreach($all_languages as $key => $lang)
                                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-cancel-{{$lang->slug}}" role="tabpanel">
                                                        <div class="form-group">
                                                            <label for="donation_cancel_page_{{$lang->slug}}_title">{{__('Title')}}</label>
                                                            <input type="text" name="donation_cancel_page_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('donation_cancel_page_'.$lang->slug.'_title')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_cancel_page_{{$lang->slug}}_subtitle">{{__('Subtitle')}}</label>
                                                            <input type="text" name="donation_cancel_page_{{$lang->slug}}_subtitle"  class="form-control" value="{{get_static_option('donation_cancel_page_'.$lang->slug.'_subtitle')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="donation_cancel_page_{{$lang->slug}}_description">{{__('Description')}}</label>
                                                            <textarea name="donation_cancel_page_{{$lang->slug}}_description"  class="form-control" cols="30" rows="5">{{get_static_option('donation_cancel_page_'.$lang->slug.'_description')}}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Report Panel -->
                            <div class="tab-pane fade" id="report_panel" role="tabpanel" aria-labelledby="report-tab">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="title">{{__('Donation Payment Report')}}</h4>
                                        <form action="{{route('admin.donations.management')}}" method="GET" class="filter-form">
                                            <input type="hidden" name="active_tab" value="report_panel">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="start_date">{{__('Start Date')}}</label>
                                                        <input type="date" name="start_date" value="{{$start_date}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="end_date">{{__('End Date')}}</label>
                                                        <input type="date" name="end_date" value="{{$end_date}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="payment_status">{{__('Status')}}</label>
                                                        <select name="payment_status" class="form-control">
                                                            <option value="">{{__('Select Status')}}</option>
                                                            <option @if($payment_status == 'pending') selected @endif value="pending">{{__('Pending')}}</option>
                                                            <option @if($payment_status == 'complete') selected @endif value="complete">{{__('Complete')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="items">{{__('Items')}}</label>
                                                        <input type="number" name="items" value="{{$items ?? 10}}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">{{__('Generate Report')}}</button>
                                        </form>
                                    </div>
                                    @if(!empty($order_data))
                                    <div class="col-lg-12 mt-4">
                                        <div class="table-wrap table-responsive">
                                            <table class="table table-default">
                                                <thead>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Payer Name')}}</th>
                                                    <th>{{__('Payer Email')}}</th>
                                                    <th>{{__('Donation Name')}}</th>
                                                    <th>{{__('Donated Amount')}}</th>
                                                    <th>{{__('Payment Gateway')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Date')}}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($order_data as $data)
                                                    <tr>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->name}}</td>
                                                        <td>{{$data->email}}</td>
                                                        <td>
                                                            @if(!empty($data->donation))
                                                            {{$data->donation->title}}
                                                            @else
                                                            <div class="alert alert-warning">{{__('This Donation Is not available or Removed')}}</div>
                                                            @endif
                                                        </td>
                                                        <td>{{site_currency_symbol()}}{{$data->amount}}</td>
                                                        <td><strong>{{ucwords(str_replace('_',' ',$data->payment_gateway))}}</strong></td>
                                                        <td>
                                                            @if($data->status == 'pending')
                                                                <span class="alert alert-warning text-capitalize text-center d-block py-1">{{$data->status}}</span>
                                                            @else
                                                                <span class="alert alert-success text-capitalize text-center d-block py-1">{{$data->status}}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pagination-wrapper">
                                            {!! $order_data->links() !!}
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-12 mt-4">
                                        <div class="alert alert-warning">{{$error_msg}}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote details Modal -->
    <div class="modal fade" id="view_quote_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="view-quote-details-info">
                    <h4 class="title">{{__('View Payment Logs Details Information')}}</h4>
                    <div class="view-quote-top-wrap">
                        <div class="status-wrap">
                            {{__('Status:')}} <span class="quote-status-span"></span>
                        </div>
                        <div class="data-wrap">
                           {{__(' Date:')}} <span class="quote-date-span"></span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="quote-all-custom-fields table-striped table-bordered"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Keep active tab on refresh
            $('#donationTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabDonations', id);
            });
            var activeTab = window.localStorage.getItem('activeTabDonations');
            // If URL parameter contains active_tab, prioritize it (for report pagination/filter)
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('active_tab')) {
                activeTab = urlParams.get('active_tab');
            }
            if (activeTab) {
                $('#donationTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // Summernote
            $('.summernote').summernote({
                height: 400,
                codemirror: {
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            // Bulk Delete Donations
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
                        'url' : "{{route('admin.donations.bulk.action')}}",
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
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Bulk Action Logs
            $(document).on('click','#bulk_delete_btn_log',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_log').val();
                var allCheckbox =  $('.bulk-checkbox-log:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.donations.payment.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: 'delete'
                        },
                        success:function (data) {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox-log').on('change',function (e) {
                e.preventDefault();
                var value = $(this).is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox-log');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // View Details Modal Quote/Payment log
            $(document).on('click','.view_quote_details_btn',function (e) {
                e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var parent = $('#view_quote_details_modal');
                var statusClass = allData.status == 'pending' ? 'alert alert-warning' : 'alert alert-success';

                parent.find('.quote-status-span').text(allData.status).addClass(statusClass);
                parent.find('.quote-date-span').text(allData.date);
                parent.find('.quote-all-custom-fields').html('');
                delete allData.date;
                delete allData.status;
                delete allData.target;
                delete allData.toggle;
                $.each(allData,function (index,value) {
                    var curSymbol = index == 'package_price' ? "{{site_currency_symbol()}}" :  "";
                    parent.find('.quote-all-custom-fields').append('<tr><td class="fname">'+index.replace('_',' ')+'</td> <td class="fvalue">'+curSymbol+value+'</td></tr>');
                });
            });

            // Datatables
            $('.table-wrap > table, #payment_logs_table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            } );
        });
    </script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
