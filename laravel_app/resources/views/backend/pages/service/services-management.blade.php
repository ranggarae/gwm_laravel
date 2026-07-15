@extends('backend.admin-master')
@section('site-title')
    {{__('Services Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
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
                        <h4 class="header-title">{{__('Services Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="servicesTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-services-tab" data-toggle="tab" href="#all_services_panel" role="tab" aria-selected="true">{{__('All Services')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-service-tab" data-toggle="tab" href="#add_service_panel" role="tab" aria-selected="false">{{__('Add New Service')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories_panel" role="tab" aria-selected="false">{{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings_panel" role="tab" aria-selected="false">{{__('Single Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="servicesTabsContent">
                            <!-- All Services Tab -->
                            <div class="tab-pane fade show active" id="all_services_panel" role="tabpanel" aria-labelledby="all-services-tab">
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
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_services as $key => $service)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40" id="myTabContent">
                                    @php $b=0; @endphp
                                    @foreach($all_services as $key => $service)
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
                                                    <th>{{__('Icon')}}</th>
                                                    <th>{{__('Category')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Date')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($service as $data)
                                                    <tr>
                                                        <td>
                                                            <div class="bulk-checkbox-wrapper">
                                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->title}}</td>
                                                        <td>
                                                            @php $img_url = '';@endphp
                                                            @php
                                                                $service_section_img = get_attachment_image_by_id($data->image,null,true);
                                                                $img_url = '';
                                                            @endphp
                                                            @if (!empty($service_section_img))
                                                                <div class="attachment-preview">
                                                                    <div class="thumbnail">
                                                                        <div class="centered">
                                                                            <img class="avatar user-thumb" src="{{$service_section_img['img_url']}}" alt="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php  $img_url = $service_section_img['img_url']; @endphp
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($data->icon_type == 'icon' || $data->icon_type == '')
                                                                <i style="font-size: 40px;" class="{{$data->icon}}"></i>
                                                            @else
                                                                {!!  render_image_markup_by_attachment_id($data->img_icon) !!}
                                                            @endif
                                                        </td>
                                                        <td>{{get_service_category($data->categories_id)}}</td>
                                                        <td>{{date_format($data->created_at,'d/M/Y')}}</td>
                                                        <td>
                                                            @if($data->status == 'draft')
                                                                <span class="alert alert-warning" style="margin-top: 20px;display: inline-block;">{{__('Draft')}}</span>
                                                            @else
                                                                <span class="alert alert-success" style="margin-top: 20px;display: inline-block;">{{__('Publish')}}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a tabindex="0" class="btn btn-danger btn-xs"
                                                               role="button"
                                                               data-toggle="popover"
                                                               data-trigger="focus"
                                                               data-html="true"
                                                               title=""
                                                               data-content="
                                                       <h6>{{__('Are you sure to delete this service item ?')}}</h6>
                                                       <form method='post' action='{{route('admin.services.delete',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                        </form>
                                                        ">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                            <a href="{{route('admin.services.edit',$data->id)}}" class="btn-xs btn btn-primary">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                            <a href="{{route('frontend.services.single',$data->slug)}}" target="_blank" class="btn btn-xs btn-light">
                                                                <i class="ti-eye"></i>
                                                            </a>
                                                            <form action="{{route('admin.services.clone')}}" method="post" style="display: inline-block">
                                                                @csrf
                                                                <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                <button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary"><i class="far fa-copy"></i></button>
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

                            <!-- Add New Service Tab -->
                            <div class="tab-pane fade" id="add_service_panel" role="tabpanel" aria-labelledby="add-service-tab">
                                <form action="{{route('admin.services.new')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control"  id="title" name="title" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control"  id="slug" name="slug" placeholder="{{__('Slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="icon_type">{{__('Icon Type')}}</label>
                                                <select name="icon_type" class="form-control" id="icon_type">
                                                    <option value="icon">{{__('Font Icon')}}</option>
                                                    <option value="image">{{__('Image Icon')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group icon">
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
                                                <input type="hidden" class="form-control"  id="icon" name="icon" value="fas fa-exclamation-triangle">
                                            </div>
                                            <div class="form-group img-icon" style="display: none;">
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
                                                <label for="excerpt">{{__('Excerpt')}}</label>
                                                <textarea name="excerpt" id="excerpt" class="form-control" cols="30" rows="5" placeholder="{{__('Excerpt')}}"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">{{__('Category')}}</label>
                                                <select name="categories_id" class="form-control" id="category">
                                                    <option value="">{{__("Select Category")}}</option>
                                                    @foreach($service_category_flat as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="service_content" >
                                                <div class="summernote"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                                <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" id="meta_tags">
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
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Service Image" data-modaltitle="Upload Service Image" data-toggle="modal" data-target="#media_upload_modal">
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
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add Service')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Categories Tab -->
                            <div class="tab-pane fade" id="categories_panel" role="tabpanel" aria-labelledby="categories-tab">
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
                                        <ul class="nav nav-tabs" id="myTabCat" role="tablist">
                                            @php $ca=0; @endphp
                                            @foreach($all_category as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($ca == 0) active @endif"  data-toggle="tab" href="#cat_tab_{{$key}}" role="tab" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $ca++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-40" id="myTabContentCat">
                                            @php $cb=0; @endphp
                                            @foreach($all_category as $key => $category)
                                                <div class="tab-pane fade @if($cb == 0) show active @endif" id="cat_tab_{{$key}}" role="tabpanel" >
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
                                                        @foreach($category as $data)
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
                                                                       <form method='post' action='{{route('admin.service.category.delete',$data->id)}}'>
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
                                                <form action="{{route('admin.service.category')}}" method="post">
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
                                                        <label for="name">{{__('Name')}}</label>
                                                        <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Name')}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="icon_type">{{__('Icon Type')}}</label>
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
                                                        <input type="hidden" class="form-control"  id="icon" name="icon" value="fas fa-exclamation-triangle">
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
                                                        <label for="status">{{__('Status')}}</label>
                                                        <select name="status" class="form-control" id="status">
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

                            <!-- Single Settings Tab -->
                            <div class="tab-pane fade" id="settings_panel" role="tabpanel" aria-labelledby="settings-tab">
                                <form action="{{route('admin.services.single.page.settings')}}" method="POST">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-settings" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-settings-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30" id="nav-tabContent-settings">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-settings-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="service_single_page_{{$lang->slug}}_category_title">{{__('Category Sidebar Title')}}</label>
                                                    <input type="text" name="service_single_page_{{$lang->slug}}_category_title"  class="form-control" value="{{get_static_option('service_single_page_'.$lang->slug.'_category_title')}}" id="service_single_page_{{$lang->slug}}_category_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="service_single_page_{{$lang->slug}}_recent_services_title">{{__('Recent Services Sidebar Title')}}</label>
                                                    <input type="text" name="service_single_page_{{$lang->slug}}_recent_services_title"  class="form-control" value="{{get_static_option('service_single_page_'.$lang->slug.'_recent_services_title')}}" id="service_single_page_{{$lang->slug}}_recent_services_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="service_single_page_{{$lang->slug}}_search_placeholder_text">{{__('Search Placeholder Sidebar Text')}}</label>
                                                    <input type="text" name="service_single_page_{{$lang->slug}}_search_placeholder_text"  class="form-control" value="{{get_static_option('service_single_page_'.$lang->slug.'_search_placeholder_text')}}" id="service_single_page_{{$lang->slug}}_search_placeholder_text">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.service.category.update')}}"  method="post">
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
                            <input type="text" class="form-control"  id="edit_name" name="name" placeholder="{{__('Name')}}">
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
                            <input type="hidden" class="form-control"  id="edit_icon" name="icon" value="fas fa-exclamation-triangle">
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
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Keep active tab on refresh
            $('#servicesTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabServices', id);
            });
            var activeTab = window.localStorage.getItem('activeTabServices');
            if (activeTab) {
                $('#servicesTabs a[href="#' + activeTab + '"]').tab('show');
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

            // Handle Icon Type Select (Add Form)
            $(document).on('change','#icon_type',function (e) {
                e.preventDefault();
                var value = $(this).val();
                if(value == 'icon'){
                    $('.icon').show();
                    $('.img-icon').hide();
                }else{
                    $('.icon').hide();
                    $('.img-icon').show();
                }
            });
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

            // Ajax Category Filter by Lang
            $(document).on('change','#language',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.service.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">Select Category</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.name+'</option>')
                        });
                    }
                });
            });

            // Bulk Delete Services
            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.service.bulk.action')}}",
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

            // Bulk Delete Categories
            $(document).on('click','#bulk_delete_btn_cat',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_cat').val();
                var allCheckbox =  $('.bulk-checkbox-cat:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Deleting...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.service.category.bulk.action')}}",
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

            // Edit Category
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

            // Datatables
            $('.table-wrap > table').DataTable( {
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
    <script src="{{asset('assets/backend/js/fontawesome-iconpicker.min.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
