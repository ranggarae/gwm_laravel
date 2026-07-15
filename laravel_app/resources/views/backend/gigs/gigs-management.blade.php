@extends('backend.admin-master')
@section('site-title')
    {{__('Gigs Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
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
                        <h4 class="header-title">{{__('Gigs Management')}}</h4>

                        <ul class="nav nav-tabs" id="gigsTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all_gigs_panel" role="tab">{{__('All Gigs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#categories_panel" role="tab">{{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#orders_panel" role="tab">{{__('Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings_panel" role="tab">{{__('Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="gigsTabsContent">
                            {{-- All Gigs Tab --}}
                            <div class="tab-pane fade show active" id="all_gigs_panel" role="tabpanel">
                                <div class="mb-3">
                                    <a href="{{route('admin.gigs.new')}}" class="btn btn-primary">{{__('Add New Gig')}}</a>
                                </div>
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" id="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                            <option value="publish">{{{__('Publish')}}}</option>
                                            <option value="draft">{{{__('Draft')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" id="gigsLangTab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_gigs as $key => $job)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#gig_lang_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40">
                                    @php $b=0; @endphp
                                    @foreach($all_gigs as $key => $job)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="gig_lang_{{$key}}" role="tabpanel">
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
                                                    <th>{{__('Category')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($job as $data)
                                                        <tr>
                                                            <td>
                                                                <div class="bulk-checkbox-wrapper">
                                                                    <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                </div>
                                                            </td>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->title}}</td>
                                                            <td>{{get_gigs_category_by_id($data->category_id)}}</td>
                                                            <td>
                                                                @if($data->status == 'publish')
                                                                    <span class="alert alert-success" style="margin-top: 20px;display: inline-block;">{{__('Publish')}}</span>
                                                                @else
                                                                    <span class="alert alert-warning" style="margin-top: 20px;display: inline-block;">{{__('Draft')}}</span>
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
                                                                   <h6>{{__('Are you sure to delete this gig?')}}</h6>
                                                                   <form method='post' action='{{route('admin.gigs.delete',$data->id)}}'>
                                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                   <br>
                                                                    <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                    </form>
                                                                ">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-xs btn-primary mb-3 mr-1" href="{{route('admin.gigs.edit',$data->id)}}">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-xs btn-light mb-3 mr-1" target="_blank" href="{{route('frontend.gigs.single',$data->slug)}}">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <form action="{{route('admin.gigs.clone')}}" method="post" style="display: inline-block">
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

                            {{-- Categories Tab --}}
                            <div class="tab-pane fade" id="categories_panel" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="bulk-delete-wrapper">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option_cat" id="bulk_option_cat">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_cat">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs" id="catLangTab" role="tablist">
                                            @php $ca=0; @endphp
                                            @foreach($all_category as $key => $cats)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($ca == 0) active @endif" data-toggle="tab" href="#cat_lang_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $ca++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-40">
                                            @php $cb=0; @endphp
                                            @foreach($all_category as $key => $cats)
                                                <div class="tab-pane fade @if($cb == 0) show active @endif" id="cat_lang_{{$key}}" role="tabpanel">
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default">
                                                        <thead>
                                                        <th class="no-sort">
                                                            <div class="mark-all-checkbox">
                                                                <input type="checkbox" class="all-checkbox-cat">
                                                            </div>
                                                        </th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Name')}}</th>
                                                        <th>{{__('Icon')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($cats as $data)
                                                            <tr>
                                                                <td>
                                                                    <div class="bulk-checkbox-wrapper">
                                                                        <input type="checkbox" class="bulk-checkbox-cat" name="bulk_delete_cat[]" value="{{$data->id}}">
                                                                    </div>
                                                                </td>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->name}}</td>
                                                                <td>
                                                                    @if($data->icon_type == 'icon')
                                                                        <i class="{{$data->icon}}" style="font-size: 40px;"></i>
                                                                    @else
                                                                        {!! render_image_markup_by_attachment_id($data->img_icon) !!}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if('publish' == $data->status)
                                                                        <span class="btn btn-success btn-xs">{{ucfirst($data->status)}}</span>
                                                                    @else
                                                                        <span class="btn btn-warning btn-xs">{{ucfirst($data->status)}}</span>
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
                                                                       <h6>{{__('Are you sure to delete this category?')}}</h6>
                                                                       <form method='post' action='{{route('admin.gigs.category.delete',$data->id)}}'>
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
                                                                       data-name="{{$data->name}}"
                                                                       data-lang="{{$data->lang}}"
                                                                       data-status="{{$data->status}}"
                                                                       data-icon_type="{{$data->icon_type}}"
                                                                       data-icon="{{$data->icon}}"
                                                                       data-image="{{$data->img_icon}}"
                                                                       data-imageurl="{{get_attachment_image_by_id($data->img_icon,null,true)['img_url'] ?? ''}}"
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
                                                @php $cb++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__('Add New Category')}}</h4>
                                                <form action="{{route('admin.gigs.category')}}" method="post">
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
                                                        <label for="name">{{__('Name')}}</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="{{__('Name')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icon_type_add">{{__('Icon Type')}}</label>
                                                        <select name="icon_type" class="form-control" id="icon_type_add">
                                                            <option value="icon">{{__('Font Icon')}}</option>
                                                            <option value="image">{{__('Image Icon')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group icon_add">
                                                        <label for="icon" class="d-block">{{__('Icon')}}</label>
                                                        <div class="btn-group ">
                                                            <button type="button" class="btn btn-primary iconpicker-component">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </button>
                                                            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                                                    data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu"></div>
                                                        </div>
                                                        <input type="hidden" class="form-control" id="icon" name="icon" value="fas fa-exclamation-triangle">
                                                    </div>
                                                    <div class="form-group img_icon_add" style="display: none;">
                                                        <label for="img_icon">{{__('Image Icon')}}</label>
                                                        <div class="media-upload-btn-wrapper">
                                                            <div class="img-wrap"></div>
                                                            <input type="hidden" name="img_icon">
                                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                                                {{__('Upload Image')}}
                                                            </button>
                                                        </div>
                                                        <small>{{__('Recommended image size 60x60')}}</small>
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
                                </div>
                            </div>

                            {{-- Orders Tab --}}
                            <div class="tab-pane fade" id="orders_panel" role="tabpanel">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option_order" id="bulk_option_order">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_order">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default">
                                        <thead>
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox-order">
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
                                        @foreach($all_orders as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox-order" name="bulk_delete_order[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>
                                                    <div class="gig-order-info">
                                                        <ul>
                                                            <li><strong>{{__('Gig Name:')}}</strong> {{get_gig_name($data->gig_id)}}</li>
                                                            <li><strong>{{__('Package:')}}</strong> {{$data->selected_plan_title}}</li>
                                                            <li><strong>{{__('Price:')}}</strong> {{amount_with_currency_symbol($data->selected_plan_price)}}</li>
                                                            <li><strong>{{__('Payment:')}}</strong> <span class="@if($data->payment_status == 'complete') alert-success @else alert-warning @endif">{{ucwords($data->payment_status)}}</span></li>
                                                            <li><strong>{{__('Status:')}}</strong> <span class="@if($data->order_status == 'complete') alert-success @else alert-info @endif">{{ucwords(str_replace('_',' ',$data->order_status))}}</span></li>
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
                                                    ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="{{route('admin.gigs.orders.message',$data->id)}}" class="btn btn-primary btn-xs mb-3 mr-1">
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                    @if($data->selected_payment_gateway == 'manual_payment' && $data->payment_status == 'pending')
                                                        <a tabindex="0" class="btn btn-success btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                       <h6>{{__('Are you sure to approve this payment?')}}</h6>
                                                       <form method='post' action='{{route('admin.gig.payment.approve',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-success btn-sm' value='{{__('Yes,Approve')}}'>
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

                            {{-- Settings Tab --}}
                            <div class="tab-pane fade" id="settings_panel" role="tabpanel">
                                <h5 class="mb-3">{{__('Page Settings')}}</h5>
                                <form action="{{route('admin.gigs.page.settings')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="gig_page_items">{{__('Items Per Page')}}</label>
                                        <input type="text" name="gig_page_items" class="form-control" value="{{get_static_option('gig_page_items')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="gig_page_notify_email">{{__('Notify Email')}}</label>
                                        <input type="text" name="gig_page_notify_email" class="form-control" value="{{get_static_option('gig_page_notify_email')}}">
                                    </div>
                                    <button type="submit" class="btn btn-primary pr-4 pl-4">{{__('Update Page Settings')}}</button>
                                </form>

                                <hr class="mt-4 mb-4">
                                <h5 class="mb-3">{{__('Single Page Settings')}}</h5>
                                <form action="{{route('admin.gigs.single.page.settings')}}" method="POST">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-single" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-single-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-single-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>{{__('Order Button Title')}}</label>
                                                    <input type="text" name="gig_single_{{$lang->slug}}_order_button_title" class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_order_button_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Quote Title')}}</label>
                                                    <input type="text" name="gig_single_{{$lang->slug}}_quote_title" class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_quote_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Quote Button Title')}}</label>
                                                    <input type="text" name="gig_single_{{$lang->slug}}_quote_button_title" class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_quote_button_title')}}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary pr-4 pl-4">{{__('Update Single Page Settings')}}</button>
                                </form>

                                <hr class="mt-4 mb-4">
                                <h5 class="mb-3">{{__('Success Page Settings')}}</h5>
                                <form action="{{route('admin.gigs.success.page.settings')}}" method="POST">
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
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_title" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Gig Name Title')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_name_title" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_name_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Order Date Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_order_date_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_order_date_text')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Delivery Date Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_order_delivery_date_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_order_delivery_date_text')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Total Revisions Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_total_revisions_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_total_revisions_text')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Payment Gateway Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_payment_gateway_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_payment_gateway_text')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Payment Status Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_payment_status_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_payment_status_text')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Ordered Plan Text')}}</label>
                                                    <input type="text" name="gig_order_success_page_{{$lang->slug}}_gig_ordered_plan_text" class="form-control" value="{{get_static_option('gig_order_success_page_'.$lang->slug.'_gig_ordered_plan_text')}}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary pr-4 pl-4">{{__('Update Success Page')}}</button>
                                </form>

                                <hr class="mt-4 mb-4">
                                <h5 class="mb-3">{{__('Cancel Page Settings')}}</h5>
                                <form action="{{route('admin.gigs.cancel.page.settings')}}" method="POST">
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
                                                    <input type="text" name="gig_order_cancel_page_{{$lang->slug}}_title" class="form-control" value="{{get_static_option('gig_order_cancel_page_'.$lang->slug.'_title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Description')}}</label>
                                                    <textarea name="gig_order_cancel_page_{{$lang->slug}}_description" class="form-control" rows="5">{{get_static_option('gig_order_cancel_page_'.$lang->slug.'_description')}}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary pr-4 pl-4">{{__('Update Cancel Page')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gigs.category.update')}}" method="post">
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
                            <input type="text" class="form-control" id="edit_name" name="name" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon_type">{{__('Icon Type')}}</label>
                            <select name="icon_type" class="form-control" id="edit_icon_type">
                                <option value="icon">{{__('Font Icon')}}</option>
                                <option value="image">{{__('Image Icon')}}</option>
                            </select>
                        </div>
                        <div class="form-group edit_icon">
                            <label for="edit_icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group ">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control" id="edit_icon" name="icon" value="fas fa-exclamation-triangle">
                        </div>
                        <div class="form-group edit_img_icon" style="display: none;">
                            <label for="edit_img_icon">{{__('Image Icon')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" name="img_icon" id="edit_img_icon">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('Recommended image size 60x60')}}</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="publish">{{__("Publish")}}</option>
                                <option value="draft">{{__("Draft")}}</option>
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

    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tab persistence
            $('#gigsTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#gigsTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabGigs', id);
            });
            var activeTab = window.localStorage.getItem('activeTabGigs');
            if (activeTab) {
                $('#gigsTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // Bulk actions - gigs
            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allCheckbox = $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.gigs.bulk.action')}}",
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
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Bulk actions - categories
            $(document).on('click','#bulk_delete_btn_cat',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_cat').val();
                var allCheckbox = $('.bulk-checkbox-cat:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.gigs.category.bulk.action')}}",
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

            $('.all-checkbox-cat').on('change',function (e) {
                e.preventDefault();
                var value = $(this).is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox-cat');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Bulk actions - orders
            $(document).on('click','#bulk_delete_btn_order',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_order').val();
                var allCheckbox = $('.bulk-checkbox-order:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.gig.order.bulk.action')}}",
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

            $('.all-checkbox-order').on('change',function (e) {
                e.preventDefault();
                var value = $(this).is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox-order');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Icon type toggle
            $(document).on('change','#icon_type_add',function (e) {
                e.preventDefault();
                var value = $(this).val();
                if(value == 'icon'){
                    $('.icon_add').show();
                    $('.img_icon_add').hide();
                }else{
                    $('.icon_add').hide();
                    $('.img_icon_add').show();
                }
            });
            $(document).on('change','#edit_icon_type',function (e) {
                e.preventDefault();
                var value = $(this).val();
                if(value == 'icon'){
                    $('.edit_icon').show();
                    $('.edit_img_icon').hide();
                }else{
                    $('.edit_icon').hide();
                    $('.edit_img_icon').show();
                }
            });

            // Edit Category Modal
            $(document).on('click','.category_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var status = el.data('status');
                var iconType = el.data('icon_type');
                var icon = el.data('icon');
                var image = el.data('image');
                var imageUrl = el.data('imageurl');

                var modal = $('#category_edit_modal');
                modal.find('#category_id').val(id);
                modal.find('#edit_name').val(name);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
                modal.find('#edit_icon_type option[value="'+iconType+'"]').attr('selected',true);

                if(iconType == 'image'){
                    modal.find('.edit_icon').hide();
                    modal.find('.edit_img_icon').show();
                    if(imageUrl != ''){
                        modal.find('.img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+imageUrl+'" ></div></div></div>');
                    }
                    modal.find('#edit_img_icon').val(image);
                }else{
                    modal.find('.edit_icon').show();
                    modal.find('.edit_img_icon').hide();
                    modal.find('.iconpicker-component i').attr('class',icon);
                    modal.find('#edit_icon').val(icon);
                }
            });

            // Icon Pickers
            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
            });

            // DataTables
            $('.table-wrap > table').DataTable({
                "order": [[ 1, "desc" ]],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/fontawesome-iconpicker.min.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
