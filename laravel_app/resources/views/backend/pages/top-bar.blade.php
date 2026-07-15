@extends('backend.admin-master')
@section('site-title')
    {{__('Top Bar Settings')}}
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
            @if(get_static_option('home_page_variant') == '01')
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Top Bar Right Menu')}}</h4>
                        <form action="{{route('admin.top.right.menu')}}"  method="post">
                            @csrf
                            <ul class="nav nav-tabs"role="tablist">
                                @foreach($all_languages as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link useful_link_widget_tab_item @if($key == 0) active @endif"  data-lang="{{$lang->slug}}" data-toggle="tab" href="#home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" >
                                @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="top_bar_{{$lang->slug}}_right_menu">{{__('Right Menu')}}</label>
                                        <select name="top_bar_{{$lang->slug}}_right_menu" data-value="{{get_static_option('top_bar_'.$lang->slug.'_right_menu')}}" class="form-control" id="top_bar_{{$lang->slug}}_right_menu">
                                            @foreach($all_menu as $data)
                                                <option @if($data->id == get_static_option('top_bar_'.$lang->slug.'_right_menu')) selected @endif value="{{$data->id}}">{{$data->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @if(get_static_option('home_page_variant') == '01' || get_static_option('home_page_variant') == '02')
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Top Bar Button')}}</h4>
                        <form action="{{route('admin.top.button')}}"  method="post">
                            @csrf
                            <ul class="nav nav-tabs"role="tablist">
                                @foreach($all_languages as $key => $lang)
                                    <li class="nav-item">
                                        <a class="nav-link useful_link_widget_tab_item @if($key == 0) active @endif"  data-lang="{{$lang->slug}}" data-toggle="tab" href="#home-topbar-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-40" >
                            @foreach($all_languages as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="home-topbar-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="top_bar_{{$lang->slug}}_button_text">{{__('Button Text')}}</label>
                                        <input type="text" class="form-control"  id="top_bar_{{$lang->slug}}_button_text" name="top_bar_{{$lang->slug}}_button_text"  value="{{get_static_option('top_bar_'.$lang->slug.'_button_text')}}" placeholder="{{__('Button Text')}}">
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div class="form-group">
                                <label for="top_bar_get_quote_btn_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                <label class="switch">
                                    <input type="checkbox" name="top_bar_get_quote_btn_status"  @if(!empty(get_static_option('top_bar_get_quote_btn_status'))) checked @endif >
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Support Info Items')}}</h4>
                        <div class="right-cotnent margin-bottom-40"><a class="btn btn-primary" data-target="#add_support_info" data-toggle="modal" href="#">{{__('Add New Support Info')}}</a></div>
                        <ul class="nav nav-tabs" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_support_info as $key => $support_item)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" >
                            @php $b=0; @endphp
                            @foreach($all_support_info as $key => $support_item)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                    <table class="table table-default">
                                        <thead>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Icon')}}</th>
                                        <th>{{__('Details')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($support_item as $data)
                                            <tr>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td><i class="{{$data->icon}}"></i></td>
                                                <td>{{$data->details}}</td>
                                                <td>{{$data->link}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                                       role="button"
                                                       data-toggle="popover"
                                                       data-trigger="focus"
                                                       data-html="true"
                                                       title=""
                                                       data-content="
                                                       <h6>{{__('Are you sure to delete this support info item?')}}</h6>
                                                       <form method='post' action='{{route('admin.delete.support.info',$data->id)}}'>
                                                       <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                       <br>
                                                        <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                        </form>
                                                        ">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#support_info_item_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 support_info_edit_btn"
                                                       data-id="{{$data->id}}"
                                                       data-title="{{$data->title}}"
                                                       data-lang="{{$data->lang}}"
                                                       data-details="{{$data->details}}"
                                                       data-icon="{{$data->icon}}"
                                                    >
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @php $b++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Social Icons')}}</h4>
                        <div class="right-cotnent margin-bottom-40"><a class="btn btn-primary" data-target="#add_social_icon" data-toggle="modal" href="#">{{__('Add New Social Item')}}</a></div>
                        <table class="table table-default">
                            <thead>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Icon')}}</th>
                            <th>{{__('URL')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_social_icons as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td><i class="{{$data->icon}}"></i></td>
                                    <td>{{$data->url}}</td>
                                    <td>
                                        <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                           role="button"
                                           data-toggle="popover"
                                           data-trigger="focus"
                                           data-html="true"
                                           title=""
                                           data-content="
                                               <h6>{{__('Are you sure to delete this social item?')}}</h6>
                                               <form method='post' action='{{route('admin.delete.social.item',$data->id)}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <br>
                                                <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                </form>
                                                ">
                                            <i class="ti-trash"></i>
                                        </a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#social_item_edit_modal"
                                           class="btn btn-lg btn-primary btn-sm mb-3 mr-1 social_item_edit_btn"
                                           data-id="{{$data->id}}"
                                           data-url="{{$data->url}}"
                                           data-icon="{{$data->icon}}"
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_support_info" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add New Support Info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.new.support.info')}}"  method="post">
                    <div class="modal-body">
                        @csrf
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
                            <input type="text" class="form-control"  id="title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control"  id="icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="details">{{__('Details')}}</label>
                            <input type="text" class="form-control"  id="details" name="details" placeholder="{{__('Details')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add New Support Info Item')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="support_info_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Support Info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.update.support.info')}}"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="support_info_id" name="id">
                        <div class="form-group">
                            <label for="edit_language"><strong>{{__('Language')}}</strong></label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach($all_languages as $lang)
                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control"  id="edit_icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="edit_details">{{__('Details')}}</label>
                            <input type="text" class="form-control"  id="edit_details" name="details" placeholder="{{__('Details')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_social_icon" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add Social Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.new.social.item')}}"  method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control"  id="icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="social_item_link">{{__('URL')}}</label>
                            <input type="text" name="url" id="social_item_link"  class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add Social Item')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="social_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Social Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.update.social.item')}}"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="social_item_id" value="">
                        <div class="form-group">
                            <label for="social_item_edit_icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control"  id="social_item_edit_icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="social_item_edit_url">{{__('Url')}}</label>
                            <input type="text" class="form-control"  id="social_item_edit_url" name="url" placeholder="{{__('Url')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function () {
            $(document).on('click','.support_info_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var details = el.data('details');
                var icon = el.data('icon');
                var form = $('#support_info_item_edit_modal');
                form.find('#support_info_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_icon').val(icon);
                form.find('#edit_details').val(details);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);
            });

            $(document).on('click','.social_item_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var url = el.data('url');
                var icon = el.data('icon');
                var form = $('#social_item_edit_modal');
                form.find('#social_item_id').val(id);
                form.find('#social_item_edit_icon').val(icon);
                form.find('#social_item_edit_url').val(url);
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);
            });

            $(document).on('click','.useful_link_widget_tab_item',function (e) {
                var lang = $(this).data('lang');
                $.ajax({
                    url: "{{route('admin.topbar.menu.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : lang
                    },
                    success:function (data) {
                        var prevmenu = $('#top_bar_'+lang+'_right_menu').data('value');
                        $('#top_bar_'+lang+'_right_menu').html('');
                        $.each(data,function (index,value) {
                            var selected = prevmenu == value.id ? 'selected' : '';
                            $('#top_bar_'+lang+'_right_menu').append('<option '+selected+' value="'+value.id+'">'+value.title+'</option>');
                        });
                    }
                });
            });

            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
            });
        });
    </script>
@endsection