@extends('backend.admin-master')
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
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
@endsection
@section('site-title')
    {{__('Popup Builder Management')}}
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
                        <h4 class="header-title">{{__('Popup Builder Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="popupTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-popups-tab" data-toggle="tab" href="#all_popups_panel" role="tab" aria-selected="true">{{__('All Popups')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-popup-tab" data-toggle="tab" href="#add_popup_panel" role="tab" aria-selected="false">{{__('Add New Popup')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="popup-settings-tab" data-toggle="tab" href="#popup_settings_panel" role="tab" aria-selected="false">{{__('Active Popup Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="popupTabsContent">
                            <!-- All Popups Tab -->
                            <div class="tab-pane fade show active" id="all_popups_panel" role="tabpanel" aria-labelledby="all-popups-tab">
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
                                    @foreach($all_popup as $key => $popup)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40" id="myTabContent">
                                    @php $b=0; @endphp
                                    @foreach($all_popup as $key => $popup)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default popup-datatable">
                                                    <thead>
                                                    <th>
                                                        <div class="mark-all-checkbox">
                                                            <input type="checkbox" class="all-checkbox">
                                                        </div>
                                                    </th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Type')}}</th>
                                                    <th>{{__('Created At')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($popup as $data)
                                                        <tr>
                                                            <td>
                                                                <div class="bulk-checkbox-wrapper">
                                                                    <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                </div>
                                                            </td>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->name}}</td>
                                                            <td>{{ucwords(str_replace('_',' ',$data->type))}}</td>
                                                            <td>{{date("d - M - Y", strtotime($data->created_at))}}</td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                                   role="button"
                                                                   data-toggle="popover"
                                                                   data-trigger="focus"
                                                                   data-html="true"
                                                                   title=""
                                                                   data-content="
                                                               <h6>{{__('Are you sure to delete this popup?')}}</h6>
                                                               <form method='post' action='{{route('admin.popup.builder.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                </form>
                                                                ">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.popup.builder.edit',$data->id)}}">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-info btn-xs mb-3 mr-1 show_modal_demo"
                                                                   href="#"
                                                                   data-type="{{$data->type}}"
                                                                   data-title="{{$data->title}}"
                                                                   data-description="{{$data->description}}"
                                                                   data-only_image="{{$data->only_image}}"
                                                                   @php
                                                                       $image_url = get_attachment_image_by_id($data->only_image,'full',false);
                                                                       $image_url = !empty($image_url) ? $image_url['img_url'] : '';
                                                                   @endphp
                                                                   data-imageurl="{{$image_url}}"
                                                                   @php
                                                                       $bg_image_url = get_attachment_image_by_id($data->background_image,'full',false);
                                                                       $bg_image_url = !empty($bg_image_url) ? $bg_image_url['img_url'] : '';
                                                                   @endphp
                                                                   data-background_image="{{$bg_image_url}}"
                                                                   data-button_text="{{$data->button_text}}"
                                                                   data-button_link="{{$data->button_link}}"
                                                                   data-btn_status="{{$data->btn_status}}"
                                                                   data-offer_time_end="{{$data->offer_time_end}}"
                                                                >
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <form action="{{route('admin.popup.builder.clone',$data->id)}}" method="post" style="display: inline-block">
                                                                    @csrf
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

                            <!-- Add New Popup Tab -->
                            <div class="tab-pane fade" id="add_popup_panel" role="tabpanel" aria-labelledby="add-popup-tab">
                                <form action="{{route('admin.popup.builder.new')}}" method="post" enctype="multipart/form-data">
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
                                                <label for="name">{{__('Name ( It will not show in frontend )')}}</label>
                                                <input type="text" class="form-control"  id="name" name="name" value="{{old('name')}}" placeholder="{{__('Name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="title">{{__('Title')}}</label>
                                                <input type="text" class="form-control"  id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="popup_type"><strong>{{__('Type')}}</strong></label>
                                                <select name="type" id="popup_type" class="form-control">
                                                        <option value="notice">{{__('Notice')}}</option>
                                                        <option value="only_image">{{__('Only Image')}}</option>
                                                        <option value="discount">{{__('Discount')}}</option>
                                                        <option value="promotion">{{__('Promotion')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">{{__('Description')}}</label>
                                                <textarea name="description" id="description" class="form-control" cols="30" rows="10" placeholder="{{__('Description')}}"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="offer_time_end">{{__('Offer End Date')}}</label>
                                                <input type="date" class="form-control datepicker"  id="offer_time_end" name="offer_time_end" placeholder="{{__('offer end date')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="btn_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                                <label class="switch">
                                                    <input type="checkbox" name="btn_status" id="btn_status">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="button_text">{{__('Button Text')}}</label>
                                                <input type="text" class="form-control"  id="button_text" name="button_text" value="{{old('button_text')}}" placeholder="{{__('Button Text')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="button_link">{{__('Button Link')}}</label>
                                                <input type="text" class="form-control"  id="button_link" name="button_link" value="{{old('button_link')}}" placeholder="{{__('Button Link')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="background_image">{{__('Background Image')}}</label>
                                                <div class="media-upload-btn-wrapper">
                                                    <div class="img-wrap"></div>
                                                    <input type="hidden" name="background_image">
                                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                                        {{__('Upload Image')}}
                                                    </button>
                                                </div>
                                                <small>{{__('Recommended image size 700x400')}}</small>
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
                                                <small>{{__('Recommended image size 700x400')}}</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Popup')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Active Popup Settings Tab -->
                            <div class="tab-pane fade" id="popup_settings_panel" role="tabpanel" aria-labelledby="popup-settings-tab">
                                <form action="{{route('admin.general.popup.settings')}}" method="Post" enctype="multipart/form-data">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab-settings" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-settings-{{$lang->slug}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-settings-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="popup_selected_{{$lang->slug}}_id">{{__('Select Popup')}}</label>
                                                    <select name="popup_selected_{{$lang->slug}}_id" class="form-control" id="popup_selected_{{$lang->slug}}_id">
                                                        @if(isset($all_popup[$lang->slug]))
                                                        @foreach($all_popup[$lang->slug] as $item)
                                                            <option @if(get_static_option('popup_selected_'.$lang->slug.'_id') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="popup_enable_status"><strong>{{__('Popup Enable/Disable')}}</strong></label>
                                        <label class="switch d-block">
                                            <input type="checkbox" name="popup_enable_status" @if(!empty(get_static_option('popup_enable_status'))) checked @endif id="popup_enable_status">
                                            <span class="slider onff"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="popup_delay_time">{{__('Popup Delay Time')}}</label>
                                        <input type="text" class="form-control" name="popup_delay_time" id="popup_delay_time" value="{{get_static_option('popup_delay_time')}}">
                                        <p class="info-text">{{__('put number in miliseconds')}}</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Changes')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NX Popup Modals (for preview) -->
    <div class="nx-popup-backdrop"></div>
    <div class="nx-popup-wrapper">
        <div class="nx-modal-content-wrapper">
            <div class="nx-modal-inner-content-wrapper">
                <div class="nx-popup-close">&times;</div>
                <div class="nx-modal-content"></div>
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
    <script src="{{asset('assets/common/js/countdown.jquery.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Keep active tab on refresh
            $('#popupTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#popupTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabPopup', id);
            });
            var activeTab = window.localStorage.getItem('activeTabPopup');
            if (activeTab) {
                $('#popupTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // Type hide/show logic
            showHideFields($('#popup_type').val());
            $(document).on('change','#popup_type',function (e) {
                e.preventDefault();
                var el = $(this);
                var type = el.val();
                showHideFields(type);
            });

            function showHideFields(type) {
                if(type == 'notice'){
                    $('label[for="image"]').parent().hide();
                    $('label[for="description"]').parent().show();
                    $('label[for="title"]').parent().show();
                    $('label[for="background_image"]').parent().hide();
                    $('label[for="button_text"]').parent().hide();
                    $('label[for="button_link"]').parent().hide();
                    $('label[for="btn_status"]').parent().hide();
                    $('label[for="offer_time_end"]').parent().hide();
                }else if(type == 'only_image'){
                    $('label[for="image"]').parent().show();
                    $('label[for="background_image"]').parent().hide();
                    $('label[for="button_text"]').parent().hide();
                    $('label[for="button_link"]').parent().hide();
                    $('label[for="btn_status"]').parent().hide();
                    $('label[for="offer_time_end"]').parent().hide();
                    $('label[for="description"]').parent().hide();
                    $('label[for="title"]').parent().hide();
                }else{
                    $('label[for="image"]').parent().show();
                    $('label[for="background_image"]').parent().show();
                    $('label[for="button_text"]').parent().show();
                    $('label[for="button_link"]').parent().show();
                    $('label[for="btn_status"]').parent().show();
                    $('label[for="offer_time_end"]').parent().show();
                    $('label[for="description"]').parent().show();
                    $('label[for="title"]').parent().show();
                }
            }

            // Preview modal show logic
            $(document).on('click','.show_modal_demo',function (e) {
                e.preventDefault();
                var el = $(this);
                var type = el.data('type');
                setTimeout(function () {
                    $('.nx-popup-backdrop').addClass('show');
                    $('.nx-popup-wrapper').addClass('show');
                });
                showPopupDemo(type,el);
            });

            function showPopupDemo(type,el){
                if(type == 'notice'){
                    $('.nx-popup-wrapper').addClass('notice-modal');
                    $('.nx-modal-content').html(' <div class="notice-modal-content-wrapper">\n' +
                        '<div class="right-side-content">\n' +
                        '<h4 class="title">'+el.data('title')+'</h4>\n' +
                        '<p>'+el.data('description')+'</p>\n' +
                        '</div>\n' +
                        '</div>');
                }else if(type == 'only_image'){
                    $('.nx-popup-wrapper').addClass('only-image-modal');
                    $('.nx-popup-wrapper.only-image-modal .nx-modal-inner-content-wrapper').css({
                        'background-image' : 'url('+el.data('imageurl')+')'
                    });
                }else if(type == 'promotion'){
                    $('.nx-popup-wrapper').addClass('promotion-modal');
                    $('.nx-popup-wrapper.promotion-modal .nx-modal-inner-content-wrapper').css({
                        'background-image' : 'url('+el.data('background_image')+')'
                    });
                    $('.nx-modal-content').html('<div class="promotional-modal-content-wrapper">\n' +
                        '<div class="left-content-warp">\n' +
                        '<img src="'+el.data('imageurl')+'" alt="">\n' +
                        '</div>\n' +
                        '<div class="right-content-warp">\n' +
                        '<div class="right-content-inner-wrap">\n' +
                        '<h4 class="title">'+el.data('title')+'</h4>\n' +
                        '<p>'+el.data('description')+'</p>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>');
                    if(el.data('btn_status') == 'on'){
                        $('.promotional-modal-content-wrapper .right-content-warp .right-content-inner-wrap').append('<div class="btn-wrapper"><a href="'+el.data('button_link')+'" class="btn-boxed">'+el.data('button_text')+'</a></div>');
                    }
                }else{
                    $('.nx-popup-wrapper').addClass('discount-modal');
                    $('.nx-popup-wrapper.discount-modal .nx-modal-inner-content-wrapper').css({
                        'background-image' : 'url('+el.data('background_image')+')'
                    });
                    $('.nx-modal-content').html('<div class="discount-modal-content-wrapper">\n' +
                        '<div class="left-content-warp">\n' +
                        '<img src="'+el.data('imageurl')+'" alt="">\n' +
                        '</div>\n' +
                        '<div class="right-content-warp">\n' +
                        '<div class="right-content-inner-wrap">\n' +
                        '<h4 class="title">'+el.data('title')+'</h4>\n' +
                        '<p>'+el.data('description')+'</p>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>');
                    if(el.data('offer_time_end')){
                        $('.discount-modal-content-wrapper .right-content-warp .right-content-inner-wrap').append('<div class="countdown-wrapper"><div id="countdown"></div></div>');
                    }
                    if(el.data('btn_status') == 'on'){
                        $('.discount-modal-content-wrapper .right-content-warp .right-content-inner-wrap').append('<div class="btn-wrapper"><a href="'+el.data('button_link')+'" class="btn-boxed">'+el.data('button_text')+'</a></div>');
                    }

                    var offerTime = el.data('offer_time_end');
                    var year = offerTime.substr(0,4);
                    var month = offerTime.substr(5,2);
                    var day = offerTime.substr(8,2);

                    $('#countdown').countdown({
                        year: year,
                        month: month,
                        day: day,
                        labels: true,
                        labelText: {
                            'days': "{{__('days')}}",
                            'hours': "{{__('hours')}}",
                            'minutes': "{{__('min')}}",
                            'seconds': "{{__('sec')}}",
                        }
                    });
                }
            }

            $(document).on('click','.nx-popup-close,.nx-popup-backdrop',function (e) {
                e.preventDefault();
                $('.nx-modal-inner-content-wrapper').removeAttr('style');
                $('.nx-modal-content').html('');
                $('.nx-popup-wrapper').removeClass('only-image-modal notice-modal promotion-modal discount-modal');
                $('.nx-popup-backdrop').removeClass('show');
                $('.nx-popup-wrapper').removeClass('show');
            });

            // Datatables
            $('.popup-datatable').DataTable({
                "order": [[ 1, "desc" ]]
            });

            // Bulk Delete
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
                        'url' : "{{route('admin.popup.builder.bulk.action')}}",
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
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
