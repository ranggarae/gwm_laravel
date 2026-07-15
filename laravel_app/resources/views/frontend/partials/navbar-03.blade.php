<style>
.navbar-area.nav-style-02, .navbar-area.nav-style-02 .nav-container {
    background-color: #ffffff !important;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
}
.navbar-area.nav-style-02 .nav-container .navbar-brand {
    margin-right: auto;
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse {
    flex-grow: 1;
}
.navbar-area.nav-style-02 .nav-container .navbar-collapse .navbar-nav li a {
    color: #333333 !important;
    font-weight: 600;
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
<div class="header-style-04">
    <nav class="navbar navbar-area navbar-expand-lg nav-style-02">
        <div class="container nav-container">
            <div class="navbar-brand">
                <a href="{{url('/')}}" class="logo">
                    {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bizcoxx_main_menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bizcoxx_main_menu" style="margin-left: auto !important; flex-grow: 0 !important;">
                <ul class="navbar-nav ml-auto w-100 justify-content-end" style="justify-content: flex-end !important;">
                    {!! render_menu_by_id($primary_menu_id) !!}
                </ul>
            </div>
            <div class="nav-right-content">
                @if(!empty(get_static_option('hide_frontend_language_change_option')))
                    <div class="language_dropdown" id="languages_selector">
                        <div class="selected-language">{{get_language_name_by_slug(get_user_lang())}} <i class="fas fa-caret-down"></i></div>
                        <ul>
                            @foreach($all_language as $lang)
                                <li data-value="{{$lang->slug}}">{{$lang->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    <!-- navbar area end -->
</div>