@extends('backend.admin-master')
@section('site-title')
    {{__('Work Single Page Settings')}}
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
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Work Single Page Settings')}}</h4>
                        <form action="{{route('admin.work.single.page.settings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                        <a class="nav-item nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key ==0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_related_work_title">{{__('Related Work Title')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_related_work_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_related_work_title')}}" class="form-control" id="work_single_page_{{$lang->slug}}_related_work_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_sidebar_title">{{__('Sidebar Title')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_sidebar_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_sidebar_title')}}" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_start_date_text">{{__('Start Date Text')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_start_date_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_start_date_text')}}" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_end_date_text">{{__('End Date Text')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_end_date_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_end_date_text')}}" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_clients_text">{{__('Clients Text')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_clients_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_clients_text')}}" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_category_text">{{__('Category Text')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_category_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_category_text')}}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_share_text">{{__('Share Text')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_share_text" value="{{get_static_option('work_single_page_'.$lang->slug.'_share_text')}}" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                            <label for="work_single_page_{{$lang->slug}}_gallery_title">{{__('Gallery Title')}}</label>
                                            <input type="text" name="work_single_page_{{$lang->slug}}_gallery_title" value="{{get_static_option('work_single_page_'.$lang->slug.'_gallery_title')}}" class="form-control" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
