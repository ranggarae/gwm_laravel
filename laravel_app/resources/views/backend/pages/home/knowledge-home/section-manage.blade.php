@extends('backend.admin-master')

@section('site-title')
    {{__('Section Manage')}}
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
                        <h4 class="header-title">{{__('Section Manage')}}</h4>
                        <form action="{{route('admin.knowledge.home.section.manage')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="home_page_support_bar_section_status"><strong>{{__('Topbar Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="home_page_support_bar_section_status"  @if(!empty(get_static_option('home_page_support_bar_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_highlight_box_section_status"><strong>{{__('Highlight Box Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_highlight_box_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_highlight_box_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_popular_article_section_status"><strong>{{__('Popular Article Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_popular_article_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_popular_article_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_testimonial_section_status"><strong>{{__('Testimonial Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_testimonial_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_testimonial_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_faq_section_status"><strong>{{__('Faq Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_faq_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_faq_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_team_section_status"><strong>{{__('Team Member Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_team_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_team_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="knowledgebase_home_page_cta_section_status"><strong>{{__('Call To Action Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="knowledgebase_home_page_cta_section_status"  @if(!empty(get_static_option('knowledgebase_home_page_cta_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

