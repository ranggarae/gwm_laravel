@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{ padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #A16207; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; }
        .tab-content { padding-top: 10px; }
    </style>
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection

@section('site-title')
    {{__('Admin Management')}}
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Admin Management')}}</h4>
                        
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

                        <ul class="nav nav-tabs" id="adminManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-admins-tab" data-toggle="tab" href="#all-admins" role="tab" aria-controls="all-admins" aria-selected="true">{{__('All Admins')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-tab" data-toggle="tab" href="#add-new" role="tab" aria-controls="add-new" aria-selected="false">{{__('Add New Admin')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="false">{{__('Admin Roles')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="adminManagementTabContent">
                            <!-- TAB 1: ALL ADMINS -->
                            <div class="tab-pane fade show active" id="all-admins" role="tabpanel" aria-labelledby="all-admins-tab">
                                <div class="data-tables datatable-primary">
                                    <table id="all_user_table" class="table text-center">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Username')}}</th>
                                            <th>{{__('Image')}}</th>
                                            <th>{{__('Role')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_user as $data)
                                            <tr>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->username}}</td>
                                                <td>
                                                    @php
                                                        $img_url ='';
                                                        $author_img = get_attachment_image_by_id($data->image,null,true);
                                                    @endphp
                                                    @if (!empty($author_img))
                                                        <div class="img-wrap">
                                                            <div class="attachment-preview">
                                                                <div class="thumbnail">
                                                                    <div class="centered">
                                                                        <img class="avatar user-thumb" src="{{$author_img['img_url']}}" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php  $img_url = $author_img['img_url']; @endphp
                                                    @endif
                                                </td>
                                                <td>{{get_user_role_name_by_id($data->role)}}</td>
                                                <td>{{$data->email}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>Are you sure to delete this user?</h6>
                                                   <form method='post' action='{{route('admin.delete.user',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='Yes,Delete'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-name="{{$data->name}}"
                                                       data-role="{{$data->role}}"
                                                       data-email="{{$data->email}}"
                                                       data-imageid="{{$data->image}}"
                                                       data-image="{{$img_url}}"
                                                       data-toggle="modal"
                                                       data-target="#user_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn"
                                                    >
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-toggle="modal"
                                                       data-target="#user_change_password_modal"
                                                       class="btn btn-lg btn-info btn-sm mb-3 mr-1 user_change_password_btn"
                                                    >
                                                        {{__("Change Password")}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 2: ADD NEW ADMIN -->
                            <div class="tab-pane fade" id="add-new" role="tabpanel" aria-labelledby="add-new-tab">
                                <form action="{{route('admin.new.user')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{__('Name')}}</label>
                                                <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Enter name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">{{__('Username')}}</label>
                                                <input type="text" class="form-control"  id="username" name="username" placeholder="{{__('Username')}}">
                                                <small class="text text-danger">{{__('Remember this username, user will login using this username')}}</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">{{__('Email')}}</label>
                                                <input type="text" class="form-control"  id="email" name="email" placeholder="{{__('Email')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">{{__('Password')}}</label>
                                                <input type="password" class="form-control"  id="password" name="password" placeholder="{{__('Password')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">{{__('Password Confirm')}}</label>
                                                <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" placeholder="{{__('Password Confirmation')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="role">{{'Role'}}</label>
                                                <select name="role" id="role" class="form-control">
                                                    @foreach( $all_admin_role as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">{{__('Image')}}</label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap"></div>
                                            <input type="hidden" name="image">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Team Image" data-modaltitle="Upload Team Image" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__('Upload Image')}}
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New User')}}</button>
                                </form>
                            </div>

                            <!-- TAB 3: ADMIN ROLES -->
                            <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="data-tables datatable-primary">
                                            <table id="all_role_table" class="table text-center">
                                                <thead class="text-capitalize">
                                                <tr>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Role')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($all_admin_role as $data)
                                                        <tr>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->name}}</td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-danger btn-sm" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                               <h6>{{__('Are you sure to delete this role?')}}</h6>
                                                               <form method='post' action='{{route('admin.user.role.delete',$data->id)}}'>
                                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                               <br>
                                                                <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                                </form>
                                                                " data-original-title="">
                                                                    <i class="ti-trash"></i>
                                                                </a>
                                                                <a data-toggle="modal" data-target="#role_edit_modal" data-id="{{$data->id}}" data-name="{{$data->name}}" class="btn btn-primary btn-sm edit_role_modal_btn">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <a href="{{route('admin.user.role.edit',$data->id)}}" class="btn btn-info btn-sm">
                                                                     {{__('Add/Edit Permission')}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h4 class="header-title">{{__('Add New Admin Role')}}</h4>
                                                <form action="{{route('admin.all.user.role')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name">{{__('Role Name')}}</label>
                                                        <input type="text" class="form-control" name="name" placeholder="{{__('Enter Role name')}}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Role')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('User Details Edit')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.user.update')}}" id="user_edit_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name">{{__('Name')}}</label>
                            <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Enter name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{__('Email')}}</label>
                            <input type="text" class="form-control"  id="email" name="email" placeholder="{{__('Email')}}">
                        </div>
                        <div class="form-group">
                            <label for="role">{{__('Role')}}</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($all_admin_role as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">{{__('Image')}}</label>
                            <div class="image-wrap">
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" id="edit_image" name="image" value="">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Team Image" data-modaltitle="Upload Team Image" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="user_change_password_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Change Admin Password')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.user.password.change')}}" id="user_password_change_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ch_user_id" id="ch_user_id">
                        <div class="form-group">
                            <label for="password">{{__('Password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{__('Enter Password')}}">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{__('Confirm Password')}}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{__('Confirm Password')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Change Password')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="role_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Admin Role Edit')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.user.role.update')}}" id="role_edit_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="edit_name">{{__('Role Name')}}</label>
                            <input type="text" class="form-control" name="name" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Keep track of active tab after reload
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeAdminTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeAdminTab');
            if(activeTab){
                $('#adminManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            $('#all_user_table').DataTable( { "order": [[ 0, "desc" ]] } );
            $('#all_role_table').DataTable( { "order": [[ 0, "desc" ]] } );

            $(document).on('click','.user_change_password_btn',function(e){
                e.preventDefault();
                $('#user_password_change_modal_form').find('#ch_user_id').val($(this).data('id'));
            });

            $(document).on('click','.user_edit_btn',function(e){
                e.preventDefault();
                var form = $('#user_edit_modal_form');
                var el = $(this);
                var image = el.data('image');
                var imageid = el.data('imageid');

                form.find('#user_id').val(el.data('id'));
                form.find('#name').val(el.data('name'));
                form.find('#username').val(el.data('username'));
                form.find('#email').val(el.data('email'));
                form.find('#role option[value='+el.data('role')+']').attr('selected',true);

                if(imageid != ''){
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
            });

            $(document).on('click','.edit_role_modal_btn',function (e){
                e.preventDefault();
                var allData = $(this).data();
                var modalForm = $('#role_edit_modal_form');
                modalForm.find('input[name="id"]').val(allData.id);
                modalForm.find('input[name="name"]').val(allData.name);
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
