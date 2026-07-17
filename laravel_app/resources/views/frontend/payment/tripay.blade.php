@extends('frontend.frontend-page-master')

@section('page-title')
    {{__('Tripay Payment Gateway')}}
@endsection

@section('content')
    <div class="checkout-page-content-area padding-top-120 padding-bottom-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-wrap">
                        <h4 class="title margin-bottom-30">{{__('Select Payment Method')}}</h4>
                        
                        @include('backend.partials.message')
                        
                        <form action="{{route('tripay.process')}}" method="POST">
                            @csrf
                            
                            <div class="row">
                                @if(isset($channels) && count($channels) > 0)
                                    @foreach($channels as $channel)
                                        @if($channel['active'])
                                            <div class="col-md-6 margin-bottom-20">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="method" id="method_{{$channel['code']}}" value="{{$channel['code']}}" required>
                                                            <label class="form-check-label w-100" for="method_{{$channel['code']}}">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="mr-3">
                                                                        <img src="{{$channel['icon_url']}}" alt="{{$channel['name']}}" style="max-height: 30px;">
                                                                    </div>
                                                                    <div>
                                                                        <strong>{{$channel['name']}}</strong><br>
                                                                        <small class="text-muted">Fee: Rp {{number_format($channel['total_fee']['flat'] ?? 0, 0, ',', '.')}}</small>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            {{__('No payment channels available at the moment. Please contact support.')}}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="btn-wrapper mt-4">
                                <a href="{{url('/')}}" class="boxed-btn btn-secondary">{{__('Cancel')}}</a>
                                <button type="submit" class="boxed-btn">{{__('Proceed to Payment')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
