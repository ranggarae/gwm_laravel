@extends('backend.admin-master')
@section('site-title')
    {{__('Knowledgebase Management')}}
@endsection
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
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
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
                        <h4 class="header-title">{{__('Knowledgebase Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="knowledgeTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="articles-tab" data-toggle="tab" href="#articles_panel" role="tab" aria-controls="articles_panel" aria-selected="true">{{__('All Articles')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-article-tab" data-toggle="tab" href="#add_article_panel" role="tab" aria-controls="add_article_panel" aria-selected="false">{{__('Add New Article')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="topics-tab" data-toggle="tab" href="#topics_panel" role="tab" aria-controls="topics_panel" aria-selected="false">{{__('All Topics')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings_panel" role="tab" aria-controls="settings_panel" aria-selected="false">{{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="knowledgeTabsContent">
                            <!-- All Articles Tab -->
                            <div class="tab-pane fade show active" id="articles_panel" role="tabpanel" aria-labelledby="articles-tab">
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
                                    @foreach($all_article as $key => $article)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-40" id="myTabContent">
                                    @php $b=0; @endphp
                                    @foreach($all_article as $key => $article)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default" id="all_blog_table">
                                                    <thead>
                                                        <th class="no-sort">
                                                            <div class="mark-all-checkbox">
                                                                <input type="checkbox" class="all-checkbox">
                                                            </div>
                                                        </th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Title')}}</th>
                                                        <th>{{__('Topics')}}</th>
                                                        <th>{{__('Views')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Created At')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($article as $data)
                                                        <tr>
                                                            <td>
                                                                <div class="bulk-checkbox-wrapper">
                                                                    <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                                </div>
                                                            </td>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->title}}</td>
                                                            <td>{{optional($data->topic)->title}}</td>
                                                            <td>{{$data->views}}</td>
                                                            <td>
                                                                @if($data->status == 'publish')
                                                                    <span class="alert alert-success" style="margin-top: 20px;display: inline-block;">{{__('Publish')}}</span>
                                                                @else
                                                                    <span class="alert alert-warning" style="margin-top: 20px;display: inline-block;">{{__('Draft')}}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{date_format($data->created_at,'d/m/Y')}}</td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-xs btn-danger mb-3 mr-1"
                                                                   role="button"
                                                                   data-toggle="popover"
                                                                   data-trigger="focus"
                                                                   data-html="true"
                                                                   title=""
                                                                   data-content="
                                                                   <h6>{{__('Are you sure to delete this article?')}}</h6>
                                                                   <form method='post' action='{{route('admin.knowledge.delete',$data->id)}}'>
                                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                   <br>
                                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                                    </form>
                                                                    ">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.knowledge.edit',$data->id)}}">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-light btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.knowledgebase.single',$data->slug)}}">
                                                                    <i class="ti-eye"></i>
                                                                </a>
                                                                <form action="{{route('admin.knowledge.clone')}}" method="post" style="display: inline-block">
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

                            <!-- Add New Article Tab -->
                            <div class="tab-pane fade" id="add_article_panel" role="tabpanel" aria-labelledby="add-article-tab">
                                <form action="{{route('admin.knowledge.new')}}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control"  id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control"  id="slug" name="slug" value="{{old('slug')}}" placeholder="{{__('slug')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="topic">{{__('Topic')}}</label>
                                                <select name="topic_id" class="form-control" id="topic">
                                                    <option value="">{{__("Select Topic")}}</option>
                                                    @foreach($all_topics as $category)
                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Content')}}</label>
                                                <input type="hidden" name="kncontent" >
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
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" id="status"  class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Article')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- All Topics Tab -->
                            <div class="tab-pane fade" id="topics_panel" role="tabpanel" aria-labelledby="topics-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="bulk-delete-wrapper">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option_topic" id="bulk_option_topic">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_topic">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs" id="myTabTopic" role="tablist">
                                            @php $ta=0; @endphp
                                            @foreach($all_category as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($ta == 0) active @endif"  data-toggle="tab" href="#topic_tab_{{$key}}" role="tab" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $ta++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-40" id="myTabContentTopic">
                                            @php $tb=0; @endphp
                                            @foreach($all_category as $key => $category)
                                                <div class="tab-pane fade @if($tb == 0) show active @endif" id="topic_tab_{{$key}}" role="tabpanel" >
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default">
                                                            <thead>
                                                            <th class="no-sort">
                                                                <div class="mark-all-checkbox">
                                                                    <input type="checkbox" class="all-checkbox-topic">
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
                                                                            <input type="checkbox" class="bulk-checkbox-topic" name="bulk_delete_topic[]" value="{{$data->id}}">
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
                                                                        <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                                           role="button"
                                                                           data-toggle="popover"
                                                                           data-trigger="focus"
                                                                           data-html="true"
                                                                           title=""
                                                                           data-content="
                                                                           <h6>{{__('Are you sure to delete this topic?')}}</h6>
                                                                           <form method='post' action='{{route('admin.knowledge.category.delete',$data->id)}}'>
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
                                                @php $tb++; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__('Add New Topics')}}</h4>
                                                <form action="{{route('admin.knowledge.category.new')}}" method="post" enctype="multipart/form-data">
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
                                                        <input type="text" class="form-control"  id="name" name="title" placeholder="{{__('Name')}}">
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

                            <!-- Page Settings Tab -->
                            <div class="tab-pane fade" id="settings_panel" role="tabpanel" aria-labelledby="settings-tab">
                                <form action="{{route('admin.knowledge.page.settings')}}" method="POST" enctype="multipart/form-data">
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
                                                    <label for="site_knowledgebase_category_{{$lang->slug}}_title">{{__('Category Widget Title')}}</label>
                                                    <input type="text" name="site_knowledgebase_category_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('site_knowledgebase_category_'.$lang->slug.'_title')}}" id="site_knowledgebase_category_{{$lang->slug}}_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="site_knowledgebase_popular_widget_{{$lang->slug}}_title">{{__('Popular Article Widget Title')}}</label>
                                                    <input type="text" name="site_knowledgebase_popular_widget_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('site_knowledgebase_popular_widget_'.$lang->slug.'_title')}}" id="site_knowledgebase_popular_widget_{{$lang->slug}}_title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="site_knowledgebase_article_topic_{{$lang->slug}}_title">{{__('Article Topics Title')}}</label>
                                                    <input type="text" name="site_knowledgebase_article_topic_{{$lang->slug}}_title"  class="form-control" value="{{get_static_option('site_knowledgebase_article_topic_'.$lang->slug.'_title')}}" id="site_knowledgebase_article_topic_{{$lang->slug}}_title">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="site_knoeledgebase_post_items">{{__('Knowledgebase Topics')}}</label>
                                        <input type="text" class="form-control" name="site_knoeledgebase_post_items" id="site_knoeledgebase_post_items" value="{{get_static_option('site_knoeledgebase_post_items')}}">
                                    </div>
                                    <small>{{__('Select Category To Show category in Knowledgebase page')}}</small>
                                    <br>

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
                    <h5 class="modal-title">{{__('Update Topics')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.knowledge.category.update')}}"  method="post">
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
                            <input type="text" class="form-control"  id="edit_name" name="title" placeholder="{{__('Name')}}">
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
            $('#knowledgeTabs a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
            // store the currently selected tab in the local storage
            $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.localStorage.setItem('activeTabKnowledge', id);
            });
            var activeTab = window.localStorage.getItem('activeTabKnowledge');
            if (activeTab) {
                $('#knowledgeTabs a[href="#' + activeTab + '"]').tab('show');
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

            // Bulk Delete Articles
            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.knowledge.bulk.action')}}",
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

            // Bulk Delete Topics
            $(document).on('click','#bulk_delete_btn_topic',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_topic').val();
                var allCheckbox =  $('.bulk-checkbox-topic:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != '' && bulkOption != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.knowledge.category.bulk.action')}}",
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

            $('.all-checkbox-topic').on('change',function (e) {
                e.preventDefault();
                var value = $(this).is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox-topic');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            // Edit Topic
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

            // Language change on new article tab to filter topics
            $(document).on('change','#language',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.knowledge.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#topic').html('<option value="">Select Topic</option>');
                        $.each(data,function(index,value){
                            $('#topic').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
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
    @include('backend.partials.media-upload.media-js')
@endsection
