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
                        <form action="{{route('admin.charity.home.section.manage')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_key_feature_section_status"><strong>{{__('Key Feature Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_key_feature_section_status"  @if(!empty(get_static_option('charity_home_page_key_feature_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_about_section_status"><strong>{{__('About Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_about_section_status"  @if(!empty(get_static_option('charity_home_page_about_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_our_mission_section_status"><strong>{{__('Our Mission Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_our_mission_section_status"  @if(!empty(get_static_option('charity_home_page_our_mission_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_recent_cause_section_status"><strong>{{__('Recent Cause Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_recent_cause_section_status"  @if(!empty(get_static_option('charity_home_page_recent_cause_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_our_gallery_section_status"><strong>{{__('Our Gallery Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_our_gallery_section_status"  @if(!empty(get_static_option('charity_home_page_our_gallery_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_our_events_section_status"><strong>{{__('Our Events Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_our_events_section_status"  @if(!empty(get_static_option('charity_home_page_our_events_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_counterup_section_status"><strong>{{__('Counterup Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_counterup_section_status"  @if(!empty(get_static_option('charity_home_page_counterup_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_team_member_section_status"><strong>{{__('Team Member Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_team_member_section_status"  @if(!empty(get_static_option('charity_home_page_team_member_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_testimonial_section_status"><strong>{{__('Testimonial Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_testimonial_section_status"  @if(!empty(get_static_option('charity_home_page_testimonial_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_news_blog_section_status"><strong>{{__('News & Blog Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_news_blog_section_status"  @if(!empty(get_static_option('charity_home_page_news_blog_section_status'))) checked @endif >
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="charity_home_page_brand_carousel_section_status"><strong>{{__('Brand Carousel Section Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="charity_home_page_brand_carousel_section_status"  @if(!empty(get_static_option('charity_home_page_brand_carousel_section_status'))) checked @endif >
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

