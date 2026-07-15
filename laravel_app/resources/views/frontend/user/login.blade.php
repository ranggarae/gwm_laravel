@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Login')}}
@endsection
@section('content')
<section class="login-page-wrapper padding-bottom-120 padding-top-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-form-wrapper">
                    <h2>{{__('Login To Your Account')}}</h2>
                    @include('backend.partials.message')
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('user.login')}}" method="post" enctype="multipart/form-data" class="account-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="{{__('Username')}}">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                        </div>
                        <div class="form-group btn-wrapper">
                            <button type="submit" class="submit-btn">{{__('Login')}}</button>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                    <label class="custom-control-label" for="remember">{{__('Remember Me')}}</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{route('user.register')}}">{{__('Haven\'t any account?')}}</a>
                                <a href="{{route('user.forget.password')}}">{{__('Forgot Password?')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
