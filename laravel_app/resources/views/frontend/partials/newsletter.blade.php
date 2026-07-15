<div class="newsletter-area padding-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-side-content">
                    <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_newsletter_area_title')}}</h2>
                    <p>{{get_static_option('home_page_01_'.get_user_lang().'_newsletter_area_description')}}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="right-side-content">
                    @include('backend.partials.message')
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p class="text-danger">{{$error}}</p>
                        @endforeach
                    @endif
                    <form action="{{route('frontend.subscribe.newsletter')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" placeholder="{{__('Enter your email')}}" class="form-control">
                        </div>
                        <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>