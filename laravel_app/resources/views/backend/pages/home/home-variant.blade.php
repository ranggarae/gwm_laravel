@extends('backend.admin-master')
@section('site-title')
    {{__('Home Variant Settings')}}
@endsection
@section('style')
<style>
    .img-select {
        cursor: pointer;
        border: 3px solid transparent;
        border-radius: var(--radius-md);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }
    .img-select.selected {
        border-color: var(--color-blue);
        box-shadow: 0 0 15px rgba(43, 125, 233, 0.4);
    }
    .img-select .variant-label {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(26, 39, 68, 0.9);
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: 600;
        font-size: 14px;
    }
    .variant-placeholder {
        width: 100%;
        height: 250px;
        background: var(--color-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-navy);
        font-size: 40px;
        font-weight: bold;
    }
</style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Home Variant')}}</h4>
                       <div class="alert alert-warning text-capitalize"> {{__('Select which homepage layout to display on your main site.')}}</div>
                        <form action="{{route('admin.home.variant')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control"  id="home_page_variant" value="{{get_static_option('home_page_variant')}}" name="home_page_variant">
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="img-select">
                                        <div class="img-wrap position-relative">
                                            <div class="variant-placeholder" data-home_id="gwm-corporate">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="variant-label">GWM Corporate Modern</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="img-select">
                                        <div class="img-wrap position-relative">
                                            <div class="variant-placeholder" data-home_id="gwm-industrial">
                                                <i class="fas fa-industry"></i>
                                            </div>
                                            <div class="variant-label">GWM Industrial Bold</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="img-select">
                                        <div class="img-wrap position-relative">
                                            <div class="variant-placeholder" data-home_id="gwm-minimalist">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                            <div class="variant-label">GWM Minimalist</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="img-select">
                                        <div class="img-wrap position-relative">
                                            <img src="{{asset('assets/frontend/home-variant/home-01.jpg')}}" data-home_id="01" alt="" style="width:100%;">
                                            <div class="variant-label">Legacy Theme (01)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Home Variant')}}</button>
                        </form>
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

            $(document).ready(function () {

                var imgSelect = $('.img-select');
                var id = $('#home_page_variant').val();
                imgSelect.removeClass('selected');
                
                // Select active item
                $('[data-home_id="'+id+'"]').closest('.img-select').addClass('selected');
                
                $(document).on('click','.img-select',function (e) {
                    e.preventDefault();
                    imgSelect.removeClass('selected');
                    $(this).addClass('selected');
                    
                    var home_id = $(this).find('[data-home_id]').data('home_id');
                    $('#home_page_variant').val(home_id);
                });
            })

        })(jQuery);
    </script>
@endsection