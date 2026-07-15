@extends('backend.admin-master')
@section('site-title')
    {{__('Events Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-datepicker.min.css')}}">
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
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; white-space: nowrap; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #A16207; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; }
        .nav-tabs::-webkit-scrollbar { height: 4px; }
        .nav-tabs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .tab-content { padding-top: 10px; }
        
        .language-tabs { margin-bottom: 15px; border-bottom: none; }
        .language-tabs .nav-link { padding: 8px 16px; font-size: 14px; border-bottom: 1px solid #E5E5E5; }
        .language-tabs .nav-link.active { border-bottom: 2px solid #A16207; }
    </style>
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
                        <h4 class="header-title">{{__('Events Management')}}</h4>

                        <ul class="nav nav-tabs" id="eventsManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-events-tab" data-toggle="tab" href="#all-events" role="tab" aria-selected="true"><i class="fas fa-list"></i> {{__('All Events')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-event-tab" data-toggle="tab" href="#add-new-event" role="tab" aria-selected="false"><i class="fas fa-plus"></i> {{__('Add New Event')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-selected="false"><i class="fas fa-tags"></i> {{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="attendance-logs-tab" data-toggle="tab" href="#attendance-logs" role="tab" aria-selected="false"><i class="fas fa-users"></i> {{__('Attendance Logs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-logs-tab" data-toggle="tab" href="#payment-logs" role="tab" aria-selected="false"><i class="fas fa-money-bill"></i> {{__('Payment Logs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="page-settings-tab" data-toggle="tab" href="#page-settings" role="tab" aria-selected="false"><i class="fas fa-cog"></i> {{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="eventsManagementTabContent">
                            
                            <!-- TAB 1: All Events -->
                            <div class="tab-pane fade show active" id="all-events" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                            <option value="draft">{{{__('Draft')}}}</option>
                                            <option value="publish">{{{__('Publish')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs language-tabs" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_events as $key => $event)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#slider_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-30">
                                    @php $b=0; @endphp
                                    @foreach($all_events as $key => $event)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel">
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default all_event_table">
                                                    <thead>
                                                        <th class="no-sort">
                                                            <div class="mark-all-checkbox">
                                                                <input type="checkbox" class="all-checkbox">
                                                            </div>
                                                        </th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Title')}}</th>
                                                        <th>{{__('Image')}}</th>
                                                        <th>{{__('Organizer')}}</th>
                                                        <th>{{__('Category')}}</th>
                                                        <th>{{__('Event Date')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($event as $data)
                                                            <tr>
                                                                <td>
                                                                    <div class="bulk-checkbox-wrapper">
                                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                    </div>
                                                                </td>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->title}}</td>
                                                                <td>
                                                                    @php $event_img = get_attachment_image_by_id($data->image,'thumbnail',true); @endphp
                                                                    @if (!empty($event_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$event_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>{{$data->organizer}}</td>
                                                                <td>{{get_events_category_by_id($data->category_id)}}</td>
                                                                <td>{{date("d - M - Y", strtotime($data->date))}}</td>
                                                                <td>
                                                                    @if($data->status == 'draft')
                                                                        <span class="badge badge-warning">{{__('Draft')}}</span>
                                                                    @else
                                                                        <span class="badge badge-success">{{__('Publish')}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                        <h6>{{__('Are you sure to delete this event?')}}</h6>
                                                                        <form method='post' action='{{route('admin.events.delete',$data->id)}}'>
                                                                        <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                        <br>
                                                                        <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                        </form>
                                                                    ">
                                                                        <i class="ti-trash"></i>
                                                                    </a>
                                                                    <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.events.edit',$data->id)}}">
                                                                        <i class="ti-pencil"></i>
                                                                    </a>
                                                                    <a class="btn btn-light btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.events.single',$data->slug)}}">
                                                                        <i class="ti-eye"></i>
                                                                    </a>
                                                                    <form action="{{route('admin.events.clone')}}" method="post" style="display: inline-block">
                                                                        @csrf
                                                                        <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                        <button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary mb-3 mr-1"><i class="far fa-copy"></i></button>
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

                            <!-- TAB 2: Add New Event -->
                            <div class="tab-pane fade" id="add-new-event" role="tabpanel">
                                <form action="{{route('admin.events.new')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}" placeholder="{{__('slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="category">{{__('Category')}}</label>
                                                <select name="category_id" class="form-control" id="category">
                                                    <option value="">{{__("Select Category")}}</option>
                                                    <!-- Loaded via ajax based on language -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="event_content">
                                                <div class="summernote"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="date">{{__('Date')}}</label>
                                                    <input type="date" class="form-control datepicker" id="date" name="date" placeholder="{{__('Date')}}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="time">{{__('Time')}}</label>
                                                    <input type="text" class="form-control" id="time" name="time" placeholder="{{__('time')}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="cost">{{__('Cost')}}</label>
                                                    <input type="text" class="form-control" id="cost" name="cost" placeholder="{{__('cost')}}">
                                                    <span class="info-text">{{__('enter zero (0) to make this event free of cost')}}</span>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="available_tickets">{{__('Available Tickets')}}</label>
                                                    <input type="text" class="form-control" id="available_tickets" name="available_tickets" placeholder="{{__('available tickets')}}">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="organizer">{{__('Organizer')}}</label>
                                                    <input type="text" class="form-control" id="organizer" name="organizer" value="{{old('organizer')}}" placeholder="{{__('Event Organizer')}}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="organizer_email">{{__('Organizer Email')}}</label>
                                                    <input type="text" class="form-control" id="organizer_email" name="organizer_email" value="{{old('organizer_email')}}" placeholder="{{__('Organizer Email')}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="organizer_phone">{{__('Organizer Phone')}}</label>
                                                    <input type="text" class="form-control" id="organizer_phone" name="organizer_phone" value="{{old('organizer_phone')}}" placeholder="{{__('Organizer Phone')}}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="organizer_website">{{__('Organizer Website')}}</label>
                                                    <input type="text" class="form-control" id="organizer_website" name="organizer_website" value="{{old('organizer_website')}}" placeholder="{{__('Organizer Website')}}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="venue">{{__('Venue')}}</label>
                                                    <input type="text" class="form-control" id="venue" name="venue" value="{{old('venue')}}" placeholder="{{__('Event Venue')}}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="venue_location">{{__('Venue Location')}}</label>
                                                    <input type="text" class="form-control" id="venue_location" name="venue_location" value="{{old('venue_location')}}" placeholder="{{__('Venue Location')}}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="venue_phone">{{__('Venue Phone')}}</label>
                                                    <input type="text" class="form-control" id="venue_phone" name="venue_phone" value="{{old('venue_phone')}}" placeholder="{{__('Venue Phone')}}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                                <input type="text" name="meta_tags" class="form-control" data-role="tagsinput" id="meta_tags">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description">{{__('Meta Description')}}</label>
                                                <textarea name="meta_description" class="form-control" rows="5" id="meta_description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">{{__('Image')}}</label>
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap"></div>
                                                    <input type="hidden" name="image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Event Image" data-modaltitle="Upload Event Image" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__('Upload Image')}}
                                                    </button>
                                                </div>
                                                <small>{{__('Recommended image size 1920x1280')}}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Event')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB 3: Categories -->
                            <div class="tab-pane fade" id="categories" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6 border-right">
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap d-inline-block">
                                                <select name="bulk_option" id="bulk_option_cat" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_cat">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs language-tabs" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach($all_categories as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#cat_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-30">
                                            @php $b=0; @endphp
                                            @foreach($all_categories as $key => $category)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="cat_tab_{{$key}}" role="tabpanel">
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default all_event_table">
                                                            <thead>
                                                                <th class="no-sort">
                                                                    <div class="mark-all-checkbox">
                                                                        <input type="checkbox" class="all-checkbox-cat">
                                                                    </div>
                                                                </th>
                                                                <th>{{__('ID')}}</th>
                                                                <th>{{__('Name')}}</th>
                                                                <th>{{__('Status')}}</th>
                                                                <th>{{__('Action')}}</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($category as $data)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="bulk-checkbox-wrapper">
                                                                                <input type="checkbox" class="bulk-checkbox-cat" name="bulk_delete[]" value="{{$data->id}}">
                                                                            </div>
                                                                        </td>
                                                                        <td>{{$data->id}}</td>
                                                                        <td>{{$data->title}}</td>
                                                                        <td>
                                                                            @if('publish' == $data->status)
                                                                                <span class="badge badge-success">{{ucfirst($data->status)}}</span>
                                                                            @else
                                                                                <span class="badge badge-warning">{{ucfirst($data->status)}}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                                <h6>{{__('Are you sure to delete this category item?')}}</h6>
                                                                                <form method='post' action='{{route('admin.events.category.delete',$data->id)}}'>
                                                                                <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                                <br>
                                                                                <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                                </form>
                                                                            ">
                                                                                <i class="ti-trash"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                               data-toggle="modal"
                                                                               data-target="#category_edit_modal"
                                                                               class="btn btn-primary btn-xs mb-3 mr-1 category_edit_btn"
                                                                               data-id="{{$data->id}}"
                                                                               data-name="{{$data->title}}"
                                                                               data-lang="{{$data->lang}}"
                                                                               data-status="{{$data->status}}"
                                                                            >
                                                                                <i class="ti-pencil"></i>
                                                                            </a>
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
                                    <div class="col-lg-6 pl-4">
                                        <h4 class="header-title">{{__('Add New Category')}}</h4>
                                        <form action="{{route('admin.events.category.new')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="cat_language">{{__('Language')}}</label>
                                                <select name="lang" id="cat_language" class="form-control">
                                                    @foreach($all_languages as $language)
                                                        <option value="{{$language->slug}}">{{$language->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="cat_name">{{__('Name')}}</label>
                                                <input type="text" class="form-control" id="cat_name" name="title" placeholder="{{__('Name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="cat_status">{{__('Status')}}</label>
                                                <select name="status" class="form-control" id="cat_status">
                                                    <option value="publish">{{__("Publish")}}</option>
                                                    <option value="draft">{{__("Draft")}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 4: Attendance Logs -->
                            <div class="tab-pane fade" id="attendance-logs" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option_att" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_att">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-default all_event_table" >
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox-att">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Event Name')}}</th>
                                            <th>{{__('Event Cost')}}</th>
                                            <th>{{__('Quantity')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_attendance_logs as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox-att" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->event_name}}</td>
                                                <td>{{site_currency_symbol()}}{{$data->event_cost}}</td>
                                                <td>{{$data->quantity}}</td>
                                                <td>
                                                    @if($data->payment_status == 'pending')
                                                        <span class="badge badge-warning text-capitalize">{{$data->payment_status}}</span>
                                                    @else
                                                        <span class="badge badge-success text-capitalize">{{$data->payment_status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->status == 'pending')
                                                    <span class="badge badge-warning text-capitalize">{{$data->status}}</span>
                                                    @elseif($data->status == 'canceled')
                                                        <span class="badge badge-danger text-capitalize">{{$data->status}}</span>
                                                    @else
                                                        <span class="badge badge-success text-capitalize">{{$data->status}}</span>
                                                    @endif
                                                </td>
                                                @php
                                                    $all_custom_fields = [];
                                                    $all_custom_fields_un = unserialize($data->custom_fields);
                                                    $all_custom_fields = json_encode($all_custom_fields_un);
                                                @endphp
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                    <h6>{{__('Are you sure to delete this attendance?')}}</h6>
                                                    <form method='post' action='{{route('admin.event.attendance.logs.delete',$data->id)}}'>
                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                    <br>
                                                    <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                        data-toggle="modal"
                                                        data-target="#user_edit_modal"
                                                        class="btn btn-primary btn-xs mb-3 mr-1"
                                                    >
                                                        <i class="ti-email"></i>
                                                    </a>
                                                    <a href="#"
                                                        data-id="{{$data->id}}"
                                                        data-status="{{$data->status}}"
                                                        data-toggle="modal"
                                                        data-target="#order_status_change_modal"
                                                        class="btn btn-info btn-xs mb-3 mr-1 order_status_change_btn"
                                                    >
                                                        {{__("Status")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 5: Payment Logs -->
                            <div class="tab-pane fade" id="payment-logs" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option_pay" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_pay">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-default all_event_table" >
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox-pay">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Payer Name')}}</th>
                                            <th>{{__('Payer Email')}}</th>
                                            <th>{{__('Event Name')}}</th>
                                            <th>{{__('Event Cost')}}</th>
                                            <th>{{__('Quantity')}}</th>
                                            <th>{{__('Package Gateway')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_event_logs as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox-pay" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->email}}</td>
                                                <td>{{$data->event_name}}</td>
                                                <td>{{site_currency_symbol()}}{{$data->event_cost}}</td>
                                                <td>{{$data->attendance_logs_id}}</td>
                                                <td><strong>{{ucwords(str_replace('_',' ',$data->package_gateway))}}</strong></td>
                                                <td>
                                                    @if($data->status == 'pending')
                                                        <span class="badge badge-warning text-capitalize">{{$data->status}}</span>
                                                    @else
                                                        <span class="badge badge-success text-capitalize">{{$data->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                    <h6>{{__('Are you sure to delete this payment log?')}}</h6>
                                                    <form method='post' action='{{route('admin.event.payment.delete',$data->id)}}'>
                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                    <br>
                                                    <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    @if($data->status == 'pending')
                                                    <a tabindex="0" class="btn btn-success btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                    <h6>{{__('Are you sure to approve this payment?')}}</h6>
                                                    <form method='post' action='{{route('admin.event.payment.approve',$data->id)}}'>
                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                    <br>
                                                    <input type='submit' class='btn btn-success btn-xs' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    ">
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

                            <!-- TAB 6: Page Settings -->
                            <div class="tab-pane fade" id="page-settings" role="tabpanel">
                                <form action="{{route('admin.events.page.settings')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="nav nav-tabs language-tabs" role="tablist">
                                        @foreach($all_languages as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#page-setting-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="page-setting-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="site_events_category_{{$lang->slug}}_title">{{__('Category Title')}}</label>
                                                    <input type="text" name="site_events_category_{{$lang->slug}}_title" class="form-control" value="{{get_static_option('site_events_category_'.$lang->slug.'_title')}}" id="site_events_category_{{$lang->slug}}_title">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="site_events_post_items">{{__('Events Items')}}</label>
                                        <input type="text" name="site_events_post_items" class="form-control" value="{{get_static_option('site_events_post_items')}}" id="site_events_post_items">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                </form>
                            </div>

                        </div> <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.events.category.update')}}" method="post">
                    <input type="hidden" name="id" id="category_id">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_language">{{__('Language')}}</label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach($all_languages as $language)
                                    <option value="{{$language->slug}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_name">{{__('Name')}}</label>
                            <input type="text" class="form-control" id="edit_name" name="title" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="draft">{{__("Draft")}}</option>
                                <option value="publish">{{__("Publish")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Change')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="order_status_change_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Attendance Status Change')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.event.attendance.logs')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="attendance_id" id="order_id">
                        <div class="form-group">
                            <label for="order_status">{{__('Attendance Status')}}</label>
                            <select name="attendance_status" class="form-control" id="order_status">
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

    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail To Attendance')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.event.attendance.send.mail')}}" method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="subject" value="{{__('Your Event Attendance Replay From {site}')}}">
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

    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-datepicker.min.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function () {
            // Tab persistence
            $('a[data-toggle="tab"][id$="-tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeEventsTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeEventsTab');
            if(activeTab){
                $('#eventsManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            // Category Edit Modal
            $(document).on('click','.category_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var status = el.data('status');
                var modal = $('#category_edit_modal');
                modal.find('#category_id').val(id);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_name').val(name);
                modal.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
            });

            // Attendance Log Status Modal
            $(document).on('click','.order_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#order_status_change_modal');
                form.find('#order_id').val(el.data('id'));
                form.find('#order_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });

            // Summernote setup
            $('.summernote').summernote({
                height: 400,
                codemirror: { theme: 'monokai' },
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

            // Category Language Dropdown (Add New Event)
            function loadCategories(selectedLang){
                $.ajax({
                    url: "{{route('admin.events.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">{{__("Select Category")}}</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            }
            loadCategories($('#language').val());
            $(document).on('change','#language',function(e){
                e.preventDefault();
                loadCategories($(this).val());
            });

            // Bulk actions - Events
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
                        'url' : "{{route('admin.events.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption
                        },
                        success:function (data) { location.reload(); }
                    });
                }
            });

            // Bulk actions - Category
            $(document).on('click','#bulk_delete_btn_cat',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_cat').val();
                var allCheckbox =  $('.bulk-checkbox-cat:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.events.category.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption,
                        },
                        success:function (data) { location.reload(); }
                    });
                }
            });

            // Bulk actions - Attendance
            $(document).on('click','#bulk_delete_btn_att',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_att').val();
                var allCheckbox =  $('.bulk-checkbox-att:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.event.attendance.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success:function (data) { location.reload(); }
                    });
                }
            });

            // Bulk actions - Payments
            $(document).on('click','#bulk_delete_btn_pay',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_pay').val();
                var allCheckbox =  $('.bulk-checkbox-pay:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption == 'delete'){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.event.payment.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds
                        },
                        success:function (data) { location.reload(); }
                    });
                }
            });

            // Select all checkbox
            $('.all-checkbox').on('change',function(e){
                $(this).closest('table').find('.bulk-checkbox').prop('checked', $(this).is(':checked'));
            });
            $('.all-checkbox-cat').on('change',function(e){
                $(this).closest('table').find('.bulk-checkbox-cat').prop('checked', $(this).is(':checked'));
            });
            $('.all-checkbox-att').on('change',function(e){
                $(this).closest('table').find('.bulk-checkbox-att').prop('checked', $(this).is(':checked'));
            });
            $('.all-checkbox-pay').on('change',function(e){
                $(this).closest('table').find('.bulk-checkbox-pay').prop('checked', $(this).is(':checked'));
            });

            // DataTables
            $('.all_event_table').DataTable({
                "order": [[ 1, "desc" ]],
                "columnDefs": [ { "targets": 'no-sort', "orderable": false } ]
            });
        });
    </script>
@endsection
