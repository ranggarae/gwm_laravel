@extends('backend.admin-master')
@section('site-title')
    {{__('Gig Page Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Gig Page Settings")}}</h4>
                        <form action="{{route('admin.gigs.page.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="gig_page_items">{{__('Order Button Title')}}</label>
                                <input type="number" name="gig_page_items"  class="form-control" value="{{get_static_option('gig_page_items')}}" >
                            </div>
                            <div class="form-group">
                                <label for="gig_page_notify_email">{{__('Gig Notify Email')}}</label>
                                <input type="text" name="gig_page_notify_email"  class="form-control" value="{{get_static_option('gig_page_notify_email')}}" >
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
