@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
@endsection
@section('site-title')
    {{__('About Team Section')}}
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
                        <h4 class="header-title">{{__('About Team Section Settings')}}</h4>
                        <form action="{{route('admin.team.page.about')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_language as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_language as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="team_page_{{$lang->slug}}_about_section_title">{{__('Title')}}</label>
                                        <input type="text" name="team_page_{{$lang->slug}}_about_section_title" value="{{get_static_option('team_page_'.$lang->slug.'_about_section_title')}}" class="form-control" id="team_page_{{$lang->slug}}_about_section_title">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <input type="hidden" name="team_page_{{$lang->slug}}_about_section_description" value="{{get_static_option('team_page_'.$lang->slug.'_about_section_description')}}">
                                        <div class="summernote" data-content='{{get_static_option('team_page_'.$lang->slug.'_about_section_description')}}'></div>
                                    </div>
                                    <div class="img-wrap">
                                        @if(file_exists('assets/uploads/'.get_static_option('team_page_'.$lang->slug.'_about_section_image')))
                                            <img style="max-width: 150px" src="{{asset('assets/uploads/'.get_static_option('team_page_'.$lang->slug.'_about_section_image'))}}" alt="">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="team_page_{{$lang->slug}}_about_section_image">{{__('Image')}}</label>
                                        <input type="file" class="form-control" name="team_page_{{$lang->slug}}_about_section_image" id="team_page_{{$lang->slug}}_about_section_image">
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

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function () {
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
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }
        });
    </script>
@endsection