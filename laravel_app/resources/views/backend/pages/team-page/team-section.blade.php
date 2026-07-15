@extends('backend.admin-master')
@section('site-title')
    {{__('Team Member Section')}}
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
                        <h4 class="header-title">{{__('Team Member Section Settings')}}</h4>
                        <form action="{{route('admin.team.page.team.member')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_language as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                @foreach($all_language as $key => $lang)
                                <div class="tab-pane fade @if($key ==0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="team_page_{{$lang->slug}}_team_member_section_title">{{__('Title')}}</label>
                                        <input type="text" name="team_page_{{$lang->slug}}_team_member_section_title" value="{{get_static_option('team_page_'.$lang->slug.'_team_member_section_title')}}" class="form-control" id="team_page_{{$lang->slug}}_team_member_section_title">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="team_page_team_member_section_item">{{__('Team Member Items')}}</label>
                                <input type="text" name="team_page_team_member_section_item" value="{{get_static_option('team_page_team_member_section_item')}}" class="form-control" id="team_page_team_member_section_item">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

