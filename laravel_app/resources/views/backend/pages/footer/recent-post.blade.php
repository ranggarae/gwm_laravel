@extends('backend.admin-master')
@section('site-title')
    {{__('Recent Post Widget Settings')}}
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
                        <h4 class="header-title">{{__('Recent Post Widget Settings')}}</h4>
                        <form action="{{route('admin.footer.recent.post')}}" method="post" enctype="multipart/form-data">
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
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                        <div class="form-group">
                                            <label for="recent_post_{{$lang->slug}}_widget_title">{{__('Widget Title')}}</label>
                                            <input type="text" class="form-control"  id="recent_post_{{$lang->slug}}_widget_title"  value="{{get_static_option('recent_post_'.$lang->slug.'_widget_title')}}" name="recent_post_{{$lang->slug}}_widget_title" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="recent_post_widget_item">{{__('Recent Post Number')}}</label>
                                <input type="text" class="form-control" id="recent_post_widget_item"  value="{{get_static_option('recent_post_widget_item')}}" name="recent_post_widget_item" >
                                <small class="text-danger">{{__('enter how many news you want to show in this widget')}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
