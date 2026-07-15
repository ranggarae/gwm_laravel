<style>
.navbar-area.nav-style-02, .navbar-area.nav-style-02 .nav-container {
    background-color: #ffffff !important;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse .navbar-nav li a {
    color: #333333 !important;
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse .navbar-nav li:hover a {
    color: var(--main-color-one) !important;
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse .navbar-nav li.menu-item-has-children:before {
    color: #333333 !important;
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse .navbar-nav li:hover.menu-item-has-children:before {
    color: var(--main-color-one) !important;
}
.navbar-area.nav-style-02 .nav-container .nav-right-content ul li {
    color: #333333 !important;
}
</style>
<div class="header-top-style-03">
    <nav class="navbar navbar-area navbar-expand-lg nav-style-02">
        <div class="container nav-container">
            <div class="navbar-brand">
                <a href="{{url('/')}}" class="logo">
                    {!! render_image_markup_by_attachment_id(get_static_option('site_logo'),'full') !!}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bizcoxx_main_menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bizcoxx_main_menu">
                <ul class="navbar-nav">
                    {!! render_menu_by_id($primary_menu_id) !!}
                </ul>
            </div>
            @if(!empty(get_static_option('navbar_button')))
                <div class="nav-right-content">
                    @php $quote_btn_url = !empty(get_static_option('navbar_button_custom_url_status')) ? get_static_option('navbar_button_custom_url') : route('frontend.request.quote'); @endphp
                    <a href="{{$quote_btn_url}}" class="get-quote">{{get_static_option('navbar_'.get_user_lang().'_button_text')}}</a>
                </div>
            @endif
        </div>
    </nav>
</div>
