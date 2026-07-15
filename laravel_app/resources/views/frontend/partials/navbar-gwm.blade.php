<nav class="navbar navbar-expand-lg gwm-navbar gwm-navbar-transparent-start fixed-top">
    <div class="container nav-container">
        <!-- Logo -->
        <a href="{{url('/')}}" class="navbar-brand logo">
            {!! render_image_markup_by_attachment_id(get_static_option('site_logo'), 'full') !!}
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#gwm_main_menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fas fa-bars"></i>
            </span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="gwm_main_menu">
            <ul class="navbar-nav ml-auto">
                {!! render_menu_by_id($primary_menu_id) !!}
            </ul>

            <!-- CTA Button -->
            @if(!empty(get_static_option('navbar_button')))
                <div class="nav-right-content ml-lg-4 mt-3 mt-lg-0">
                    @php $quote_btn_url = !empty(get_static_option('navbar_button_custom_url_status')) ? get_static_option('navbar_button_custom_url') : route('frontend.request.quote'); @endphp
                    <a href="{{$quote_btn_url}}" class="gwm-btn gwm-btn-primary gwm-hover-lift">
                        {{get_static_option('navbar_'.get_user_lang().'_button_text')}}
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>

<style>
/* Scoped Navbar Styles */
.gwm-navbar {
    padding: 15px 0;
    z-index: 1030; /* Ensure it stays above other elements */
}

/* Base Nav Link Styles */
.gwm-navbar .navbar-nav li a {
    color: #ffffff; /* Default transparent state color */
    font-family: var(--font-heading);
    font-weight: 600;
    padding: 10px 15px;
    position: relative;
    transition: color var(--transition-fast);
}

.gwm-navbar .navbar-nav li:hover a {
    color: var(--color-silver);
}

/* Solid state overrides */
.gwm-navbar-solid .navbar-nav li a {
    color: var(--color-silver);
}

.gwm-navbar-solid .navbar-nav li:hover > a {
    color: #ffffff;
}

/* Multi-level menu support (Dropdowns) */
.gwm-navbar .navbar-nav li.menu-item-has-children {
    position: relative;
}

.gwm-navbar .navbar-nav li.menu-item-has-children:after {
    content: ""; 
    position: absolute;
    right: 2px;
    top: 50%;
    transform: translateY(-20%);
    width: 0;
    height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid currentColor;
    pointer-events: none;
}

/* Dropdown Menu Styling */
.gwm-navbar .navbar-nav li .sub-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 200px;
    background-color: var(--color-navy);
    box-shadow: var(--shadow-lg);
    border-radius: var(--radius-sm);
    padding: 10px 0;
    margin: 0;
    list-style: none;
    z-index: 99;
    border-top: 3px solid var(--color-blue);
}

.gwm-navbar .navbar-nav li:hover > .sub-menu {
    display: block;
    animation: slideUp 0.3s ease forwards;
}

.gwm-navbar .navbar-nav li .sub-menu li {
    display: block;
}

.gwm-navbar .navbar-nav li .sub-menu li a {
    color: var(--color-silver) !important;
    padding: 8px 20px;
    display: block;
    font-weight: 500;
}

.gwm-navbar .navbar-nav li .sub-menu li:hover > a {
    background-color: rgba(255,255,255,0.05);
    color: #ffffff !important;
    padding-left: 25px; /* Slight indent on hover */
}

/* Animated Underline for primary nav items */
.gwm-navbar .navbar-nav > li > a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 5px;
    left: 15px; /* match padding */
    background-color: var(--color-blue);
    transition: width var(--transition-normal);
}

.gwm-navbar .navbar-nav > li:hover > a::after,
.gwm-navbar .navbar-nav > li.current-menu-item > a::after {
    width: calc(100% - 30px); /* 100% minus padding */
}

/* Mobile Toggle Icon */
.gwm-navbar .navbar-toggler {
    border: none;
    outline: none;
    color: #ffffff;
    font-size: 1.5rem;
    padding: 0.25rem 0.75rem;
}

/* Mobile view adjustments */
@media (max-width: 991px) {
    .gwm-navbar {
        background-color: var(--color-navy) !important; /* Always solid on mobile */
        padding: 10px 0 !important;
    }
    
    .gwm-navbar .navbar-collapse {
        background-color: var(--color-navy);
        padding: 20px;
        border-radius: var(--radius-md);
        margin-top: 10px;
        box-shadow: var(--shadow-md);
    }
    
    .gwm-navbar .navbar-nav > li > a {
        padding: 10px 0;
    }
    
    .gwm-navbar .navbar-nav > li > a::after {
        left: 0;
    }
    
    .gwm-navbar .navbar-nav li.menu-item-has-children:after {
        right: 15px;
    }

    .gwm-navbar .navbar-nav li .sub-menu {
        position: static;
        box-shadow: none;
        background-color: rgba(0,0,0,0.1);
        padding-left: 15px;
        border-top: none;
        border-left: 2px solid var(--color-blue);
        margin-left: 10px;
    }
}
</style>
