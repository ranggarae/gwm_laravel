@extends('backend.admin-master')
@section('site-title')
    {{__('Works Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
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
                        <h4 class="header-title">{{__('Works Management')}}</h4>

                        <ul class="nav nav-tabs" id="worksTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all_works_panel" role="tab">{{__('All Works')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#add_work_panel" role="tab">{{__('Add New Work')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#categories_panel" role="tab">{{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#page_settings_panel" role="tab">{{__('Page Settings')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#single_settings_panel" role="tab">{{__('Single Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="worksTabsContent">
                            {{-- All Works Tab --}}
                            <div class="tab-pane fade show active" id="all_works_panel" role="tabpanel">
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
                                <ul class="nav nav-tabs" id="worksLangTab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_works as $key => $work)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#work_lang_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40">
                                    @php $b=0; @endphp
                                    @foreach($all_works as $key => $work)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="work_lang_{{$key}}" role="tabpanel">
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
                                                <th>{{__('Category')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($work as $data)
                                                    <tr>
                                                        <td>
                                                            <div class="bulk-checkbox-wrapper">
                                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->title}}</td>
                                                        <td>
                                                            {!! render_attachment_preview($data->image,'',true) !!}
                                                        </td>
                                                        <td>
                                                            {!! get_work_category_by_id($data->id,'string') !!}
                                                        </td>
                                                        <td>
                                                            @if($data->status == 'draft' || empty($data->status))
                                                                <div class="alert alert-warning" style="display: inline-block;">{{__('Draft')}}</div>
                                                            @elseif($data->status == 'publish')
                                                                <div class="alert alert-success" style="display: inline-block;">{{ucwords($data->status)}}</div>
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
                                                               <h6>{{__('Are you sure to delete this work item ?')}}</h6>
                                                               <form method='post' action='{{route('admin.work.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-sm' value='Yes,Please'>
                                                                </form>
                                                                ">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                            <a href="{{route('admin.work.edit',$data->id)}}" class="btn btn-lg btn-light btn-xs mb-3 mr-1">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-lg btn-primary btn-xs mb-3 mr-1" target="_blank"
                                                               href="{{route('frontend.work.single',$data->slug)}}">
                                                                <i class="ti-eye"></i>
                                                            </a>
                                                            <form action="{{route('admin.work.clone')}}" method="post" style="display:inline-block">
                                                                @csrf
                                                                <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                <button type="submit" title="{{__('clone this to new draft')}}" class="btn btn-xs btn-secondary btn-sm mb-3 mr-1">
                                                                    <i class="far fa-copy"></i>
                                                                </button>
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

                            {{-- Add New Work Tab --}}
                            <div class="tab-pane fade" id="add_work_panel" role="tabpanel">
                                <form action="{{route('admin.work.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="language">{{__('Language')}}</label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $language)
                                                <option value="{{$language->slug}}">{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="{{__('Title')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">{{__('Slug')}}</label>
                                        <input type="text" class="form-control" name="slug" placeholder="{{__('Slug')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{__('Description')}}</label>
                                        <input type="hidden" name="description" id="description">
                                        <div class="summernote"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="clients">{{__('Clients')}}</label>
                                        <input type="text" class="form-control" id="clients" name="clients" placeholder="{{__('Clients')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">{{__('Start Date')}}</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="{{__('Start Date')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">{{__('End Date')}}</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="{{__('End Date')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="categories_id">{{__('Category')}}</label>
                                        <select name="categories_id[]" multiple id="category" class="form-control nice-select wide">
                                            <option value="">{{__('Select Category')}}</option>
                                            @foreach($works_category as $data)
                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags">{{__('Meta Tags')}}</label>
                                        <input type="text" name="meta_tags" class="form-control" data-role="tagsinput">
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
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Work Image" data-modaltitle="Upload Work Image" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__('Upload Image')}}
                                            </button>
                                        </div>
                                        <small>{{__('Recommended image size 1920x1280')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{__('Gallery')}}</label>
                                        <div class="media-upload-btn-wrapper gallery">
                                            <div class="img-wrap"></div>
                                            <input type="hidden" name="gallery">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
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
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add work')}}</button>
                                </form>
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
                                            @foreach($all_category as $key => $cate)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($ca == 0) active @endif" data-toggle="tab" href="#cat_lang_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $ca++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-40">
                                            @php $cb=0; @endphp
                                            @foreach($all_category as $key => $cate)
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
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($cate as $data)
                                                            <tr>
                                                                <td>
                                                                    <div class="bulk-checkbox-wrapper">
                                                                        <input type="checkbox" class="bulk-checkbox-cat" name="bulk_delete_cat[]" value="{{$data->id}}">
                                                                    </div>
                                                                </td>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->name}}</td>
                                                                <td>
                                                                    @if('publish' == $data->status)
                                                                        <span class="btn btn-success btn-sm">{{ucfirst($data->status)}}</span>
                                                                    @else
                                                                        <span class="btn btn-warning btn-sm">{{ucfirst($data->status)}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                                                       role="button"
                                                                       data-toggle="popover"
                                                                       data-trigger="focus"
                                                                       data-html="true"
                                                                       title=""
                                                                       data-content="
                                                                       <h6>{{__('Are you sure to delete this category item?')}}</h6>
                                                                       <form method='post' action='{{route('admin.work.category.delete',$data->id)}}'>
                                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                       <br>
                                                                        <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                                        </form>
                                                                        ">
                                                                        <i class="ti-trash"></i>
                                                                    </a>
                                                                    <a href="#"
                                                                       data-toggle="modal"
                                                                       data-target="#category_edit_modal"
                                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 category_edit_btn"
                                                                       data-id="{{$data->id}}"
                                                                       data-name="{{$data->name}}"
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
                                                @php $cb++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__('Add New Category')}}</h4>
                                                <form action="{{route('admin.work.category')}}" method="post">
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
                                                        <label for="cat_status">{{__('Status')}}</label>
                                                        <select name="status" class="form-control" id="cat_status">
                                                            <option value="draft">{{__("Draft")}}</option>
                                                            <option value="publish">{{__("Publish")}}</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Page Settings Tab --}}
                            <div class="tab-pane fade" id="page_settings_panel" role="tabpanel">
                                <form action="{{route('admin.work.page.settings')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-page" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-page-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-page-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="work_page_{{$lang->slug}}_all_cat_text">{{__('All Text')}}</label>
                                                    <input type="text" name="work_page_{{$lang->slug}}_all_cat_text" value="{{get_static_option('work_page_'.$lang->slug.'_all_cat_text')}}" class="form-control">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="work_page_items">{{__('Items')}}</label>
                                        <input type="text" name="work_page_items" value="{{get_static_option('work_page_items')}}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>
                            </div>

                            {{-- Single Page Settings Tab --}}
                            <div class="tab-pane fade" id="single_settings_panel" role="tabpanel">
                                <form action="{{route('admin.work.single.page.settings')}}" method="post" enctype="multipart/form-data">
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
                                                    <label for="work_single_page_{{$lang->slug}}_related_work_title">{{__('Related Work Title')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_related_work_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_related_work_title')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_sidebar_title">{{__('Sidebar Title')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_sidebar_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_sidebar_title')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_start_date_text">{{__('Start Date Text')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_start_date_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_start_date_text')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_end_date_text">{{__('End Date Text')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_end_date_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_end_date_text')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_clients_text">{{__('Clients Text')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_clients_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_clients_text')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_category_text">{{__('Category Text')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_category_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_category_text')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_share_text">{{__('Share Text')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_share_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_share_text')}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="work_single_page_{{$lang->slug}}_gallery_title">{{__('Gallery Title')}}</label>
                                                    <input type="text" name="work_single_page_{{$lang->slug}}_gallery_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_gallery_title')}}" class="form-control">
                                                </div>
                                            </div>
                                        @endforeach
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

    {{-- Edit Category Modal --}}
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.work.category.update')}}" method="post">
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

    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tab persistence
            $('#worksTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#worksTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabWorks', id);
            });
            var activeTab = window.localStorage.getItem('activeTabWorks');
            if (activeTab) {
                $('#worksTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // Summernote
            $('.summernote').summernote({
                height: 250,
                codemirror: { theme: 'monokai' },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }

            // Language change => filter categories
            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#category').html('');
                        $.each(data,function (index,value) {
                            $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('.nice-select').niceSelect('update');
                        });
                    }
                });
            });

            // Bulk actions - works
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
                        'url' : "{{route('admin.work.bulk.action')}}",
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
                        'url' : "{{route('admin.work.category.bulk.action')}}",
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

            // Edit Category Modal
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
    @include('backend.partials.media-upload.media-js')
@endsection
