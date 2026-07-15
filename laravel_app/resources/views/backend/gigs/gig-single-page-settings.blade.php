@extends('backend.admin-master')
@section('site-title')
    {{__('Gig Single Page Settings')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                @include('backend.partials.message')
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__("Gig Single Page Settings")}}</h4>
                        <form action="{{route('admin.gigs.single.page.settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                        <a class="nav-item nav-link @if($key == 0) active @endif" id="nav-home-tab" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-controls="nav-home" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group">
                                            <label for="gig_single_{{$lang->slug}}_order_button_title">{{__('Order Button Title')}}</label>
                                            <input type="text" name="gig_single_{{$lang->slug}}_order_button_title"  class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_order_button_title')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_single_{{$lang->slug}}_quote_title">{{__('Quote Title')}}</label>
                                            <input type="text" name="gig_single_{{$lang->slug}}_quote_title"  class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_quote_title')}}" >
                                        </div>
                                        <div class="form-group">
                                            <label for="gig_single_{{$lang->slug}}_quote_button_title">{{__('Quote Button Title')}}</label>
                                            <input type="text" name="gig_single_{{$lang->slug}}_quote_button_title"  class="form-control" value="{{get_static_option('gig_single_'.$lang->slug.'_quote_button_title')}}" >
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
