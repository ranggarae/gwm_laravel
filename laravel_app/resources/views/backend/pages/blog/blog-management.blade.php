@extends('backend.admin-master')
@section('site-title')
    {{__('Blog Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
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
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #A16207; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; }
        .tab-content { padding-top: 10px; }
        
        .language-tabs { margin-bottom: 15px; }
        .language-tabs .nav-link { padding: 8px 16px; font-size: 14px; }
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
                        <h4 class="header-title">{{__('Blog Management')}}</h4>

                        <ul class="nav nav-tabs" id="blogManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-blogs-tab" data-toggle="tab" href="#all-blogs" role="tab" aria-selected="true">{{__('All Blogs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-blog-tab" data-toggle="tab" href="#add-new-blog" role="tab" aria-selected="false">{{__('Add New Blog')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-selected="false">{{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="blog-page-settings-tab" data-toggle="tab" href="#blog-page-settings" role="tab" aria-selected="false">{{__('Blog Page Settings')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="blog-single-page-settings-tab" data-toggle="tab" href="#blog-single-page-settings" role="tab" aria-selected="false">{{__('Blog Single Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="blogManagementTabContent">
                            
                            <!-- TAB 1: All Blogs -->
                            <div class="tab-pane fade show active" id="all-blogs" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                            <option value="publish">{{{__('Publish')}}}</option>
                                            <option value="draft">{{{__('Draft')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs language-tabs" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_blog as $key => $blog)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#slider_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-30">
                                    @php $b=0; @endphp
                                    @foreach($all_blog as $key => $blog)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel">
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default all_blog_table">
                                                    <thead>
                                                        <th class="no-sort">
                                                            <div class="mark-all-checkbox">
                                                                <input type="checkbox" class="all-checkbox">
                                                            </div>
                                                        </th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Title')}}</th>
                                                        <th>{{__('Image')}}</th>
                                                        <th>{{__('Posted By')}}</th>
                                                        <th>{{__('Category')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Date')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($blog as $data)
                                                            <tr>
                                                                <td>
                                                                    <div class="bulk-checkbox-wrapper">
                                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                    </div>
                                                                </td>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->title}}</td>
                                                                <td>
                                                                    @php
                                                                        $blog_img = get_attachment_image_by_id($data->image,null,true);
                                                                    @endphp
                                                                    @if (!empty($blog_img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail">
                                                                                <div class="centered">
                                                                                    <img class="avatar user-thumb" src="{{$blog_img['img_url']}}" alt="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>{{$data->user->name ?? ''}}</td>
                                                                <td>{{get_blog_category_by_id($data->id)}}</td>
                                                                <td>
                                                                    @if($data->status == 'publish')
                                                                        <span class="badge badge-success">{{__('Publish')}}</span>
                                                                    @else
                                                                        <span class="badge badge-warning">{{__('Draft')}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{date_format($data->created_at,'d m Y')}}</td>
                                                                <td>
                                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                        <h6>{{__('Are you sure to delete this blog post?')}}</h6>
                                                                        <form method='post' action='{{route('admin.blog.delete',$data->id)}}'>
                                                                        <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                        <br>
                                                                        <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                        </form>
                                                                    ">
                                                                        <i class="ti-trash"></i>
                                                                    </a>
                                                                    <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.blog.edit',$data->id)}}">
                                                                        <i class="ti-pencil"></i>
                                                                    </a>
                                                                    <a class="btn btn-light btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.blog.single', $data->slug)}}">
                                                                        <i class="ti-eye"></i>
                                                                    </a>
                                                                    <form action="{{route('admin.blog.clone')}}" method="post" style="display: inline-block">
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

                            <!-- TAB 2: Add New Blog -->
                            <div class="tab-pane fade" id="add-new-blog" role="tabpanel">
                                <form action="{{route('admin.blog.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
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
                                                <input type="text" class="form-control" id="title" name="title" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="blog_content">
                                                <div class="summernote"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                                <input type="text" name="meta_tags" class="form-control" data-role="tagsinput" id="meta_tags">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description">{{__('Meta Description')}}</label>
                                                <textarea name="meta_description" class="form-control" rows="5" id="meta_description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control" id="slug" name="slug" placeholder="{{__('Slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="excerpt">{{__('Excerpt')}}</label>
                                                <textarea name="excerpt" id="excerpt" class="form-control max-height-150" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">{{__('Category')}}</label>
                                                <select name="category" class="form-control" id="category">
                                                    <option value="">{{__("Select Category")}}</option>
                                                    @foreach($all_category as $cat_group)
                                                        @foreach($cat_group as $category)
                                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tags">{{__('Tags')}}</label>
                                                <input type="text" class="form-control" name="tags" data-role="tagsinput">
                                            </div>
                                            <div class="form-group">
                                                <label for="author">{{__('Author Name')}}</label>
                                                <input type="text" class="form-control" name="author" id="author">
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="image">{{__('Image')}}</label>
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap"></div>
                                                    <input type="hidden" name="image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Blog Image" data-modaltitle="Upload Blog Image" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__('Upload Image')}}
                                                    </button>
                                                </div>
                                                <small>{{__('Recommended image size 1920x1280')}}</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Post')}}</button>
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
                                            @foreach($all_category as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#cat_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-30">
                                            @php $b=0; @endphp
                                            @foreach($all_category as $key => $category)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="cat_tab_{{$key}}" role="tabpanel">
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default all_blog_table">
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
                                                                        <td>{{$data->name}}</td>
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
                                                                                <form method='post' action='{{route('admin.blog.category.delete',$data->id)}}'>
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
                                        <form action="{{route('admin.blog.category')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="cat_name" name="name" placeholder="{{__('Name')}}">
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

                            <!-- TAB 4: Blog Page Settings -->
                            <div class="tab-pane fade" id="blog-page-settings" role="tabpanel">
                                <form action="{{route('admin.blog.page')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="nav nav-tabs language-tabs" role="tablist">
                                        @foreach($all_languages as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#blog-page-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="blog-page-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="blog_page_{{$lang->slug}}_title">{{__('Page Title')}}</label>
                                                    <input type="text" class="form-control" id="blog_page_{{$lang->slug}}_title" value="{{get_static_option('blog_page_'.$lang->slug.'_title')}}" name="blog_page_{{$lang->slug}}_title" placeholder="{{__('Page Title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_page_{{$lang->slug}}_item">{{__('Post Item')}}</label>
                                                    <input type="text" class="form-control" id="blog_page_{{$lang->slug}}_item" value="{{get_static_option('blog_page_'.$lang->slug.'_item')}}" name="blog_page_{{$lang->slug}}_item" placeholder="{{__('Post Item')}}">
                                                    <small class="text-danger">{{__('Enter how many post you want to show in blog page')}}</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_page_{{$lang->slug}}_category_widget_title">{{__('Category Widget Title')}}</label>
                                                    <input type="text" class="form-control" id="blog_page_{{$lang->slug}}_category_widget_title" value="{{get_static_option('blog_page_'.$lang->slug.'_category_widget_title')}}" name="blog_page_{{$lang->slug}}_category_widget_title" placeholder="{{__('Category Widget Title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_page_{{$lang->slug}}_recent_post_widget_title">{{__('Recent Post Widget Title')}}</label>
                                                    <input type="text" class="form-control" id="blog_page_{{$lang->slug}}_recent_post_widget_title" name="blog_page_{{$lang->slug}}_recent_post_widget_title" value="{{get_static_option('blog_page_'.$lang->slug.'_recent_post_widget_title')}}" placeholder="{{__('Recent Post Widget Title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_page_{{$lang->slug}}_recent_post_widget_item">{{__('Recent Post Widget Item')}}</label>
                                                    <input type="text" class="form-control" id="blog_page_{{$lang->slug}}_recent_post_widget_item" name="blog_page_{{$lang->slug}}_recent_post_widget_item" value="{{get_static_option('blog_page_'.$lang->slug.'_recent_post_widget_item')}}" placeholder="{{__('Recent Post Widget Item')}}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>
                            </div>

                            <!-- TAB 5: Blog Single Page Settings -->
                            <div class="tab-pane fade" id="blog-single-page-settings" role="tabpanel">
                                <form action="{{route('admin.blog.single.page')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="nav nav-tabs language-tabs" role="tablist">
                                        @foreach($all_languages as $key => $lang)
                                            <li class="nav-item">
                                                <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#blog-single-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="blog-single-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="blog_single_page_{{$lang->slug}}_related_post_title">{{__('Related Post Title')}}</label>
                                                    <input type="text" class="form-control" id="blog_single_page_{{$lang->slug}}_related_post_title" value="{{get_static_option('blog_single_page_'.$lang->slug.'_related_post_title')}}" name="blog_single_page_{{$lang->slug}}_related_post_title" placeholder="{{__('Related Post Title')}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_single_page_{{$lang->slug}}_tag_title">{{__('Tags Title')}}</label>
                                                    <input type="text" class="form-control" value="{{get_static_option('blog_single_page_'.$lang->slug.'_tag_title')}}" name="blog_single_page_{{$lang->slug}}_tag_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="blog_single_page_{{$lang->slug}}_share_title">{{__('Share Title')}}</label>
                                                    <input type="text" class="form-control" value="{{get_static_option('blog_single_page_'.$lang->slug.'_share_title')}}" name="blog_single_page_{{$lang->slug}}_share_title">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
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
                <form action="{{route('admin.blog.category.update')}}" method="post">
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
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
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
                localStorage.setItem('activeBlogTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeBlogTab');
            if(activeTab){
                $('#blogManagementTab a[href="' + activeTab + '"]').tab('show');
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

            // Summernote setup
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
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }

            // Category Language Dropdown
            $(document).on('change','#language',function(e){
               e.preventDefault();
               var selectedLang = $(this).val();
               $.ajax({
                  url: "{{route('admin.blog.lang.cat')}}",
                  type: "POST",
                  data: {
                      _token : "{{csrf_token()}}",
                      lang : selectedLang
                  },
                  success:function (data) {
                      $('#category').html('<option value="">{{__("Select Category")}}</option>');
                      $.each(data,function(index,value){
                          $('#category').append('<option value="'+value.id+'">'+value.name+'</option>')
                      });
                  }
               });
            });

            // Bulk actions - Blog
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
                        'url' : "{{route('admin.blog.bulk.action')}}",
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
                        'url' : "{{route('admin.blog.category.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption,
                        },
                        success:function (data) {
                            location.reload();
                        }
                    });
                }
            });

            // Select all checkbox
            $('.all-checkbox').on('change',function (e) {
                e.preventDefault();
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).closest('table').find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            $('.all-checkbox-cat').on('change',function (e) {
                e.preventDefault();
                var value = $('.all-checkbox-cat').is(':checked');
                var allChek = $(this).closest('table').find('.bulk-checkbox-cat');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // DataTables
            $('.table-wrap > table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            });
        });
    </script>
@endsection
