@extends('backend.admin-master')
@section('site-title')
    {{__('Contact Page')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
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
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Contact Settings')}}</h4>
                        <form action="{{route('admin.contact')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="page_title">{{__('Page Title')}}</label>
                                <input type="text" class="form-control"  id="page_title" value="{{get_static_option('contact_page_title')}}" name="page_title" placeholder="{{__('Page Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="get_title">{{__('Get In Touch Title')}}</label>
                                <input type="text" class="form-control"  id="get_title" value="{{get_static_option('contact_page_get_title')}}" name="get_title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="get_description">{{__('Get In Touch Description')}}</label>
                                <textarea name="get_description" id="get_description" cols="30" class="form-control" rows="10">{{get_static_option('contact_page_get_description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="latitude">{{__('Google Map Latitude')}}</label>
                                <input type="text" class="form-control"  id="latitude" value="{{get_static_option('contact_page_latitude')}}" name="latitude" placeholder="{{__('Latitude')}}">
                            </div> <div class="form-group">
                                <label for="longitude">{{__('Google Map Longitude')}}</label>
                                <input type="text" class="form-control"  id="longitude" value="{{get_static_option('contact_page_longitude')}}" name="longitude" placeholder="{{__('Longitude')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Contact Page Info')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Contact Info Items')}}</h4>
                        <div class="right-cotnent margin-bottom-40"><a class="btn btn-primary" data-target="#add_contact_info" data-toggle="modal" href="#">{{__('Add New Contact Info')}}</a></div>
                        <table class="table table-default">
                            <thead>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Icon')}}</th>
                            <th>{{__('Description')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_contact_info_item as $data)
                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->title}}</td>
                                    <td><i class="{{$data->icon}}"></i></td>
                                    <td>{{$data->description}}</td>
                                    <td>
                                        <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                           role="button"
                                           data-toggle="popover"
                                           data-trigger="focus"
                                           data-html="true"
                                           title=""
                                           data-content="
                                               <h6>Are you sure to delete this contact info item?</h6>
                                               <form method='post' action='{{route('admin.delete.contact.info',$data->id)}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <br>
                                                <input type='submit' class='btn btn-danger btn-sm' value='Yes,Delete'>
                                                </form>
                                                ">
                                            <i class="ti-trash"></i>
                                        </a>
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#contact_info_item_edit_modal"
                                           class="btn btn-lg btn-primary btn-sm mb-3 mr-1 contact_info_edit_btn"
                                           data-id="{{$data->id}}"
                                           data-title="{{$data->title}}"
                                           data-description="{{$data->description}}"
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
    <div class="modal fade" id="add_contact_info" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add Contact Info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.new.contact.info')}}"  method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="title" name="title" placeholder="{{__('Title')}}">
                            <small class="text-danger">this is just a title in not show in frontend</small>
                        </div>
                        <div class="form-group">
                            <label for="username">{{__('Icon')}}</label>
                            <input type="text" class="form-control fa-icon-picker"  id="icon" name="icon" placeholder="{{__('Icon')}}">
                        </div>
                        <div class="form-group">
                            <label for="description">{{__('Description')}}</label>
                            <textarea name="description" id="description" cols="30" class="form-control" rows="10"></textarea>
                            <small class="text-danger">use ( ; ) to show it in next line in frontend</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add New Contact Info Item')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contact_info_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Contact Info')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.update.contact.info')}}" id="contact_info_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="contact_info_id" value="">
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Title')}}">
                            <small class="text-danger">this is just a title in not show in frontend</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_icon">{{__('Icon')}}</label>
                            <input type="text" class="form-control fa-icon-picker"  id="edit_icon" name="icon" placeholder="{{__('Icon')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{__('Description')}}</label>
                            <textarea name="description" id="edit_description" cols="30" class="form-control" rows="10"></textarea>
                            <small class="text-danger">use ( ; ) to show it in next line in frontend</small>
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
            $(document).on('click','.contact_info_edit_btn',function(){
                alert('ddd')
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var description = el.data('description');
                var icon = el.data('icon');
                var form = $('#contact_info_edit_modal_form');
                form.find('#contact_info_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_icon').val(icon);
                form.find('#edit_description').val(description);
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);

                console.log(form.find('.iconpicker-component i'));

            });
        });
    </script>
@endsection
