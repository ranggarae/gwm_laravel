@extends('backend.admin-master')
@section('site-title')
    {{__('Image Gallery')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
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
            <!-- basic form start -->
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

            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Image Gallery')}}</h4>
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
                            @foreach($all_gallery_images as $key => $slider)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab"
                                       href="#slider_tab_{{$key}}" role="tab" aria-controls="home"
                                       aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_gallery_images as $key => $items)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}"
                                     role="tabpanel">
                                    <div class="table-wrap table-responsive">
                                        <table class="table table-default">
                                            <thead>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
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
                                                            <input type="checkbox" class="bulk-checkbox"
                                                                   name="bulk_delete[]" value="{{$data->id}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->title}}</td>
                                                    <td>
                                                        {!! render_attachment_preview($data->image) !!}
                                                    </td>
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
                                                           <h6>{{__('Are you sure to delete this image?')}}</h6>
                                                           <form method='post' action='{{route('admin.gallery.delete',$data->id)}}'>
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
                </div>
            </div>
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
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
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="Select Image" data-modaltitle="Upload Image"
                                            data-toggle="modal" data-target="#media_upload_modal">
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
                            <button type="submit"
                                    class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Image')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Gallery Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.gallery.update')}}" id="testimonial_edit_modal_form" method="post"
                      enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_language">{{__('Language')}}</label>
                            <select name="lang" class="form-control" id="edit_language">
                                @foreach($all_languages as $data)
                                    <option value="{{$data->slug}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="id" id="gallery_id" value="">
                        <div class="form-group">
                            <label for="title">{{__('Title')}}</label>
                            <input type="text" name="title" id="edit_title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" id="edit_image" name="image" value="">
                                <button type="button" class="btn btn-info media_upload_form_btn"
                                        data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal"
                                        data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('1000x1000 px image recommended')}}</small>
                        </div>
                        <div class="form-group">
                            <label for="category_id">{{__('Category')}}</label>
                            <select name="category_id" class="form-control" id="edit_category_id">
                                @foreach($all_category as $data)
                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                @endforeach
                            </select>
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
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')

    <script>
        $(document).ready(function () {

            $(document).on('click', '#bulk_delete_btn', function (e) {
                e.preventDefault();

                var bulkOption = $('#bulk_option').val();
                var allCheckbox = $('.bulk-checkbox:checked');
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

            $('.all-checkbox').on('change', function (e) {
                e.preventDefault();
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                //have write code here fr
                if (value == true) {
                    allChek.prop('checked', true);
                } else {
                    allChek.prop('checked', false);
                }
            });

            $(document).on('click', '.category_edit_btn', function () {
                var el = $(this);
                var id = el.data('id');
                var image = el.data('image');
                var imageid = el.data('imageid');

                change_category_by_lang(el.data('lang'), '#edit_category_id', el.data('catid'));

                var form = $('#testimonial_edit_modal_form');
                form.find('#gallery_id').val(id);
                form.find('#edit_title').val(el.data('title'));
                form.find('#edit_category_id option[value="' + el.data('catid') + '"]').attr('selected', true);
                form.find('#edit_status option[value="' + el.data('status') + '"]').attr('selected', true);
                form.find('#edit_language option[value="' + el.data('lang') + '"]').attr('selected', true);

                if (imageid != '') {
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="' + image + '" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
            });

            $(document).on('change', '#edit_language', function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();

                change_category_by_lang(selectedLang, '#edit_category_id');
            });
            $(document).on('change', '#language', function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                change_category_by_lang(selectedLang, '#category_id');
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
                            var select = selected === value.id ? 'selected' : '';
                            $(selector).append('<option value="' + value.id + '" ' + select + '>' + value.title + '</option>')
                        });
                    }
                });
            }
        });
    </script>
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.table-wrap > table').DataTable({
                "order": [[1, "desc"]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
