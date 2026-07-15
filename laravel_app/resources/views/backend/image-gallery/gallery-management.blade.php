@extends('backend.admin-master')
@section('site-title')
    {{__('Gallery Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button { padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; white-space: nowrap; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #10b981; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; }
        .nav-tabs::-webkit-scrollbar { height: 4px; }
        .nav-tabs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
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
                        <h4 class="header-title">{{__('Gallery Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="galleryTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#gallery-images" role="tab">{{__('Gallery Images')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#gallery-categories" role="tab">{{__('Categories')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="galleryTabContent">
                            <!-- TAB: Gallery Images -->
                            <div class="tab-pane fade show active" id="gallery-images" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8 border-right">
                                        <h4 class="header-title">{{__('Image Gallery')}}</h4>
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option" id="bulk_option_gallery" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_gallery">{{__('Apply')}}</button>
                                            </div>
                                        </div>

                                        <ul class="nav nav-tabs" id="langTabGallery" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach($all_gallery_images as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#slider_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>

                                        <div class="tab-content margin-top-40" id="langTabGalleryContent">
                                            @php $b=0; @endphp
                                            @foreach($all_gallery_images as $key => $items)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel">
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default">
                                                            <thead>
                                                                <th class="no-sort">
                                                                    <div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div>
                                                                </th>
                                                                <th>{{__('ID')}}</th>
                                                                <th>{{__('Name')}}</th>
                                                                <th>{{__('Image')}}</th>
                                                                <th>{{__('Status')}}</th>
                                                                <th>{{__('Action')}}</th>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($items as $data)
                                                                <tr>
                                                                    <td>
                                                                        <div class="bulk-checkbox-wrapper">
                                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$data->id}}</td>
                                                                    <td>{{$data->title}}</td>
                                                                    <td>{!! render_attachment_preview($data->image) !!}</td>
                                                                    <td>
                                                                        @if('publish' == $data->status)
                                                                            <span class="btn btn-success btn-xs">{{ucfirst($data->status)}}</span>
                                                                        @else
                                                                            <span class="btn btn-warning btn-xs">{{ucfirst($data->status)}}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                           <h6>{{__('Are you sure to delete this image?')}}</h6>
                                                                           <form method='post' action='{{route('admin.gallery.delete',$data->id)}}'>
                                                                           <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                           <br>
                                                                            <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                            </form>
                                                                            ">
                                                                            <i class="ti-trash"></i>
                                                                        </a>
                                                                        <a href="#" data-toggle="modal" data-target="#gallery_item_edit_modal" class="btn btn-primary btn-xs mb-3 mr-1 gallery_edit_btn"
                                                                           data-id="{{$data->id}}"
                                                                           data-title="{{$data->title}}"
                                                                           data-lang="{{$data->lang}}"
                                                                           data-status="{{$data->status}}"
                                                                           data-catId="{{$data->category_id}}"
                                                                           data-imageid="{{$data->image}}"
                                                                           @php
                                                                               $testimonial_img = get_attachment_image_by_id($data->image,null,true);
                                                                               $img_url = !empty($testimonial_img) ? $testimonial_img['img_url'] : '';
                                                                           @endphp
                                                                           data-image="{{$img_url}}"
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

                                    <div class="col-lg-4 pl-4">
                                        <h4 class="header-title">{{__('Add New Image')}}</h4>
                                        <form action="{{route('admin.gallery.new')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="language">{{__('Language')}}</label>
                                                <select name="lang" class="form-control" id="language">
                                                    @foreach($all_languages as $data)
                                                        <option value="{{$data->slug}}">{{$data->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">{{__('Title')}}</label>
                                                <input type="text" name="title" id="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="image">{{__('Image')}}</label>
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap"></div>
                                                    <input type="hidden" name="image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__('Upload Image')}}
                                                    </button>
                                                </div>
                                                <small>{{__('1000x1000 px image recommended')}}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="category_id">{{__('Category')}}</label>
                                                <select name="category_id" class="form-control" id="category_id">
                                                    @foreach($all_category as $data)
                                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="publish">{{__("Publish")}}</option>
                                                    <option value="draft">{{__("Draft")}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Image')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: Gallery Categories -->
                            <div class="tab-pane fade" id="gallery-categories" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8 border-right">
                                        <h4 class="header-title">{{__('All Image Gallery Categories')}}</h4>
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option" id="bulk_option_category" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_category">{{__('Apply')}}</button>
                                            </div>
                                        </div>

                                        <ul class="nav nav-tabs" id="langTabCategory" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach($all_categories_list as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#category_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>

                                        <div class="tab-content margin-top-40" id="langTabCategoryContent">
                                            @php $b=0; @endphp
                                            @foreach($all_categories_list as $key => $category)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="category_tab_{{$key}}" role="tabpanel" >
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default">
                                                            <thead>
                                                                <th class="no-sort">
                                                                    <div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div>
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
                                                                            <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$data->id}}</td>
                                                                    <td>{{$data->title}}</td>
                                                                    <td>
                                                                        @if('publish' == $data->status)
                                                                            <span class="btn btn-success btn-xs">{{ucfirst($data->status)}}</span>
                                                                        @else
                                                                            <span class="btn btn-warning btn-xs">{{ucfirst($data->status)}}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                           <h6>{{__('Are you sure to delete this category?')}}</h6>
                                                                           <form method='post' action='{{route('admin.gallery.category.delete',$data->id)}}'>
                                                                           <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                           <br>
                                                                            <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                            </form>
                                                                            ">
                                                                            <i class="ti-trash"></i>
                                                                        </a>
                                                                        <a href="#" data-toggle="modal" data-target="#gallery_category_edit_modal" class="btn btn-primary btn-xs mb-3 mr-1 category_edit_btn"
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

                                    <div class="col-lg-4 pl-4">
                                        <h4 class="header-title">{{__('Add New Category')}}</h4>
                                        <form action="{{route('admin.gallery.category')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="name" name="title" placeholder="{{__('Name')}}">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Gallery Modal -->
    <div class="modal fade" id="gallery_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Gallery Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gallery.update')}}" id="gallery_edit_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_language_gallery">{{__('Language')}}</label>
                            <select name="lang" class="form-control" id="edit_language_gallery">
                                @foreach($all_languages as $data)
                                    <option value="{{$data->slug}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="id" id="gallery_id" value="">
                        <div class="form-group">
                            <label for="edit_title_gallery">{{__('Title')}}</label>
                            <input type="text" name="title" id="edit_title_gallery" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" id="edit_image_gallery" name="image" value="">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('1000x1000 px image recommended')}}</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_id_gallery">{{__('Category')}}</label>
                            <select name="category_id" class="form-control" id="edit_category_id_gallery">
                                @foreach($all_category as $data)
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status_gallery">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status_gallery">
                                <option value="publish">{{__("Publish")}}</option>
                                <option value="draft">{{__("Draft")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="gallery_category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gallery.category.update')}}" id="gallery_category_edit_form" method="post">
                    <input type="hidden" name="id" id="category_id_edit">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_language_cat">{{__('Language')}}</label>
                            <select name="lang" id="edit_language_cat" class="form-control">
                                @foreach($all_languages as $language)
                                    <option value="{{$language->slug}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_name_cat">{{__('Name')}}</label>
                            <input type="text" class="form-control" id="edit_name_cat" name="title" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_status_cat">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status_cat">
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
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Tab Persistence
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                var target = $(e.target).attr('href');
                if (target.startsWith('#slider_tab_')) {
                    localStorage.setItem('activeGalleryLangTab', target);
                } else if (target.startsWith('#category_tab_')) {
                    localStorage.setItem('activeGalleryCategoryLangTab', target);
                } else {
                    localStorage.setItem('activeGalleryTab', target);
                }
            });

            var activeTab = localStorage.getItem('activeGalleryTab');
            if(activeTab){
                $('#galleryTab a[href="' + activeTab + '"]').tab('show');
            }
            var activeLangTab = localStorage.getItem('activeGalleryLangTab');
            if(activeLangTab){
                $('#langTabGallery a[href="' + activeLangTab + '"]').tab('show');
            }
            var activeCatLangTab = localStorage.getItem('activeGalleryCategoryLangTab');
            if(activeCatLangTab){
                $('#langTabCategory a[href="' + activeCatLangTab + '"]').tab('show');
            }

            $('.table-wrap > table').DataTable({
                "order": [[1, "desc"]],
                "columnDefs": [ { "targets": 'no-sort', "orderable": false } ]
            });

            // Gallery Bulk Action
            $(document).on('click', '#bulk_delete_btn_gallery', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_gallery').val();
                var allCheckbox = $('#gallery-images .bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function (index, value) {
                    allIds.push($(this).val());
                });
                if (allIds != '') {
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type': "POST",
                        'url': "{{route('admin.gallery.bulk.action')}}",
                        'data': {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            });

            // Category Bulk Action
            $(document).on('click', '#bulk_delete_btn_category', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_category').val();
                var allCheckbox = $('#gallery-categories .bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function (index, value) {
                    allIds.push($(this).val());
                });
                if (allIds != '') {
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type': "POST",
                        'url': "{{route('admin.gallery.category.bulk.action')}}",
                        'data': {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox').on('change', function (e) {
                e.preventDefault();
                var value = $(this).is(':checked');
                var allChek = $(this).closest('table').find('.bulk-checkbox');
                if (value == true) {
                    allChek.prop('checked', true);
                } else {
                    allChek.prop('checked', false);
                }
            });

            // Edit Gallery Click
            $(document).on('click', '.gallery_edit_btn', function () {
                var el = $(this);
                var id = el.data('id');
                var image = el.data('image');
                var imageid = el.data('imageid');

                change_category_by_lang(el.data('lang'), '#edit_category_id_gallery', el.data('catid'));

                var form = $('#gallery_edit_form');
                form.find('#gallery_id').val(id);
                form.find('#edit_title_gallery').val(el.data('title'));
                form.find('#edit_status_gallery option[value="' + el.data('status') + '"]').attr('selected', true);
                form.find('#edit_language_gallery option[value="' + el.data('lang') + '"]').attr('selected', true);

                if (imageid != '') {
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="' + image + '" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                } else {
                    form.find('.media-upload-btn-wrapper .img-wrap').html('');
                    form.find('.media-upload-btn-wrapper input').val('');
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Upload Image');
                }
            });

            // Edit Category Click
            $(document).on('click', '.category_edit_btn', function () {
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var status = el.data('status');
                var form = $('#gallery_category_edit_form');

                form.find('#category_id_edit').val(id);
                form.find('#edit_status_cat option[value="'+status+'"]').attr('selected',true);
                form.find('#edit_name_cat').val(name);
                form.find('#edit_language_cat option[value="'+el.data('lang')+'"]').attr('selected',true);
            });

            $(document).on('change', '#edit_language_gallery', function (e) {
                e.preventDefault();
                change_category_by_lang($(this).val(), '#edit_category_id_gallery');
            });
            $(document).on('change', '#language', function (e) {
                e.preventDefault();
                change_category_by_lang($(this).val(), '#category_id');
            });

            function change_category_by_lang(lang, selector, selected = null) {
                $.ajax({
                    url: "{{route('admin.gallery.category.lang.cat')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        lang: lang
                    },
                    success: function (data) {
                        $(selector).html('<option value="">{{__('Select Category')}}</option>');
                        $.each(data, function (index, value) {
                            var select = selected == value.id ? 'selected' : '';
                            $(selector).append('<option value="' + value.id + '" ' + select + '>' + value.title + '</option>')
                        });
                    }
                });
            }
        });
    </script>
@endsection
