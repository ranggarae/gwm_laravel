@extends('backend.admin-master')
@section('site-title')
    {{__('Useful Links Widget Settings')}}
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Useful Link Widget Settings')}}</h4>
                        <form action="{{route('admin.footer.useful.link.widget')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                    <a class="nav-item nav-link useful_link_widget_tab_item @if($key == 0) active @endif" data-lang="{{$lang->slug}}" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30 " id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="useful_link_{{$lang->slug}}_widget_title">{{__('Widget Title')}}</label>
                                        <input type="text" class="form-control"  id="useful_link_{{$lang->slug}}_widget_title" value="{{get_static_option('useful_link_'.$lang->slug.'_widget_title')}}" name="useful_link_{{$lang->slug}}_widget_title" >
                                    </div>
                                    <div class="form-group">
                                        <label for="useful_link_{{$lang->slug}}_widget_menu_id">{{__('Select Menu')}}</label>
                                        <select name="useful_link_{{$lang->slug}}_widget_menu_id" data-value="{{get_static_option('useful_link_'.$lang->slug.'_widget_menu_id')}}" id="useful_link_{{$lang->slug}}_widget_menu_id" class="form-control">
                                            <option value="">{{__('Select Menu')}}</option>
                                            @foreach($all_menu as $data)
                                                <option value="{{$data->id}}" @if($data->id == get_static_option('useful_link_'.$lang->slug.'_widget_menu_id')) selected @endif >{{$data->title}}</option>
                                            @endforeach
                                        </select>
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
    <script>
        $(document).ready(function ($) {
            $(document).on('click','.useful_link_widget_tab_item',function (e) {
                var lang = $(this).data('lang');
                $.ajax({
                   url: "{{route('admin.footer.useful.link.menus')}}",
                   type: "POST",
                   data: {
                       _token : "{{csrf_token()}}",
                       lang : lang
                   },
                   success:function (data) {
                       var prevmenu = $('#useful_link_'+lang+'_widget_menu_id').data('value');
                        $('#useful_link_'+lang+'_widget_menu_id').html('');
                        $.each(data,function (index,value) {
                            var selected = prevmenu == value.id ? 'selected' : '';
                            $('#useful_link_'+lang+'_widget_menu_id').append('<option '+selected+' value="'+value.id+'">'+value.title+'</option>');
                        });
                   }
                });
            })
        })
    </script>
@endsection

