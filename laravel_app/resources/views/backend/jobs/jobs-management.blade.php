@extends('backend.admin-master')
@section('site-title')
    {{__('Job Post Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{ padding: 0 !important; }
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
                        <h4 class="header-title">{{__('Job Post Management')}}</h4>
                        
                        <ul class="nav nav-tabs" id="jobPostTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all-jobs" role="tab">{{__('All Jobs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#add-job" role="tab">{{__('Add New Job')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#categories" role="tab">{{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#applicants" role="tab">{{__('All Applicants')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#page-settings" role="tab">{{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="jobPostTabContent">
                            
                            <!-- TAB: All Jobs -->
                            <div class="tab-pane fade show active" id="all-jobs" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap">
                                        <select name="bulk_option" id="bulk_option_jobs" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                            <option value="publish">{{{__('Publish')}}}</option>
                                            <option value="draft">{{{__('Draft')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_jobs">{{__('Apply')}}</button>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs" id="langTabJobs" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_jobs as $key => $slider)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#jobs_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>

                                <div class="tab-content margin-top-40" id="langTabJobsContent">
                                    @php $b=0; @endphp
                                    @foreach($all_jobs as $key => $items)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="jobs_tab_{{$key}}" role="tabpanel">
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default">
                                                    <thead>
                                                        <th class="no-sort">
                                                            <div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div>
                                                        </th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Title')}}</th>
                                                        <th>{{__('Position')}}</th>
                                                        <th>{{__('Category')}}</th>
                                                        <th>{{__('Vacancy')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Deadline')}}</th>
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
                                                            <td>{{$data->position}}</td>
                                                            <td>{{get_jobs_category_by_id($data->id)}}</td>
                                                            <td>{{$data->vacancy}}</td>
                                                            <td>
                                                                @if('publish' == $data->status)
                                                                    <span class="btn btn-success btn-xs">{{ucfirst($data->status)}}</span>
                                                                @else
                                                                    <span class="btn btn-warning btn-xs">{{ucfirst($data->status)}}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{date("d-M-Y", strtotime($data->deadline))}}</td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                   <h6>{{__('Are you sure to delete this job post?')}}</h6>
                                                                   <form method='post' action='{{route('admin.jobs.delete',$data->id)}}'>
                                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                   <br>
                                                                    <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                    </form>
                                                                    ">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.jobs.edit',$data->id)}}">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form action="{{route('admin.jobs.clone')}}" method="post" style="display: inline-block">
                                                                    @csrf
                                                                    <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                    <button type="submit" class="btn btn-secondary btn-xs mb-3 mr-1" title="{{__('Clone this post')}}"><i class="ti-copy"></i></button>
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

                            <!-- TAB: Add New Job -->
                            <div class="tab-pane fade" id="add-job" role="tabpanel">
                                <h4 class="header-title">{{__('Add New Job Post')}}</h4>
                                <form action="{{route('admin.jobs.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="language_add"><strong>{{__('Language')}}</strong></label>
                                        <select name="lang" id="language_add" class="form-control">
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
                                        <label for="slug">{{__('Slug')}}</label>
                                        <input type="text" class="form-control" id="slug" name="slug" placeholder="{{__('Slug')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="position">{{__('Job Position')}}</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="{{__('Position')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_name">{{__('Company Name')}}</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="{{__('Company Name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_add">{{__('Category')}}</label>
                                        <select name="category_id" class="form-control" id="category_add">
                                            <option value="">{{__("Select Category")}}</option>
                                            @foreach($all_category_flat as $cat)
                                                <option value="{{$cat->id}}">{{$cat->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vacancy">{{__('Vacancy')}}</label>
                                        <input type="text" class="form-control" id="vacancy" name="vacancy" placeholder="{{__('Vacancy')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="job_context">{{__('Job Context')}}</label>
                                        <textarea name="job_context" id="job_context" class="form-control" cols="30" placeholder="{{__('Job Context')}}" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_responsibility">{{__('Job Responsibility')}}</label>
                                        <textarea name="job_responsibility" id="job_responsibility" class="form-control" cols="30" placeholder="{{__('Job Responsibility')}}" rows="10"></textarea>
                                        <small class="info-text">{{__('separate responsibility by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="education_requirement">{{__('Educational Requirements')}}</label>
                                        <textarea name="education_requirement" id="education_requirement" class="form-control" cols="30" placeholder="{{__('Educational Requirements')}}" rows="10"></textarea>
                                        <small class="info-text">{{__('separate requirements by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="experience_requirement">{{__('Experience Requirements')}}</label>
                                        <textarea name="experience_requirement" id="experience_requirement" class="form-control" cols="30" placeholder="{{__('Experience Requirements')}}" rows="10"></textarea>
                                        <small class="info-text">{{__('separate requirements by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="additional_requirement">{{__('Additional Requirements')}}</label>
                                        <textarea name="additional_requirement" id="additional_requirement" class="form-control" cols="30" placeholder="{{__('Additional Requirements')}}" rows="10"></textarea>
                                        <small class="info-text">{{__('separate requirements by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="employment_status">{{__('Employment Status')}}</label>
                                        <select name="employment_status" id="employment_status" class="form-control">
                                            <option value="full_time">{{__('Full-Time')}}</option>
                                            <option value="part_time">{{__('Part-Time')}}</option>
                                            <option value="project_based">{{__('Project Based')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_location">{{__('Job Location')}}</label>
                                        <input type="text" class="form-control" id="job_location" name="job_location" placeholder="{{__('Job Location')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="other_benefits">{{__('Compensation & Other Benefits')}}</label>
                                        <textarea name="other_benefits" id="other_benefits" class="form-control" cols="30" placeholder="{{__('Compensation & Other Benefits')}}" rows="10"></textarea>
                                        <small class="info-text">{{__('separate benefits by pipe (|), to break in new line')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">{{__('Salary')}}</label>
                                        <input type="text" class="form-control" id="salary" name="salary" placeholder="{{__('Salary')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="deadline">{{__('Deadline')}}</label>
                                        <input type="date" class="form-control" id="deadline" name="deadline">
                                    </div>
                                    <div class="form-group">
                                        <label for="is_featured_add"><strong>{{__('Is Featured')}}</strong></label>
                                        <label class="switch ">
                                            <input type="checkbox" name="is_featured" id="is_featured_add">
                                            <span class="slider onff"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags">{{__('Meta Tags')}}</label>
                                        <input type="text" name="meta_tags" class="form-control" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">{{__('Meta Description')}}</label>
                                        <textarea name="meta_description" class="form-control" rows="5" id="meta_description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_logo">{{__('Company Logo')}}</label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap"></div>
                                            <input type="hidden" name="company_logo">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__('Upload Image')}}
                                            </button>
                                        </div>
                                        <small>{{__('Recommended image size 80x80')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_add">{{__('Status')}}</label>
                                        <select name="status" id="status_add" class="form-control">
                                            <option value="publish">{{__('Publish')}}</option>
                                            <option value="draft">{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Job')}}</button>
                                </form>
                            </div>

                            <!-- TAB: Categories -->
                            <div class="tab-pane fade" id="categories" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-8 border-right">
                                        <h4 class="header-title">{{__('All Job Categories')}}</h4>
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
                                            @foreach($all_category as $key => $slider)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#cat_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>

                                        <div class="tab-content margin-top-40" id="langTabCategoryContent">
                                            @php $b=0; @endphp
                                            @foreach($all_category as $key => $category)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="cat_tab_{{$key}}" role="tabpanel">
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
                                                                           <form method='post' action='{{route('admin.jobs.category.delete',$data->id)}}'>
                                                                           <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                           <br>
                                                                            <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                            </form>
                                                                            ">
                                                                            <i class="ti-trash"></i>
                                                                        </a>
                                                                        <a href="#" data-toggle="modal" data-target="#jobs_category_edit_modal" class="btn btn-primary btn-xs mb-3 mr-1 category_edit_btn"
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
                                        <form action="{{route('admin.jobs.category.new')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="language_cat">{{__('Language')}}</label>
                                                <select name="lang" id="language_cat" class="form-control">
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
                                                <label for="status_cat">{{__('Status')}}</label>
                                                <select name="status" class="form-control" id="status_cat">
                                                    <option value="publish">{{__("Publish")}}</option>
                                                    <option value="draft">{{__("Draft")}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: All Applicants -->
                            <div class="tab-pane fade" id="applicants" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__('Applicant Report')}}</h4>
                                                <form action="{{route('admin.jobs.applicant')}}" method="get" class="row">
                                                    <input type="hidden" name="active_tab" value="#applicants">
                                                    <div class="col-md-3 form-group">
                                                        <label>{{__('Start Date')}}</label>
                                                        <input type="date" name="start_date" value="{{$start_date}}" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>{{__('End Date')}}</label>
                                                        <input type="date" name="end_date" value="{{$end_date}}" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>{{__('Job Post')}}</label>
                                                        <select name="job_id" class="form-control">
                                                            <option value="">{{__('All Job')}}</option>
                                                            @foreach($jobs as $job)
                                                                <option @if($job->id == $job_id) selected @endif value="{{$job->id}}">{{$job->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label>{{__('Items')}}</label>
                                                        <input type="number" name="items" value="{{$items ?? 10}}" class="form-control">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-info">{{__('Generate Report')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <h4 class="header-title">{{__('All Applicants')}}</h4>
                                        @if(!empty($error_msg))
                                            <div class="alert alert-warning">{{$error_msg}}</div>
                                        @endif
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap">
                                                <select name="bulk_option" id="bulk_option_applicant" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_applicant">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <div class="table-wrap table-responsive">
                                            <table class="table table-default">
                                                <thead>
                                                    <th class="no-sort">
                                                        <div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div>
                                                    </th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Job Title')}}</th>
                                                    <th>{{__('Applicant Name')}}</th>
                                                    <th>{{__('Applicant Email')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                @php $loop_data = !empty($order_data) ? $order_data : $all_applicant; @endphp
                                                @foreach($loop_data as $data)
                                                    <tr>
                                                        <td>
                                                            <div class="bulk-checkbox-wrapper">
                                                                <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$data->id}}</td>
                                                        <td>{{$data->job_title}}</td>
                                                        <td>{{$data->name}}</td>
                                                        <td>{{$data->email}}</td>
                                                        <td>
                                                            <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                               <h6>{{__('Are you sure to delete this application?')}}</h6>
                                                               <form method='post' action='{{route('admin.jobs.applicant.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                </form>
                                                                ">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                            @php
                                                                $all_attachment = unserialize($data->attachment);
                                                            @endphp
                                                            @if(!empty($all_attachment))
                                                                @foreach($all_attachment as $name => $path)
                                                                    <a href="{{asset($path)}}" class="btn btn-info btn-xs mb-3 mr-1" download=""><i class="ti-download"></i> {{__('Resume')}}</a>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(!empty($order_data))
                                            <div class="pagination-wrapper">
                                                {!! $order_data->links() !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: Page Settings -->
                            <div class="tab-pane fade" id="page-settings" role="tabpanel">
                                <h4 class="header-title">{{__('Job Page Settings')}}</h4>
                                <form action="{{route('admin.jobs.page.settings')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="site_job_post_items">{{__('Jobs Page Items')}}</label>
                                        <input type="text" name="site_job_post_items" value="{{get_static_option('site_job_post_items')}}" class="form-control" id="site_job_post_items">
                                        <small>{{__('enter how many jobs you want to show in the jobs page')}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_applicant_mail">{{__('Job Applicant Mail')}}</label>
                                        <input type="text" name="job_applicant_mail" value="{{get_static_option('job_applicant_mail')}}" class="form-control" id="job_applicant_mail">
                                        <small>{{__('enter mail address where job application notification will be send')}}</small>
                                    </div>
                                    <hr>
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            @foreach($all_languages as $key => $lang)
                                                <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab">{{$lang->name}}</a>
                                            @endforeach
                                        </div>
                                    </nav>
                                    <div class="tab-content margin-top-30" id="nav-tabContent">
                                        @foreach($all_languages as $key => $lang)
                                            <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel">
                                                <div class="form-group">
                                                    <label for="site_jobs_category_{{$lang->slug}}_title">{{__('Category Title')}}</label>
                                                    <input type="text" name="site_jobs_category_{{$lang->slug}}_title" value="{{get_static_option('site_jobs_category_'.$lang->slug.'_title')}}" class="form-control" id="site_jobs_category_{{$lang->slug}}_title">
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
    <div class="modal fade" id="jobs_category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.jobs.category.update')}}" id="jobs_category_edit_form" method="post">
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
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
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
                if (target.startsWith('#jobs_tab_')) {
                    localStorage.setItem('activeJobsLangTab', target);
                } else if (target.startsWith('#cat_tab_')) {
                    localStorage.setItem('activeJobsCategoryLangTab', target);
                } else if (target.startsWith('#nav-home-')) {
                    localStorage.setItem('activeJobsSettingsLangTab', target);
                } else {
                    localStorage.setItem('activeJobsTab', target);
                }
            });

            var activeTab = localStorage.getItem('activeJobsTab');
            if(activeTab){
                $('#jobPostTab a[href="' + activeTab + '"]').tab('show');
            }
            
            // Check url request params for report active tab
            var urlParams = new URLSearchParams(window.location.search);
            if(urlParams.has('active_tab')){
                var reqTab = urlParams.get('active_tab');
                $('#jobPostTab a[href="' + reqTab + '"]').tab('show');
            }

            var activeLangTab = localStorage.getItem('activeJobsLangTab');
            if(activeLangTab){
                $('#langTabJobs a[href="' + activeLangTab + '"]').tab('show');
            }
            var activeCatLangTab = localStorage.getItem('activeJobsCategoryLangTab');
            if(activeCatLangTab){
                $('#langTabCategory a[href="' + activeCatLangTab + '"]').tab('show');
            }
            var activeSettingsLangTab = localStorage.getItem('activeJobsSettingsLangTab');
            if(activeSettingsLangTab){
                $('#nav-tab a[href="' + activeSettingsLangTab + '"]').tab('show');
            }

            $('.table-wrap > table').DataTable({
                "order": [[1, "desc"]],
                "columnDefs": [ { "targets": 'no-sort', "orderable": false } ]
            });

            // Jobs Bulk Action
            $(document).on('click', '#bulk_delete_btn_jobs', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_jobs').val();
                var allCheckbox = $('#all-jobs .bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function (index, value) {
                    allIds.push($(this).val());
                });
                if (allIds != '') {
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type': "POST",
                        'url': "{{route('admin.jobs.bulk.action')}}",
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
                var allCheckbox = $('#categories .bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function (index, value) {
                    allIds.push($(this).val());
                });
                if (allIds != '') {
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type': "POST",
                        'url': "{{route('admin.jobs.category.bulk.action')}}",
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

            // Applicant Bulk Action
            $(document).on('click', '#bulk_delete_btn_applicant', function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option_applicant').val();
                var allCheckbox = $('#applicants .bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function (index, value) {
                    allIds.push($(this).val());
                });
                if (allIds != '') {
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type': "POST",
                        'url': "{{route('admin.jobs.applicant.bulk.delete')}}",
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

            // Edit Category Click
            $(document).on('click', '.category_edit_btn', function () {
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var status = el.data('status');
                var form = $('#jobs_category_edit_form');

                form.find('#category_id_edit').val(id);
                form.find('#edit_status_cat option[value="'+status+'"]').attr('selected',true);
                form.find('#edit_name_cat').val(name);
                form.find('#edit_language_cat option[value="'+el.data('lang')+'"]').attr('selected',true);
            });

            // Language change on Add Job
            $(document).on('change','#language_add',function(e){
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.jobs.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category_add').html('<option value="">Select Category</option>');
                        $.each(data,function(index,value){
                            $('#category_add').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            });
        });
    </script>
@endsection
