@extends('backend.admin-master')
@section('site-title')
    {{__('Permalink Flush Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Permalink Flush Settings")}}</h4>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                             @endforeach
                        @endif
                        <form action="{{route('admin.general.permalink.flush')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Permalink Flush')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
