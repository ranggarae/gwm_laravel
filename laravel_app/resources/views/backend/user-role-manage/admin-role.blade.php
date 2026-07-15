@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
@endsection
@section('site-title')
    {{__('All Admin Role')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                @include('backend/partials/message')
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Admin Role')}}</h4>
                        <div class="data-tables datatable-primary">
                            <table id="all_user_table" class="table table-default">
                                <thead class="text-capitalize">
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Role')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_role as $data)
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
                                                <a data-toggle="modal" data-target="#user_edit_modal" data-id="{{$data->id}}" data-name="{{$data->name}}" class="btn btn-primary btn-sm edit_role_modal_btn">
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
                </div>
            </div>
            <div class="col-lg-6  mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Admin Role')}}</h4>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('admin.all.user.role')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('Role Name')}}</label>
                                <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Enter Role name')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Role')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Admin Role Edit')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.user.role.update')}}" id="user_edit_modal_form" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        @csrf
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
@endsection
@section('script')
    <script>
        (function ($){
            "use strict";

           $(document).ready(function (){

               $(document).on('click','.edit_role_modal_btn',function (e){
                   e.preventDefault();

                   var allData = $(this).data();
                   var modalForm = $('#user_edit_modal_form');
                   modalForm.find('input[name="id"]').val(allData.id);
                   modalForm.find('input[name="name"]').val(allData.name);
               });

           });

        })(jQuery)
    </script>
@endsection
