<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{route('admin.home')}}">
                @php
                    $logo_type = 'site_logo';
                        if(!empty(get_static_option('site_admin_dark_mode'))){
                            $logo_type = 'site_white_logo';
                        }
                @endphp
                {!! render_image_markup_by_attachment_id(get_static_option($logo_type)) !!}
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="main_dropdown {{active_menu('admin-home')}}">
                        <a href="{{route('admin.home')}}" aria-expanded="true">
                            <i class="fas fa-chart-pie"></i>
                            <span>{{__('Dashboard')}}</span>
                        </a>
                    </li>
                    @php
                        $icon_mapping = [
                            'admin_role_manage' => 'fas fa-user-shield',
                            'user_manage' => 'fas fa-users',
                            'widgets_manage' => 'fas fa-puzzle-piece',
                            'menus_manage' => 'fas fa-bars',
                            'form_builder' => 'fas fa-keyboard',
                            'newsletter_manage' => 'fas fa-envelope',
                            'quote_manage' => 'fas fa-file-invoice',
                            'package_order_manage' => 'fas fa-box-open',
                            'pages_manage' => 'fas fa-file-alt',
                            'gallery_manage' => 'fas fa-images',
                            'about_page_manage' => 'fas fa-address-card',
                            'contact_page_manage' => 'fas fa-address-book',
                            '404_page_manage' => 'fas fa-exclamation-triangle',
                            'faq' => 'fas fa-question-circle',
                            'brand_logos' => 'fas fa-gem',
                            'price_plan' => 'fas fa-tags',
                            'testimonial' => 'fas fa-star',
                            'team_members' => 'fas fa-user-tie',
                            'counterup' => 'fas fa-sort-numeric-up',
                            'site_maintenance_mode' => 'fas fa-tools',
                            'popup_builder' => 'fas fa-window-restore',
                            'feedback_page_manage' => 'fas fa-comment-dots',
                            'home_page_manage' => 'fas fa-home',
                            'home_variant' => 'fas fa-columns',
                            'navbar_settings' => 'fas fa-window-maximize',
                            'top_bar_settings' => 'fas fa-grip-lines',
                            'blogs_manage' => 'fas fa-blog',
                            'job_post_manage' => 'fas fa-briefcase',
                            'events_manage' => 'fas fa-calendar-alt',
                            'products_manage' => 'fas fa-shopping-cart',
                            'donations_manage' => 'fas fa-hand-holding-heart',
                            'knowledgebase_manage' => 'fas fa-book',
                            'services' => 'fas fa-concierge-bell',
                            'works' => 'fas fa-project-diagram',
                            'gigs_manage' => 'fas fa-laptop-code',
                            'general_settings' => 'fas fa-cogs',
                            'language_manage' => 'fas fa-language',
                            'payment_logs' => 'fas fa-money-check-alt'
                        ];

                        $menu_groups = [
                            'Access & Security' => ['admin_role_manage', 'user_manage'],
                            'CMS Content' => ['pages_manage', 'about_page_manage', 'contact_page_manage', '404_page_manage', 'faq', 'brand_logos', 'price_plan', 'testimonial', 'team_members', 'counterup', 'gallery_manage'],
                            'Appearance & UI' => ['widgets_manage', 'menus_manage', 'navbar_settings', 'top_bar_settings', 'home_variant', 'home_page_manage'],
                            'Modules & Features' => ['blogs_manage', 'job_post_manage', 'events_manage', 'products_manage', 'knowledgebase_manage', 'donations_manage', 'services', 'works', 'gigs_manage'],
                            'Marketing & Leads' => ['form_builder', 'newsletter_manage', 'quote_manage', 'package_order_manage', 'popup_builder', 'feedback_page_manage'],
                            'Settings & System' => ['site_maintenance_mode', 'general_settings', 'language_manage', 'payment_logs']
                        ];
                        
                        $unified_routes = [
                            'admin_role_manage' => 'admin.all.user',
                            'user_manage' => 'admin.all.frontend.user',
                            'pages_manage' => 'admin.page',
                            'about_page_manage' => 'admin.about.page.about',
                            'contact_page_manage' => 'admin.contact.page.form.area',
                            'blogs_manage' => 'admin.blog',
                            'events_manage' => 'admin.events',
                            'products_manage' => 'admin.products',
                            'form_builder' => 'admin.form.builder.management',
                            'newsletter_manage' => 'admin.newsletter.management',
                            'price_plan' => 'admin.price.plan.management',
                            'gallery_manage' => 'admin.gallery.management',
                            'job_post_manage' => 'admin.jobs.management',
                            'knowledgebase_manage' => 'admin.knowledge.management',
                            'donations_manage' => 'admin.donations.management',
                            'services' => 'admin.services.management',
                            'works' => 'admin.works.management',
                            'gigs_manage' => 'admin.gigs.management',
                            'quote_manage' => 'admin.quote.management',
                            'package_order_manage' => 'admin.order.management',
                            'popup_builder' => 'admin.popup.management',
                            'feedback_page_manage' => 'admin.feedback.management'
                        ];
                        
                        $rendered_menus = [];
                    @endphp

                    @foreach($menu_groups as $group_name => $group_items)
                        @php 
                            $has_items_in_group = false; 
                            $group_is_active = false;
                            // Check if this group will actually render anything for the current user
                            foreach($group_items as $check_item) {
                                if(isset($all_menus[$check_item])) {
                                    // Module disabled check
                                    if( get_static_option('job_module_status') != 'on' && $check_item == 'job_post_manage' ) continue;
                                    if(get_static_option('events_module_status') != 'on' && $check_item == 'events_manage') continue;
                                    if(get_static_option('product_module_status') != 'on' && $check_item == 'products_manage') continue;
                                    if(get_static_option('donations_module_status') != 'on' && $check_item == 'donations_manage') continue;
                                    if(get_static_option('knowledgebase_module_status') != 'on' && $check_item == 'knowledgebase_manage') continue;
                                    if(get_static_option('service_module_status') != 'on' && $check_item == 'services') continue;
                                    if(get_static_option('works_module_status') != 'on' && $check_item == 'works') continue;
                                    if(get_static_option('blog_module_status') != 'on' && $check_item == 'blogs_manage') continue;
                                    if(get_static_option('gig_module_status') != 'on' && $check_item == 'gigs_manage') continue;
                                    
                                    $has_items_in_group = true;

                                    // Check active state
                                    $sub = (array)$all_menus[$check_item];
                                    if (isset($unified_routes[$check_item]) && request()->routeIs($unified_routes[$check_item])) {
                                        $group_is_active = true;
                                    } elseif (count($sub) > 1) {
                                        if (in_array(request()->route()->getName(), $sub)) $group_is_active = true;
                                    } else {
                                        $first = current($sub);
                                        if (request()->routeIs($first)) $group_is_active = true;
                                    }
                                }
                            }
                        @endphp

                        @if($has_items_in_group)
                            <li class="menu-category" 
                                style="cursor: pointer; padding: 18px 24px 8px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #737373; font-weight: 600; display:flex; justify-content: space-between; align-items:center; user-select: none;"
                                onclick="$(this).nextUntil('.menu-category').slideToggle(200); $(this).find('i.toggle-icon').toggleClass('fa-chevron-up fa-chevron-down');">
                                <span>{{ __($group_name) }}</span>
                                <i class="fas {{ $group_is_active ? 'fa-chevron-up' : 'fa-chevron-down' }} toggle-icon" style="font-size: 10px; opacity: 0.5;"></i>
                            </li>


                            @foreach($group_items as $main_menu)
                                @if(isset($all_menus[$main_menu]))
                                    @php 
                                        $sub_menu = $all_menus[$main_menu];
                                        $all_sub_menus = (array) $sub_menu; 
                                        $rendered_menus[] = $main_menu;
                                        $icon = $icon_mapping[$main_menu] ?? (count($all_sub_menus) > 1 ? 'fas fa-folder' : 'fas fa-file');
                                    @endphp
                                    
                                    {{-- Module disabled check --}}
                                    @if( get_static_option('job_module_status') != 'on' && $main_menu == 'job_post_manage' ) @continue @endif
                                    @if(get_static_option('events_module_status') != 'on' && $main_menu == 'events_manage') @continue @endif
                                    @if(get_static_option('product_module_status') != 'on' && $main_menu == 'products_manage') @continue @endif
                                    @if(get_static_option('donations_module_status') != 'on' && $main_menu == 'donations_manage') @continue @endif
                                    @if(get_static_option('knowledgebase_module_status') != 'on' && $main_menu == 'knowledgebase_manage') @continue @endif
                                    @if(get_static_option('service_module_status') != 'on' && $main_menu == 'services') @continue @endif
                                    @if(get_static_option('works_module_status') != 'on' && $main_menu == 'works') @continue @endif
                                    @if(get_static_option('blog_module_status') != 'on' && $main_menu == 'blogs_manage') @continue @endif
                                    @if(get_static_option('gig_module_status') != 'on' && $main_menu == 'gigs_manage') @continue @endif

                                    @if(isset($unified_routes[$main_menu]))
                                        <li class="main_dropdown @if(in_array(request()->route()->getName(),$all_sub_menus) || request()->routeIs($unified_routes[$main_menu])) active @endif" style="{{ $group_is_active ? '' : 'display: none;' }}">
                                            <a href="{{route($unified_routes[$main_menu])}}" aria-expanded="true">
                                                <i class="{{ $icon }}"></i>
                                                <span>{{__(str_replace('_',' ',$main_menu))}}</span>
                                            </a>
                                        </li>
                                    @elseif(count($all_sub_menus) > 1)
                                        <li class="main_dropdown @if(in_array(request()->route()->getName(),$all_sub_menus)) active @endif" style="{{ $group_is_active ? '' : 'display: none;' }}">
                                            <a href="javascript:void(0)" aria-expanded="true">
                                                <i class="{{ $icon }}"></i>
                                                <span>{{__(str_replace('_',' ',$main_menu))}}</span>
                                            </a>
                                            <ul class="collapse">
                                                @foreach($sub_menu as $item_name => $route_name)
                                                <li class="@if(request()->routeIs($route_name)) active @endif">
                                                    <a href="{{route($route_name)}}">{{__(str_replace('_',' ',substr($item_name,1,-1)))}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        @php $firstProp = current( (Array) $sub_menu ); @endphp
                                        <li class="main_dropdown @if(request()->routeIs($firstProp)) active @endif" style="{{ $group_is_active ? '' : 'display: none;' }}">
                                            <a href="{{route($firstProp)}}" aria-expanded="true">
                                                <i class="{{ $icon }}"></i>
                                                <span>{{__(str_replace('_',' ',$main_menu))}}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Render any remaining items that were not categorized --}}
                    @php 
                        $has_others = false; 
                        $other_is_active = false;
                        foreach($all_menus as $main_menu => $sub_menu) {
                            if(!in_array($main_menu, $rendered_menus)) {
                                $sub = (array)$sub_menu;
                                if (count($sub) > 1) {
                                    if (in_array(request()->route()->getName(), $sub)) $other_is_active = true;
                                } else {
                                    $first = current($sub);
                                    if (request()->routeIs($first)) $other_is_active = true;
                                }
                            }
                        }
                    @endphp
                    @foreach($all_menus as $main_menu => $sub_menu)
                        @if(!in_array($main_menu, $rendered_menus))
                            @if(!$has_others)
                                <li class="menu-category" 
                                    style="cursor: pointer; padding: 18px 24px 8px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #737373; font-weight: 600; display:flex; justify-content: space-between; align-items:center; user-select: none;"
                                    onclick="$(this).nextUntil('.menu-category').slideToggle(200); $(this).find('i.toggle-icon').toggleClass('fa-chevron-up fa-chevron-down');">
                                    <span>{{ __('Other Menus') }}</span>
                                    <i class="fas {{ $other_is_active ? 'fa-chevron-up' : 'fa-chevron-down' }} toggle-icon" style="font-size: 10px; opacity: 0.5;"></i>
                                </li>
                                @php $has_others = true; @endphp
                            @endif
                            @php 
                                $all_sub_menus = (array) $sub_menu; 
                                $icon = count($all_sub_menus) > 1 ? 'fas fa-folder' : 'fas fa-file';
                            @endphp
                            @if(count($all_sub_menus) > 1)
                                <li class="main_dropdown @if(in_array(request()->route()->getName(),$all_sub_menus)) active @endif" style="{{ $other_is_active ? '' : 'display: none;' }}">
                                    <a href="javascript:void(0)" aria-expanded="true">
                                        <i class="{{ $icon }}"></i>
                                        <span>{{__(str_replace('_',' ',$main_menu))}}</span>
                                    </a>
                                    <ul class="collapse">
                                        @foreach($sub_menu as $item_name => $route_name)
                                        <li class="@if(request()->routeIs($route_name)) active @endif">
                                            <a href="{{route($route_name)}}">{{__(str_replace('_',' ',substr($item_name,1,-1)))}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @php $firstProp = current( (Array) $sub_menu ); @endphp
                                <li class="main_dropdown @if(request()->routeIs($firstProp)) active @endif">
                                    <a href="{{route($firstProp)}}" aria-expanded="true">
                                        <i class="{{ $icon }}"></i>
                                        <span>{{__(str_replace('_',' ',$main_menu))}}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</div>
