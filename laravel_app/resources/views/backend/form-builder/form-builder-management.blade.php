@extends('backend.admin-master')
@section('site-title')
    {{__('Form Builder Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; white-space: nowrap; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #10b981; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; }
        .nav-tabs::-webkit-scrollbar { height: 4px; }
        .nav-tabs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .tab-content { padding-top: 10px; }
    </style>
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend.partials.message')
                @if($errors->any())
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Form Builder Management')}}</h4>

                        <ul class="nav nav-tabs" id="formBuilderTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#quote-form" role="tab">{{__('Quote Form')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#order-form" role="tab">{{__('Order Form')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#contact-form" role="tab">{{__('Contact Form')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#callback-form" role="tab">{{__('Call Back Form')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#job-form" role="tab">{{__('Job Apply Form')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#event-form" role="tab">{{__('Event Booking Form')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="formBuilderTabContent">
                            
                            <!-- Quote Form -->
                            <div class="tab-pane fade show active" id="quote-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Quote Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.quote')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('quote_page_form_fields'), 'sortable_quote') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_quote" class="available-form-field" data-target="sortable_quote">
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

                            <!-- Order Form -->
                            <div class="tab-pane fade" id="order-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Order Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.order')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('order_page_form_fields'), 'sortable_order') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_order" class="available-form-field" data-target="sortable_order">
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

                            <!-- Contact Form -->
                            <div class="tab-pane fade" id="contact-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Contact Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.contact')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('contact_page_form_fields'), 'sortable_contact') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_contact" class="available-form-field" data-target="sortable_contact">
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

                            <!-- Call Back Form -->
                            <div class="tab-pane fade" id="callback-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Call Back Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.call.back')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('call_back_page_form_fields'), 'sortable_callback') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_callback" class="available-form-field" data-target="sortable_callback">
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
                            
                            <!-- Job Apply Form -->
                            <div class="tab-pane fade" id="job-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Job Apply Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.job.apply')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('apply_job_page_form_fields'), 'sortable_job') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_job" class="available-form-field" data-target="sortable_job">
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
                            
                            <!-- Event Booking Form -->
                            <div class="tab-pane fade" id="event-form" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Event Booking Form Builder")}}</h4>
                                        <form action="{{route('admin.form.builder.event.booking')}}" method="Post">
                                            @csrf
                                            {!! render_drag_drop_form_builder_markup(get_static_option('event_attendance_form_fields'), 'sortable_event') !!}
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40">{{__('Save Change')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="header-title">{{__("Available Form Fields")}}</h4>
                                        <ul id="sortable_02_event" class="available-form-field" data-target="sortable_event">
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

                        </div> <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                
                // Tab persistence
                $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                    localStorage.setItem('activeFormBuilderTab', $(e.target).attr('href'));
                });
                var activeTab = localStorage.getItem('activeFormBuilderTab');
                if(activeTab){
                    $('#formBuilderTab a[href="' + activeTab + '"]').tab('show');
                }

                function initFormBuilder(sortableId, sortable02Id) {
                    var mainSortable = $("#" + sortableId);
                    
                    mainSortable.sortable({
                        axis: "y",
                        placeholder: "sortable-placeholder",
                        out: function(event,ui){
                            setTimeout(function(){
                                var allShortableList = $("#" + sortableId + " > li");
                                allShortableList.each(function (index,value) {
                                    var el = $(this);
                                    el.find('.field-required').attr('name','field_required['+index+']');
                                    el.find('.mime-type').attr('name','mimes_type['+index+']');
                                });
                            },500);
                        }
                    }).disableSelection();
                    
                    $("#" + sortable02Id).sortable({
                        connectWith: '#' + sortableId,
                        helper: "clone",
                        remove: function (e, li) {
                            var value = li.item.context.attributes.type.value;
                            var random = Math.floor(Math.random(9999) * 999999);
                            var formFiledLength = $('#' + sortableId + ' > li').length - 1;

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
                }

                // Initialize all form builders
                initFormBuilder('sortable_quote', 'sortable_02_quote');
                initFormBuilder('sortable_order', 'sortable_02_order');
                initFormBuilder('sortable_contact', 'sortable_02_contact');
                initFormBuilder('sortable_callback', 'sortable_02_callback');
                initFormBuilder('sortable_job', 'sortable_02_job');
                initFormBuilder('sortable_event', 'sortable_02_event');

                $('body').on('change paste keyup', '.field-placeholder', function (e) {
                    $(this).parent().parent().parent().prev().find('.placeholder-name').text($(this).val());
                });
                
                $('body').on('click', '.remove-fields', function (e) {
                    var sortableParent = $(this).closest('.available-form-field.main-fields');
                    $(this).parent().remove();
                    if(sortableParent.length > 0) {
                        sortableParent.sortable( "refreshPositions" );
                    }
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
                             '<option value="mimes:zip">zip</option>\n' +
                            '<option value="mimes:doc,docx">doc,docx</option>\n' +
                            '</select>\n' +
                            '</div>';
                    }

                    markup += '</div>\n  </div>';

                    return markup;
                }
            });
        }(jQuery));
    </script>
@endsection
