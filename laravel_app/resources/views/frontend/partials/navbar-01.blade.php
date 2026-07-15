<style>
.navbar-area.nav-style-01, .navbar-area.nav-style-01 .nav-container {
    background-color: #ffffff !important;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
}
.navbar-area.nav-style-01 .nav-container .navbar-brand {
    margin-right: auto;
}
.navbar-area.nav-style-01 .nav-container .navbar-collapse {
    flex-grow: 1;
}
.navbar-area.nav-style-01 .nav-container .navbar-collapse .navbar-nav li a {
    color: #333333 !important;
    font-weight: 600;
}
.navbar-area.nav-style-01 .nav-container .navbar-collapse .navbar-nav li:hover a {
    color: var(--main-color-one) !important;
}
.navbar-area.nav-style-01 .nav-container .navbar-collapse .navbar-nav li.menu-item-has-children:before {
    color: #333333 !important;
}
.navbar-area.nav-style-01 .nav-container .navbar-collapse .navbar-nav li:hover.menu-item-has-children:before {
    color: var(--main-color-one) !important;
}
</style>

<nav class="navbar navbar-area navbar-expand-lg nav-style-01">
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
    </div>
</nav>