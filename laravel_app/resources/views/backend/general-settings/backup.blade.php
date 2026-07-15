@extends('backend.admin-master')
@section('site-title')
    {{__('Database Backup Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Database Backup Settings")}}</h4>
                        <form action="{{route('admin.general.backup.settings')}}" method="Post">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 margin-bottom-40" id="db_backup_btn">{{__('Create Database Backup')}}</button>
                        </form>
                        <table class="table table-default">
                            <thead>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Date')}}</th>
                            <th>{{__('Size')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_backuped_db as $data)
                                <tr>
                                    <td>{{basename($data)}}</td>
                                    <td>{{date('j F Y - h:m:s',filectime($data)) }}</td>
                                    <td>@if(trim(formatBytes(filesize($data))) === 'NAN') {{__('0 Byte')}} @else {{formatBytes(filesize($data))}} @endif</td>
                                    <td>
                                        <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                           role="button"
                                           data-toggle="popover"
                                           data-trigger="focus"
                                           data-html="true"
                                           title=""
                                           data-content="
                                               <h6>Are you sure to delete this database ?</h6>
                                               <form method='post' action='{{route("admin.general.backup.settings.delete")}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <input type='hidden' name='db_name' value='{{$data}}'>
                                               <br>
                                                <input type='submit' class='btn btn-danger btn-sm' value='Yes,Delete'>
                                                </form>
                                                ">
                                            <i class="ti-trash"></i>
                                        </a>
                                        <a href="#"
                                           role="button"
                                           data-toggle="popover"
                                           data-trigger="focus"
                                           data-html="true"
                                           class='btn btn-info btn-sm mb-3 mr-1'
                                           title=""
                                           data-content="
                                               <h6>Are you sure to restore this database ?</h6>
                                               <form method='post' action='{{route("admin.general.backup.settings.restore")}}'>
                                               <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                               <input type='hidden' name='db_name' value='{{basename($data)}}'>
                                               <br>
                                                <input type='submit' class='btn btn-warning btn-sm' value='Yes,Restore'>
                                                </form>
                                                ">
                                            <i class="fa fa-upload"></i> {{__('Restore Backup')}}
                                        </a>
                                        <a href="{{asset('backup')}}/{{basename($data)}}" download class="btn btn-primary btn-sm mb-3 mr-1"> <i class="fa fa-download"></i> </a>
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
@endsection
@section('script')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){

            });
        }(jQuery));
    </script>
@endsection
