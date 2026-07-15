@extends('backend.admin-master')
@section('site-title')
    {{__('Contact Page Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <!-- Tab Styling Modernization -->
    <style>
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
                        <h4 class="header-title">{{__('Contact Page Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="contactManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="form-section-tab" data-toggle="tab" href="#form-section" role="tab" aria-selected="true">{{__('Form Section')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-info-tab" data-toggle="tab" href="#contact-info" role="tab" aria-selected="false">{{__('Contact Info Items')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="map-section-tab" data-toggle="tab" href="#map-section" role="tab" aria-selected="false">{{__('Google Map Section')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="section-manage-tab" data-toggle="tab" href="#section-manage" role="tab" aria-selected="false">{{__('Section Manage')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="contactManagementTabContent">
                            <!-- TAB 1: Form Section -->
                            <div class="tab-pane fade show active" id="form-section" role="tabpanel">
                                <form action="{{route('admin.contact.page.form.area')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <ul class="nav nav-tabs language-tabs" id="myTab" role="tablist">
                                        @foreach($all_languages as $key => $lang)
                                        <li class="nav-item">
                                            <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content margin-top-30" id="myTabContent">
                                        @foreach($all_languages as $key => $lang)
                                        <div class="tab-pane fade @if($key == 0) show active @endif" id="home-{{$lang->slug}}" role="tabpanel" >
                                            <div class="form-group">
                                                <label for="contact_page_{{$lang->slug}}_form_section_title">{{__('Title')}}</label>
                                                <input type="text" name="contact_page_{{$lang->slug}}_form_section_title" value="{{get_static_option('contact_page_'.$lang->slug.'_form_section_title')}}" class="form-control" id="contact_page_{{$lang->slug}}_form_section_title">
                                            </div>
                                            <div class="form-group">
                                                <label for="contact_page_{{$lang->slug}}_form_section_description">{{__('Description')}}</label>
                                                <textarea name="contact_page_{{$lang->slug}}_form_section_description" id="contact_page_{{$lang->slug}}_form_section_description" class="form-control max-height-120" cols="30" rows="10">{{get_static_option('contact_page_'.$lang->slug.'_form_section_description')}}</textarea>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="contact_page_form_email">{{__('Receiving Mail')}}</label>
                                        <input type="text" name="contact_page_form_email" value="{{get_static_option('contact_page_form_email')}}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>
                            </div>

                            <!-- TAB 2: Contact Info Items -->
                            <div class="tab-pane fade" id="contact-info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6 border-right">
                                        <h4 class="header-title">{{__('Contact Info Items')}}</h4>
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap d-inline-block">
                                                <select name="bulk_option" id="bulk_option" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs language-tabs" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach($all_contact_info as $key => $contactinfo)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-30">
                                            @php $b=0; @endphp
                                            @foreach($all_contact_info as $key => $contactinfo)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default">
                                                            <thead>
                                                                <th class="no-sort">
                                                                    <div class="mark-all-checkbox">
                                                                        <input type="checkbox" class="all-checkbox">
                                                                    </div>
                                                                </th>
                                                                <th>{{__('Title')}}</th>
                                                                <th>{{__('Icon')}}</th>
                                                                <th>{{__('Action')}}</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($contactinfo as $data)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="bulk-checkbox-wrapper">
                                                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                            </div>
                                                                        </td>
                                                                        <td>{{$data->title}}</td>
                                                                        <td><i class="{{$data->icon}}"></i></td>
                                                                        <td>
                                                                            <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                                <h6>{{__('Are you sure to delete this contact info item ?')}}</h6>
                                                                                <form method='post' action='{{route('admin.contact.info.delete',$data->id)}}'>
                                                                                <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                                <br>
                                                                                <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                                                </form>
                                                                            ">
                                                                                <i class="ti-trash"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                               data-toggle="modal"
                                                                               data-target="#contact_info_item_edit_modal"
                                                                               class="btn btn-primary btn-xs mb-3 mr-1 contact_info_edit_btn"
                                                                               data-id="{{$data->id}}"
                                                                               data-lang="{{$data->lang}}"
                                                                               data-title="{{$data->title}}"
                                                                               data-description="{{$data->description}}"
                                                                               data-icon="{{$data->icon}}"
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
                                        <h4 class="header-title">{{__('New Contact Info')}}</h4>
                                        <form action="{{route('admin.contact.info')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="language">{{__('Languages')}}</label>
                                                <select name="lang" id="language" class="form-control">
                                                    @foreach($all_languages as $lang)
                                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">{{__('Title')}}</label>
                                                <input type="text" class="form-control"  id="title"  name="title" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="icon" class="d-block">{{__('Icon')}}</label>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary iconpicker-component">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </button>
                                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu"></div>
                                                </div>
                                                <input type="hidden" class="form-control" id="icon" value="fas fa-exclamation-triangle" name="icon">
                                            </div>
                                            <div class="form-group">
                                                <label for="description">{{__('Description')}}</label>
                                                <textarea id="description" name="description" class="form-control max-height-120" cols="30" rows="10" placeholder="{{__('Description')}}"></textarea>
                                                <small class="info-text">{{__('to break a new line use semicolon (;).')}}</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add Contact Info Item')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: Google Map Section -->
                            <div class="tab-pane fade" id="map-section" role="tabpanel">
                                <form action="{{route('admin.contact.page.map')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="contact_page_map_section_address">{{__('Google Map Address')}}</label>
                                        <input type="text" name="contact_page_map_section_address" value="{{get_static_option('contact_page_map_section_address')}}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                                </form>
                            </div>

                            <!-- TAB 4: Section Manage -->
                            <div class="tab-pane fade" id="section-manage" role="tabpanel">
                                <form action="{{route('admin.contact.section.manage')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="contact_page_form_section_status"><strong>{{__('Contact Form Section Show/Hide')}}</strong></label>
                                                <label class="switch">
                                                    <input type="checkbox" name="contact_page_form_section_status"  @if(!empty(get_static_option('contact_page_form_section_status'))) checked @endif >
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="contact_page_contact_info_section_status"><strong>{{__('Contact Info Section Show/Hide')}}</strong></label>
                                                <label class="switch">
                                                    <input type="checkbox" name="contact_page_contact_info_section_status"  @if(!empty(get_static_option('contact_page_contact_info_section_status'))) checked @endif >
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="contact_page_google_map_section_status"><strong>{{__('Google map Section Show/Hide')}}</strong></label>
                                                <label class="switch">
                                                    <input type="checkbox" name="contact_page_google_map_section_status"  @if(!empty(get_static_option('contact_page_google_map_section_status'))) checked @endif >
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                        </div>
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

    <!-- MODALS for Contact Info -->
    <div class="modal fade" id="contact_info_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Contact Info Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.contact.info.update')}}" id="contact_info_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="contact_info_id" value="">
                        <div class="form-group">
                            <label for="edit_language">{{__('Languages')}}</label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach($all_languages as $lang)
                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
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
                            <input type="hidden" class="form-control"  id="edit_icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{__('Description')}}</label>
                            <textarea  id="edit_description"  name="description" class="form-control max-height-120" cols="30" rows="10" placeholder="{{__('Description')}}"></textarea>
                            <small class="info-text">{{__('to break a new line use semicolon (;).')}}</small>
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
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Keep track of active tab after reload
            $('a[data-toggle="tab"][id$="-tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeContactTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeContactTab');
            if(activeTab){
                $('#contactManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            $(document).on('click','.contact_info_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var icon = el.data('icon');
                var description = el.data('description');
                var form = $('#contact_info_edit_modal_form');

                form.find('#contact_info_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_icon').val(icon);
                form.find('#edit_description').val(description);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);
            });
            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
            });

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
                        'url' : "{{route('admin.contact.info.bulk.action')}}",
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
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
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
