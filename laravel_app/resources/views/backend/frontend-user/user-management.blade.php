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
    {{__('User Management')}}
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('User Management')}}</h4>
                        
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

                        <ul class="nav nav-tabs" id="userManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-users-tab" data-toggle="tab" href="#all-users" role="tab" aria-controls="all-users" aria-selected="true">{{__('All Users')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-tab" data-toggle="tab" href="#add-new" role="tab" aria-controls="add-new" aria-selected="false">{{__('Add New User')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="userManagementTabContent">
                            <!-- TAB 1: ALL USERS -->
                            <div class="tab-pane fade show active" id="all-users" role="tabpanel" aria-labelledby="all-users-tab">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-flex align-items-center">
                                        <select name="bulk_option" id="bulk_option" class="form-control w-auto mr-2">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="data-tables datatable-primary">
                                    <table id="all_user_table" class="table text-center">
                                        <thead class="text-capitalize">
                                        <tr>
                                            <th class="no-sort">
                                                <div class="mark-all-checkbox">
                                                    <input type="checkbox" class="all-checkbox">
                                                </div>
                                            </th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Username')}}</th>
                                            <th>{{__('Account Type')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_user as $data)
                                            <tr>
                                                <td>
                                                    <div class="bulk-checkbox-wrapper">
                                                        <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                    </div>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->email}}</td>
                                                <td>{{$data->username}}</td>
                                                <td>{{ucfirst($data->account_type ?? 'perorangan')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                   <h6>{{__('Are you sure to delete this user?')}}</h6>
                                                   <form method='post' action='{{route('admin.frontend.delete.user',$data->id)}}'>
                                                   <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                   <br>
                                                    <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    " data-original-title="">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                    <a href="#"
                                                       data-id="{{$data->id}}"
                                                       data-username="{{$data->username}}"
                                                       data-name="{{$data->name}}"
                                                       data-email="{{$data->email}}"
                                                       data-phone="{{$data->phone}}"
                                                       data-address="{{$data->address}}"
                                                       data-state="{{$data->state}}"
                                                       data-city="{{$data->city}}"
                                                       data-zipcode="{{$data->zipcode}}"
                                                       data-country="{{$data->country}}"
                                                       data-email_verified="{{$data->email_verified}}"
                                                       
                                                       data-account_type="{{$data->account_type}}"
                                                       data-nik="{{$data->nik}}"
                                                       data-company_name="{{$data->company_name}}"
                                                       data-company_npwp="{{$data->company_npwp}}"
                                                       data-company_nib="{{$data->company_nib}}"
                                                       data-ktp_image="{{$data->ktp_image ? asset($data->ktp_image) : ''}}"
                                                       data-selfie_image="{{$data->selfie_image ? asset($data->selfie_image) : ''}}"
                                                       data-sim_image="{{$data->sim_image ? asset($data->sim_image) : ''}}"

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

                            <!-- TAB 2: ADD NEW USER -->
                            <div class="tab-pane fade" id="add-new" role="tabpanel" aria-labelledby="add-new-tab">
                                <form action="{{route('admin.frontend.new.user')}}" method="post" enctype="multipart/form-data">
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
                                            <div class="form-group">
                                                <label for="phone">{{__('Phone')}}</label>
                                                <input type="text" class="form-control"  id="phone" name="phone" placeholder="{{__('Phone')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">{{__('Password')}}</label>
                                                <input type="password" class="form-control"  id="password" name="password" placeholder="{{__('Password')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">{{__('Password Confirm')}}</label>
                                                <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" placeholder="{{__('Password Confirmation')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country">{{__('Country')}}</label>
                                                {!! get_country_field('country','country','form-control') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="state">{{__('State')}}</label>
                                                <input type="text" class="form-control"  id="state" name="state" placeholder="{{__('State')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="city">{{__('City')}}</label>
                                                <input type="text" class="form-control"  id="city" name="city" placeholder="{{__('City')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="zipcode">{{__('Zipcode')}}</label>
                                                <input type="text" class="form-control"  id="zipcode" name="zipcode" placeholder="{{__('Zipcode')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="address">{{__('Address')}}</label>
                                                <input type="text" class="form-control"  id="address" name="address" placeholder="{{__('Address')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New User')}}</button>
                                </form>
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
                <form action="{{route('admin.frontend.user.update')}}" id="user_edit_modal_form" method="post" enctype="multipart/form-data">
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
                            <label for="phone">{{__('Phone')}}</label>
                            <input type="text" class="form-control"  id="phone" name="phone" placeholder="{{__('Phone')}}">
                        </div>
                        <div class="form-group">
                            <label for="country">{{__('Country')}}</label>
                            {!! get_country_field('country','country','form-control') !!}
                        </div>
                        <div class="form-group">
                            <label for="state">{{__('State')}}</label>
                            <input type="text" class="form-control"  id="state" name="state" placeholder="{{__('State')}}">
                        </div>
                        <div class="form-group">
                            <label for="city">{{__('City')}}</label>
                            <input type="text" class="form-control"  id="city" name="city" placeholder="{{__('City')}}">
                        </div>
                        <div class="form-group">
                            <label for="zipcode">{{__('Zipcode')}}</label>
                            <input type="text" class="form-control"  id="zipcode" name="zipcode" placeholder="{{__('Zipcode')}}">
                        </div>
                        <div class="form-group">
                            <label for="address">{{__('Address')}}</label>
                            <input type="text" class="form-control"  id="address" name="address" placeholder="{{__('Address')}}">
                        </div>

                        <!-- Custom Fields Display (Readonly for now) -->
                        <div id="custom_fields_display">
                            <hr>
                            <h5 class="mb-3">{{__('Data Registrasi Khusus')}}</h5>
                            <div class="form-group">
                                <label>{{__('Tipe Akun')}}</label>
                                <input type="text" class="form-control" id="disp_account_type" readonly>
                            </div>
                            <div id="disp_perorangan_area" style="display:none;">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" id="disp_nik" readonly>
                                </div>
                                <div class="form-group">
                                    <a href="#" id="link_ktp_image" target="_blank" class="btn btn-sm btn-info">{{__('Lihat KTP')}}</a>
                                    <a href="#" id="link_selfie_image" target="_blank" class="btn btn-sm btn-info">{{__('Lihat Selfie')}}</a>
                                    <a href="#" id="link_sim_image" target="_blank" class="btn btn-sm btn-info">{{__('Lihat SIM')}}</a>
                                </div>
                            </div>
                            <div id="disp_perusahaan_area" style="display:none;">
                                <div class="form-group">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="disp_company_name" readonly>
                                </div>
                                <div class="form-group">
                                    <label>NPWP Perusahaan</label>
                                    <input type="text" class="form-control" id="disp_company_npwp" readonly>
                                </div>
                                <div class="form-group">
                                    <label>NIB Perusahaan</label>
                                    <input type="text" class="form-control" id="disp_company_nib" readonly>
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
                <form action="{{route('admin.frontend.user.password.change')}}" id="user_password_change_modal_form" method="post" enctype="multipart/form-data">
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
                localStorage.setItem('activeUserTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeUserTab');
            if(activeTab){
                $('#userManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            $(document).on('click','.user_change_password_btn',function(e){
                e.preventDefault();
                $('#user_password_change_modal_form').find('#ch_user_id').val($(this).data('id'));
            });

            $('#all_user_table').DataTable( {
                "order": [[ 1, "desc" ]],
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ]
            } );

            $(document).on('click','#bulk_delete_btn',function (e) {
                e.preventDefault();
                var bulkOption = $('#bulk_option').val();
                var allCheckbox =  $('.bulk-checkbox:checked');
                var allIds = [];
                allCheckbox.each(function(index,value){
                    allIds.push($(this).val());
                });
                if(allIds != ''){
                    $(this).text('Please Wait...');
                    $.ajax({
                        'type' : "POST",
                        'url' : "{{route('admin.frontend.bulk.action')}}",
                        'data' : {
                            _token: "{{csrf_token()}}",
                            ids: allIds,
                            type: bulkOption
                        },
                        success:function (data) {
                            location.reload();
                        }
                    });
                }
            });

            $('.all-checkbox').on('change',function (e) {
                e.preventDefault();
                var value = $('.all-checkbox').is(':checked');
                var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
                if( value == true){
                    allChek.prop('checked',true);
                }else{
                    allChek.prop('checked',false);
                }
            });

            $(document).on('click','.user_edit_btn',function(e){
                e.preventDefault();
                var form = $('#user_edit_modal_form');
                var el = $(this);

                form.find('#user_id').val(el.data('id'));
                form.find('#name').val(el.data('name'));
                form.find('#username').val(el.data('username'));
                form.find('#email').val(el.data('email'));
                form.find('#phone').val(el.data('phone'));
                form.find('#state').val(el.data('state'));
                form.find('#city').val(el.data('city'));
                form.find('#zipcode').val(el.data('zipcode'));
                form.find('#address').val(el.data('address'));
                form.find('#country option[value="'+el.data('country')+'"]').attr('selected',true);

                // Custom Data
                var accType = el.data('account_type');
                if(!accType) accType = 'perorangan';
                form.find('#disp_account_type').val(accType.toUpperCase());
                
                if (accType === 'perorangan') {
                    form.find('#disp_perorangan_area').show();
                    form.find('#disp_perusahaan_area').hide();
                    form.find('#disp_nik').val(el.data('nik'));
                    
                    if(el.data('ktp_image')) {
                        form.find('#link_ktp_image').show().attr('href', el.data('ktp_image'));
                    } else {
                        form.find('#link_ktp_image').hide();
                    }
                    if(el.data('selfie_image')) {
                        form.find('#link_selfie_image').show().attr('href', el.data('selfie_image'));
                    } else {
                        form.find('#link_selfie_image').hide();
                    }
                    if(el.data('sim_image')) {
                        form.find('#link_sim_image').show().attr('href', el.data('sim_image'));
                    } else {
                        form.find('#link_sim_image').hide();
                    }
                } else {
                    form.find('#disp_perorangan_area').hide();
                    form.find('#disp_perusahaan_area').show();
                    form.find('#disp_company_name').val(el.data('company_name'));
                    form.find('#disp_company_npwp').val(el.data('company_npwp'));
                    form.find('#disp_company_nib').val(el.data('company_nib'));
                }
            });
        });
    </script>
@endsection
