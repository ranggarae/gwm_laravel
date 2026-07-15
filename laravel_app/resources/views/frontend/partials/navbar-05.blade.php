<div class="header-style-06">
    <nav class="navbar navbar-area navbar-expand-lg nav-style-service-home home-variant-{{get_static_option('home_page_variant')}}">
        <div class="container nav-container">
            <div class="responsive-mobile-menu">
                <div class="logo-wrapper">
                    <a href="{{url('/')}}" class="logo">
                        {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bizcoxx_main_menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bizcoxx_main_menu">
                <ul class="navbar-nav">
                    {!! render_menu_by_id($primary_menu_id) !!}
                </ul>
                <div class="nav-right-content">
                    <ul>
                        <li class="btn-wrapper" >
                            @php $quote_btn_url = !empty(get_static_option('navbar_button_custom_url_status')) ? get_static_option('navbar_button_custom_url') : route('frontend.request.quote'); @endphp
                            <a href="{{$quote_btn_url}}" class="boxed-btn">{{get_static_option('navbar_'.$user_select_lang_slug.'_button_text')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>