@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Apply To').' '}}{{$job->title}}
@endsection
@section('page-title')
    {{__('Apply To').' '}}{{$job->title}}
@endsection
@section('content')
    <section class="blog-content-area padding-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="job-apply-form-wrapper">
                        @include('backend.partials.message')
                        @if($errors->any())
                            <ul class="alert alert-danger">
                            @foreach($errors->all() as $message)
                                <li>{{$message}}</li>
                            @endforeach
                            </ul>
                        @endif
                        <form action="{{route('frontend.jobs.apply.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="job_id" value="{{$job->id}}">
                             <input type="hidden" name="captcha_token" id="gcaptcha_token">
                            {!! render_form_field_for_frontend(get_static_option('apply_job_page_form_fields')) !!}
                            <div class="btn-wrapper text-center">
                                <button class="boxed-btn style-01" type="submit">{{__('Apply')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
