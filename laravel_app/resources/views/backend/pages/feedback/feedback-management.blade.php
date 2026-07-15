@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
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
@endsection
@section('site-title')
    {{__('Feedback Management')}}
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
                        <h4 class="header-title">{{__('Feedback Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="feedbackTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-feedback-tab" data-toggle="tab" href="#all_feedback_panel" role="tab" aria-selected="true">{{__('All Feedback')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="form-builder-tab" data-toggle="tab" href="#form_builder_panel" role="tab" aria-selected="false">{{__('Form Builder')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="page-settings-tab" data-toggle="tab" href="#page_settings_panel" role="tab" aria-selected="false">{{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="feedbackTabsContent">
                            <!-- All Feedback Tab -->
                            <div class="tab-pane fade show active" id="all_feedback_panel" role="tabpanel" aria-labelledby="all-feedback-tab">
                                <div class="bulk-delete-wrapper">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" id="bulk_option">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default" id="all_feedback_table">
                                        <thead>
                                        <th>
                                            <div class="mark-all-checkbox">
                                                <input type="checkbox" class="all-checkbox">
                                            </div>
                                        </th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Ratings')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($all_feedback as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->email}}</td>
                                                <td><div class="ratings">{!! ratings_markup($data->ratings) !!}</div></td>
                                                <td>{{date("d - M - Y", strtotime($data->created_at))}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                       role="button"
                                                       data-toggle="popover"
                                                       data-trigger="focus"
                                                       data-html="true"
                                                       title=""
                                                       data-content="
                                                               <h6>{{__('Are you sure to delete this feedback?')}}</h6>
                                                               <form method='post' action='{{route('admin.feedback.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-xs' value='Yes,Delete'>
                                                                </form>
                                                                ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#view_feedback_details_modal"
                                                       data-email="{{$data->email}}"
                                                       data-name="{{$data->name}}"
                                                       data-ratings="{{$data->ratings}}"
                                                       data-description="{{$data->description}}"
                                                       data-date="{{date_format($data->created_at,'d M Y')}}"
                                                       data-customfield="{{json_encode(unserialize($data->custom_fields))}}"
                                                       data-attachment="{{json_encode(unserialize($data->attachment))}}"
                                                       class="btn btn-lg btn-primary btn-xs mb-3 mr-1 view_feedback_details_btn"
                                                    >
                                                        <i class="ti-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Form Builder Tab -->
                            <div class="tab-pane fade" id="form_builder_panel" role="tabpanel" aria-labelledby="form-builder-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__("Feedback Form Builder")}}</h4>
                                                <p class="alert alert-info text-capitalize">{{__('name,email,rating,description are prebuild field, skip those field')}}</p>
                                                <form action="{{route('admin.feedback.page.form.builder')}}" method="Post">
                                                    @csrf
                                                    {!! render_drag_drop_form_builder_markup(get_static_option('feedback_page_form_fields')) !!}
                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                                <ul id="sortable_02" class="available-form-field">
                                                    <li class="ui-state-default" type="text"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Text')}}</li>
                                                    <li class="ui-state-default" type="email"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Email')}}</li>
                                                    <li class="ui-state-default" type="tel"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Tel')}}</li>
                                                    <li class="ui-state-default" type="url"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('URL')}}</li>
                                                    <li class="ui-state-default" type="select"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Select')}}</li>
                                                    <li class="ui-state-default" type="checkbox"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Check Box')}}</li>
                                                    <li class="ui-state-default" type="file"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('File')}}</li>
                                                    <li class="ui-state-default" type="textarea"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{__('Textarea')}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Page Settings Tab -->
                            <div class="tab-pane fade" id="page_settings_panel" role="tabpanel" aria-labelledby="page-settings-tab">
                                <form action="{{route('admin.feedback.page.settings')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" id="nav-home-tab" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30" id="nav-tabContent">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_form_title">{{__('Form Title')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_form_title"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_form_title')}}" id="feedback_page_form_{{$lang->slug}}_form_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_name_label">{{__('Name Label')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_name_label"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_name_label')}}" id="feedback_page_form_{{$lang->slug}}_name_label">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_email_label">{{__('Email Label')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_email_label"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_email_label')}}" id="feedback_page_form_{{$lang->slug}}_email_label">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_ratings_label">{{__('Ratings Label')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_ratings_label"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_ratings_label')}}" id="feedback_page_form_{{$lang->slug}}_ratings_label">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_description_label">{{__('Description Label')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_description_label"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_description_label')}}" id="feedback_page_form_{{$lang->slug}}_description_label">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feedback_page_form_{{$lang->slug}}_button_text">{{__('Button Text')}}</label>
                                                    <input type="text" name="feedback_page_form_{{$lang->slug}}_button_text"  class="form-control" value="{{get_static_option('feedback_page_form_'.$lang->slug.'_button_text')}}" id="feedback_page_form_{{$lang->slug}}_button_text">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="feedback_notify_mail">{{__('Feedback Notify Email')}}</label>
                                        <input type="text" name="feedback_notify_mail"  class="form-control" value="{{get_static_option('feedback_notify_mail')}}" id="feedback_notify_mail">
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

    <!-- View Feedback Details Modal -->
    <div class="modal fade" id="view_feedback_details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="view-order-details-info p-4">
                    <h4 class="title mb-3">{{__('View Feedback Details')}}</h4>
                    <div class="view-order-top-wrap mb-3">
                        <div class="data-wrap">
                            {{__('Feedback Date:')}} <span class="order-date-span"></span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="order-all-custom-fields table table-striped table-bordered"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Keep active tab on refresh
            $('#feedbackTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            $("ul#feedbackTabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabFeedback', id);
            });
            var activeTab = window.localStorage.getItem('activeTabFeedback');
            if (activeTab) {
                $('#feedbackTabs a[href="#' + activeTab + '"]').tab('show');
            }

            // Bulk action delete
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
                        'url' : "{{route('admin.feedback.bulk.action')}}",
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

            // Datatable
            $('#all_feedback_table').DataTable({
                "order": [[ 1, "desc" ]]
            });

            // View feedback details logic
            $(document).on('click','.view_feedback_details_btn',function (e) {
                e.preventDefault();
                var el = $(this);
                var allData = el.data();
                var parent = $('#view_feedback_details_modal');

                parent.find('.order-date-span').text(allData.date);
                parent.find('.order-all-custom-fields').html('');
                
                // Add basic fields
                parent.find('.order-all-custom-fields').append('<tr><td class="fname">Name</td><td class="fvalue">'+allData.name+'</td></tr>');
                parent.find('.order-all-custom-fields').append('<tr><td class="fname">Email</td><td class="fvalue">'+allData.email+'</td></tr>');
                parent.find('.order-all-custom-fields').append('<tr><td class="fname">Ratings</td><td class="fvalue">'+allData.ratings+' / 5</td></tr>');
                parent.find('.order-all-custom-fields').append('<tr><td class="fname">Description</td><td class="fvalue">'+allData.description+'</td></tr>');

                if (allData.customfield) {
                    $.each(allData.customfield,function (index,value) {
                        parent.find('.order-all-custom-fields').append('<tr><td class="fname">'+index.replace('-',' ')+'</td> <td class="fvalue">'+value+'</td></tr>');
                    });
                }

                if(allData.attachment){
                    $.each(allData.attachment,function (index,value) {
                        parent.find('.order-all-custom-fields tbody').append('<tr class="attachment_list"><td class="fname">'+index.replace('-',' ')+'</td><td class="fvalue"><a href="{{url('/')}}'+'/'+value+'" download>'+value.substr(26)+'</a></td></tr>');
                    });
                }
            });

            // Drag and drop form builder js
            $("#sortable").sortable({
                axis: "y",
                placeholder: "sortable-placeholder",
                out: function(event,ui){
                    setTimeout(function(){
                        var allShortableList = $("#sortable li");

                        allShortableList.each(function (index,value) {
                            var el = $(this);
                            el.find('.field-required').attr('name','field_required['+index+']');
                            el.find('.mime-type').attr('name','mimes_type['+index+']');
                        });
                    },500);
                }
            }).disableSelection();
            
            $("#sortable_02").sortable({
                connectWith: '#sortable',
                helper: "clone",
                remove: function (e, li) {
                    var value = li.item.context.attributes.type.value;
                    var random = Math.floor(Math.random(9999) * 999999);
                    var formFiledLength = $('#sortable li').length - 1;

                    var markup = render_drag_drop_form_field_markup(value,random,formFiledLength);
                    li.item.clone()
                        .prop('id', value + '_' + random)
                        .text('')
                        .append(markup)
                        .insertAfter(li.item);
                    $(this).sortable('cancel');
                    return li.item.clone();
                }
            }).disableSelection();

            $('body').on('change paste keyup', '.field-placeholder', function (e) {
                $(this).parent().parent().parent().prev().find('.placeholder-name').text($(this).val());
            });
            $('body').on('click', '.remove-fields', function (e) {
                $(this).parent().remove();
                $( "#sortable" ).sortable( "refreshPositions" );
            });

            function render_drag_drop_form_field_markup(type,random,formFiledLength){
                var markup = '';
                markup += '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>\n <span class="remove-fields">x</span>\n<a data-toggle="collapse" href="#collapseExample-' + random + '" role="button" aria-expanded="false" aria-controls="collapseExample">\n' +
                    type + ': <span class="placeholder-name"></span>\n</a>\n' +
                    '<div class="collapse" id="collapseExample-' + random + '">\n' +
                    '<div class="card card-body margin-top-30">\n' +
                    '<input type="hidden" class="form-control" name="field_type[]" value="' + type + '">' +
                    '<div class="form-group">\n' +
                    '<label>Name</label>\n' +
                    '<input type="text" class="form-control" name="field_name[]" placeholder="enter field name" >\n</div>\n' +
                    '<div class="form-group">\n <label>Placeholder/Label</label>\n' +
                    ' <input type="text" class="form-control field-placeholder"  name="field_placeholder[]" placeholder="enter field name" >\n' +
                    '</div>\n<div class="form-group">\n<label ><strong>Required</strong></label>\n<label class="switch">\n' +
                    '<input type="checkbox" class="field-required" name="field_required['+formFiledLength+']" >\n' +
                    '<span class="slider onff"></span>\n</label>\n</div>';
                if(type == 'select'){
                    markup += '<div class="form-group">\n' +
                        '<label>Options</label>\n' +
                        '<textarea name="select_options[]"  class="form-control max-height-120" cols="30" rows="10" ></textarea>\n' +
                        '<small>separate option by new line </small>\n' +
                        '</div>\n' ;
                }
                if(type == 'file'){
                    markup +=  '<div class="form-group">\n' +
                        '<label>File Type</label>\n' +
                        '<select name="mimes_type['+formFiledLength+']" class="form-control mime-type">\n' +
                        '<option value="mimes:jpg,jpeg,png" >jpg,jpeg,png</option>\n' +
                        '<option value="mimes:txt,pdf">txt,pdf</option>\n' +
                        '<option value="mimes:doc,docx">doc,docx</option>\n' +
                        '</select>\n' +
                        '</div>';
                }

                markup += '</div>\n  </div>';

                return markup;
            }
        });
    </script>
@endsection
