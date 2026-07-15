@extends('backend.admin-master')
@section('site-title')
    {{__('General Settings')}}
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
                        <h4 class="header-title">{{__('General Settings')}}</h4>
                        <form action="{{route('admin.footer.general')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="img-wrapper" style="margin: 20px">
                                @if(file_exists('assets/uploads/'.get_static_option('footer_background_image')))
                                    <img style="max-width: 200px" src="{{asset('assets/uploads/'.get_static_option('footer_background_image'))}}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="footer_background_image">{{__('Background Image')}}</label>
                                <input type="file" class="form-control"  id="footer_background_image"  name="footer_background_image" >
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
