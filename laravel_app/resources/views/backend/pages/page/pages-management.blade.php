@extends('backend.admin-master')
@section('site-title')
    {{__('Pages Management')}}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{ padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #A16207; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; }
        .tab-content { padding-top: 10px; }
        
        .language-tabs { margin-bottom: 15px; }
        .language-tabs .nav-link { padding: 8px 16px; font-size: 14px; }
    </style>
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
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
                        <h4 class="header-title">{{__('Pages Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="pagesManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-pages-tab" data-toggle="tab" href="#all-pages" role="tab" aria-controls="all-pages" aria-selected="true">{{__('All Pages')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-tab" data-toggle="tab" href="#add-new" role="tab" aria-controls="add-new" aria-selected="false">{{__('Add New Page')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="pagesManagementTabContent">
                            <!-- TAB 1: ALL PAGES -->
                            <div class="tab-pane fade show active" id="all-pages" role="tabpanel" aria-labelledby="all-pages-tab">
                                <ul class="nav nav-tabs language-tabs" id="myTab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_page as $key => $page)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @php $b=0; @endphp
                                    @foreach($all_page as $key => $pages)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default">
                                                <thead>
                                                <th>{{__('ID')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Date')}}</th>
                                                <th>{{__('Status')}}</th>
                                                <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                @foreach($pages as $data)
                                                    <tr>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->title}}</td>
                                                        <td>{{$data->created_at->diffForHumans()}}</td>
                                                        <td>
                                                            @if($data->status == 'publish')
                                                                <span class="alert alert-success">{{__('Publish')}}</span>
                                                            @else
                                                                <span class="alert alert-warning">{{__('Draft')}}</span>
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
                                                       <h6>Are you sure to delete this page?</h6>
                                                       <form method='post' action='{{route('admin.page.delete',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-danger btn-sm' value='Yes,Delete'>
                                                        </form>
                                                        ">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                            <a class="btn btn-lg btn-primary btn-sm mb-3 mr-1" href="{{route('admin.page.edit',$data->id)}}">
                                                                <i class="ti-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-lg btn-info btn-sm mb-3 mr-1" target="_blank" href="{{route('frontend.dynamic.page',['id' => $data->id, 'any' => Str::slug($data->title)])}}">
                                                                <i class="ti-eye"></i>
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

                            <!-- TAB 2: ADD NEW PAGE -->
                            <div class="tab-pane fade" id="add-new" role="tabpanel" aria-labelledby="add-new-tab">
                                <form action="{{route('admin.page.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>{{__('Language')}}</label>
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
                                                <input type="text" class="form-control"  name="slug" placeholder="{{__('eg: page-slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="page_content" >
                                                <div class="summernote"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>{{__('Status')}}</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Page Meta Tags')}}</label>
                                                <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" id="meta_tags">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description">{{__('Page Meta Description')}}</label>
                                                <textarea name="meta_description"  class="form-control" id="meta_description"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Page')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Keep track of active tab after reload
            $('a[data-toggle="tab"][id$="-tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activePagesTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activePagesTab');
            if(activeTab){
                $('#pagesManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            $('.table-wrap > table').DataTable( {
                "order": [[ 0, "desc" ]]
            } );

            $('.summernote').summernote({
                height: 400,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            if($('.summernote').length > 1){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
