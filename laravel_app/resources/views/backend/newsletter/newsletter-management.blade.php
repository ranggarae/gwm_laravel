@extends('backend.admin-master')
@section('site-title')
    {{__('Newsletter Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{ padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
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
                        <h4 class="header-title">{{__('Newsletter Management')}}</h4>

                        <ul class="nav nav-tabs" id="newsletterTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all-subscribers" role="tab">{{__('All Subscribers')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#send-mail-all" role="tab">{{__('Send Mail to All')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="newsletterTabContent">
                            
                            <!-- TAB: All Subscribers -->
                            <div class="tab-pane fade show active" id="all-subscribers" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8 border-right">
                                        <h4 class="header-title">{{__('All Newsletter Subscriber')}}</h4>
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option" id="bulk_option" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <div class="table-wrap">
                                            <table class="table table-default">
                                                <thead>
                                                    <th class="no-sort">
                                                        <div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div>
                                                    </th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Email')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($all_subscriber as $data)
                                                    <tr>
                                                        <td>
                                                            <div class="bulk-checkbox-wrapper">
                                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->email}}</td>
                                                        <td>
                                                            <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                            <h6>{{__('Are you sure to delete this subscriber?')}}</h6>
                                                            <form method='post' action='{{route('admin.newsletter.delete',$data->id)}}'>
                                                            <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                            <br>
                                                                <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                </form>
                                                                ">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                            <a class="btn btn-primary btn-xs mb-3 mr-1 send_mail_modal_btn" href="#" data-toggle="modal" data-target="#send_mail_to_subscriber_modal" data-email="{{$data->email}}">
                                                                <i class="ti-email"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pl-4">
                                        <h4 class="header-title">{{__('Add New Subscriber')}}</h4>
                                        <form action="{{route('admin.newsletter.new.add')}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="email">{{__('Email')}}</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="{{__('Email')}}">
                                            </div>
                                            <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: Send Mail to All -->
                            <div class="tab-pane fade" id="send-mail-all" role="tabpanel">
                                <h4 class="header-title">{{__('Send Mail To All Subscriber')}}</h4>
                                <form action="{{route('admin.newsletter.mail')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="subject">{{__('Subject')}}</label>
                                        <input type="text" class="form-control"  id="subject" name="subject" placeholder="{{__('Subject')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">{{__('Message')}}</label>
                                        <input type="hidden" name="message" >
                                        <div class="summernote"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">{{__('Send Mail')}}</button>
                                    </div>
                                </form>
                            </div>

                        </div> <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="send_mail_to_subscriber_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Send Mail To Subscriber')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.newsletter.single.mail')}}" id="send_mail_to_subscriber_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{__('Email')}}</label>
                            <input type="text" readonly class="form-control"  id="email" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon">{{__('Subject')}}</label>
                            <input type="text" class="form-control"  id="subject" name="subject" placeholder="{{__('Subject')}}">
                        </div>
                        <div class="form-group">
                            <label for="message">{{__('Message')}}</label>
                            <input type="hidden" name="message" >
                            <div class="summernote"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Send Mail')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
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
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeNewsletterTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeNewsletterTab');
            if(activeTab){
                $('#newsletterTab a[href="' + activeTab + '"]').tab('show');
            }

            $('.table-wrap > table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ { "targets": 'no-sort', "orderable": false } ]
            });

            $(document).on('click','.send_mail_modal_btn',function(){
                var el = $(this);
                var email = el.data('email');
                var form = $('#send_mail_to_subscriber_edit_modal_form');
                form.find('#email').val(email);
            });

            $('.summernote').summernote({
                height: 300,
                codemirror: { theme: 'monokai' },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
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
                        'url' : "{{route('admin.newsletter.bulk.action')}}",
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
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).closest('table').find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });
        });
    </script>
@endsection
