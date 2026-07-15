]<div class="sidebar-menu">
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
                        <a href="{{route('admin.home')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>@lang('dashboard')</span>
                        </a>
                    </li>
{{--                    @if(check_page_permission('admin_role_manage'))--}}
                        <li
                                class="main_dropdown
                        {{active_menu('admin-home/new-user')}}
                                {{active_menu('admin-home/all-user')}}
                                {{active_menu('admin-home/all-user/role')}}
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i>
                                <span>{{__('Admin Role Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/all-user')}}"><a
                                            href="{{route('admin.all.user')}}">{{__('All Admin')}}</a></li>
                                <li class="{{active_menu('admin-home/new-user')}}"><a
                                            href="{{route('admin.new.user')}}">{{__('Add New Admin')}}</a></li>
                                <li class="{{active_menu('admin-home/all-user/role')}}"><a
                                            href="{{route('admin.all.user.role')}}">{{__('All Admin Role')}}</a></li>
                            </ul>
                        </li>
{{--                    @endif--}}
                    {{--                    @if(check_page_permission_by_string('Widgets Manage'))--}}
                    <li
                            class="main_dropdown
                        {{active_menu('admin-home/widgets')}}
                            @if(request()->is('admin-home/widgets/*')) active @endif
                                    ">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                            <span>{{__('Widgets Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/widgets')}}"><a
                                        href="{{route('admin.widgets')}}">{{__('All Widgets')}}</a></li>
                        </ul>
                    </li>
                    {{--                    @endif--}}
                    @if(check_page_permission('form_builder'))
                        <li class="main_dropdown @if(request()->is('admin-home/form-builder/*')) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Form Builder')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/form-builder/quote-form')}}"><a
                                            href="{{route('admin.form.builder.quote')}}">{{__('Quote Form')}}</a></li>
                                <li class="{{active_menu('admin-home/form-builder/order-form')}}"><a
                                            href="{{route('admin.form.builder.order')}}">{{__('Order Form')}}</a></li>
                                <li class="{{active_menu('admin-home/form-builder/contact-form')}}"><a
                                            href="{{route('admin.form.builder.contact')}}">{{__('Contact Form')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/form-builder/call-back-form')}}"><a
                                            href="{{route('admin.form.builder.call.back')}}">{{__('Request Call Back Form')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/form-builder/job-apply-form')}}"><a
                                            href="{{route('admin.form.builder.job.apply')}}">{{__('Job Apply Form')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/form-builder/event-booking-form')}}"><a
                                            href="{{route('admin.form.builder.event.booking')}}">{{__('Event Booking Form')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('menus_manage'))
                        <li
                                class="main_dropdown
                        {{active_menu('admin-home/menu')}}
                                @if(request()->is('admin-home/menu-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Menus Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/menu')}}"><a
                                            href="{{route('admin.menu')}}">{{__('All Menus')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('newsletter_manage'))
                        <li
                                class="main_dropdown
                            {{active_menu('admin-home/newsletter')}}
                                @if(request()->is('admin-home/newsletter/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-email"></i>
                                <span>{{__('Newsletter Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/newsletter')}}"><a
                                            href="{{route('admin.newsletter')}}">{{__('All Subscriber')}}</a></li>
                                <li class="{{active_menu('admin-home/newsletter/all')}}"><a
                                            href="{{route('admin.newsletter.mail')}}">{{__('Send Mail To All')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('quote_manage'))
                        <li class="main_dropdown @if(request()->is('admin-home/quote-manage/*')) active @endif ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-quote-left"></i>
                                <span>{{__('Quote Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/quote-manage/all')}}"><a
                                            href="{{route('admin.quote.manage.all')}}">{{__('All Quote')}}</a></li>
                                <li class="{{active_menu('admin-home/quote-manage/pending')}}"><a
                                            href="{{route('admin.quote.manage.pending')}}">{{__('Pending Quote')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/quote-manage/completed')}}"><a
                                            href="{{route('admin.quote.manage.completed')}}">{{__('Complete Quote')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('order_manage'))
                        <li class="main_dropdown @if(request()->is('admin-home/order-manage/*')) active @endif ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-light-bulb"></i>
                                <span>{{__('Package Order Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/order-manage/all')}}"><a
                                            href="{{route('admin.order.manage.all')}}">{{__('All Order')}}</a></li>
                                <li class="{{active_menu('admin-home/order-manage/pending')}}"><a
                                            href="{{route('admin.order.manage.pending')}}">{{__('Pending Order')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/order-manage/in-progress')}}"><a
                                            href="{{route('admin.order.manage.in.progress')}}">{{__('In Progress Order')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/order-manage/completed')}}"><a
                                            href="{{route('admin.order.manage.completed')}}">{{__('Completed Order')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/order-manage/success-page')}}"><a
                                            href="{{route('admin.order.success.page')}}">{{__('Success Order Page')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/order-manage/cancel-page')}}"><a
                                            href="{{route('admin.order.cancel.page')}}">{{__('Cancel Order Page')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('all_payment_logs'))
                        <li class="main_dropdown {{active_menu('admin-home/payment-logs')}}">
                            <a href="{{route('admin.payment.logs')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('All Payment Logs')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('pages'))
                        <li
                                class="main_dropdown
                        {{active_menu('admin-home/page')}}
                                {{active_menu('admin-home/new-page')}}
                                @if(request()->is('admin-home/page-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Pages Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/page')}}"><a
                                            href="{{route('admin.page')}}">{{__('All Pages')}}</a></li>
                                <li class="{{active_menu('admin-home/new-page')}}"><a
                                            href="{{route('admin.page.new')}}">{{__('Add New Page')}}</a></li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('blogs'))
                        <li
                                class="main_dropdown
                                {{active_menu('admin-home/blog')}}
                                {{active_menu('admin-home/blog-category')}}
                                {{active_menu('admin-home/new-blog')}}
                                {{active_menu('admin-home/blog-page')}}
                                {{active_menu('admin-home/blog-single-page')}}
                                @if(request()->is('admin-home/blog-edit/*')) active @endif
                                "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Blogs Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/blog')}}"><a
                                            href="{{route('admin.blog')}}">{{__('All Blog')}}</a></li>
                                <li class="{{active_menu('admin-home/blog-category')}}"><a
                                            href="{{route('admin.blog.category')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/new-blog')}}"><a
                                            href="{{route('admin.blog.new')}}">{{__('Add New Post')}}</a></li>
                                <li class="{{active_menu('admin-home/blog-page')}}"><a
                                            href="{{route('admin.blog.page')}}">{{__('Blog page settings')}}</a></li>
                                <li class="{{active_menu('admin-home/blog-single-page')}}"><a
                                            href="{{route('admin.blog.single.page')}}">{{__('Blog Single Page settings')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('job_post_manage'))
                        <li
                                class="main_dropdown
                        {{active_menu('admin-home/jobs')}}
                                @if(request()->is('admin-home/jobs/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Job Post Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/jobs')}}"><a
                                            href="{{route('admin.jobs.all')}}">{{__('All Jobs')}}</a></li>
                                <li class="{{active_menu('admin-home/jobs/category')}}"><a
                                            href="{{route('admin.jobs.category.all')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/jobs/new')}}"><a
                                            href="{{route('admin.jobs.new')}}">{{__('Add New Job')}}</a></li>
                                <li class="{{active_menu('admin-home/jobs/page-settings')}}"><a
                                            href="{{route('admin.jobs.page.settings')}}">{{__('Job Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/jobs/applicant')}}"><a
                                            href="{{route('admin.jobs.applicant')}}">{{__('All Applicant')}}</a></li>
                                <li class="{{active_menu('admin-home/jobs/applicant/report')}}"><a
                                            href="{{route('admin.jobs.applicant.report')}}">{{__('Applicant Report')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('events_manage'))
                        <li class="main_dropdown
                    {{active_menu('admin-home/events')}}
                        @if(request()->is('admin-home/events/*')) active @endif
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Events Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/events')}}"><a
                                            href="{{route('admin.events.all')}}">{{__('All Events')}}</a></li>
                                <li class="{{active_menu('admin-home/events/category')}}"><a
                                            href="{{route('admin.events.category.all')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/events/new')}}"><a
                                            href="{{route('admin.events.new')}}">{{__('Add New Event')}}</a></li>
                                <li class="{{active_menu('admin-home/events/page-settings')}}"><a
                                            href="{{route('admin.events.page.settings')}}">{{__('Event Page Settings')}}</a></li>
                                <li class="{{active_menu('admin-home/events/single-page-settings')}}"><a
                                            href="{{route('admin.events.single.page.settings')}}">{{__('Event Single Settings')}}</a></li>
                                <li class="{{active_menu('admin-home/events/attendance')}}"><a
                                            href="{{route('admin.events.attendance')}}">{{__('Event Attendance')}}</a></li>
                                <li class="{{active_menu('admin-home/events/event-attendance-logs')}}"><a
                                            href="{{route('admin.event.attendance.logs')}}">{{__('Event Attendance Logs')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/events/event-payment-logs')}}"><a
                                            href="{{route('admin.event.payment.logs')}}">{{__('Event Payment Logs')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/events/payment-success-page-settings')}}"><a
                                            href="{{route('admin.events.payment.success.page.settings')}}">{{__('Payment Success Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/events/payment-cancel-pag-settings')}}"><a
                                            href="{{route('admin.events.payment.cancel.page.settings')}}">{{__('Payment Cancel Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/events/attendance/report')}}"><a
                                            href="{{route('admin.event.attendance.report')}}">{{__('Attendance Report')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/events/payment/report')}}"><a
                                            href="{{route('admin.event.payment.report')}}">{{__('Payment Log Report')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
{{--                    @if(check_page_permission_by_string('Products Manage') && !empty(get_static_option('product_module_status')))--}}
                        <li class="main_dropdown
                        {{active_menu('admin-home/products')}}
                        @if(request()->is('admin-home/products/*')) active @endif
                            ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Products Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/products')}}"><a
                                            href="{{route('admin.products.all')}}">{{__('All Products')}}</a></li>
                                <li class="{{active_menu('admin-home/products/new')}}"><a
                                            href="{{route('admin.products.new')}}">{{__('Add New Product')}}</a></li>
                                <li class="{{active_menu('admin-home/products/category')}}"><a
                                            href="{{route('admin.products.category.all')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/products/shipping')}}"><a
                                            href="{{route('admin.products.shipping.all')}}">{{__('Shipping')}}</a></li>
                                <li class="{{active_menu('admin-home/products/coupon')}}"><a
                                            href="{{route('admin.products.coupon.all')}}">{{__('Coupon')}}</a></li>
                                <li class="{{active_menu('admin-home/products/page-settings')}}"><a
                                            href="{{route('admin.products.page.settings')}}">{{__('Product Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/single-page-settings')}}"><a
                                            href="{{route('admin.products.single.page.settings')}}">{{__('Product Single Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/success-page-settings')}}"><a
                                            href="{{route('admin.products.success.page.settings')}}">{{__('Order Success Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/cancel-page-settings')}}"><a
                                            href="{{route('admin.products.cancel.page.settings')}}">{{__('Order Cancel Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/product-order-logs')}}"><a
                                            href="{{route('admin.products.order.logs')}}">{{__('Orders')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/product-ratings')}}"><a
                                            href="{{route('admin.products.ratings')}}">{{__('Ratings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/order-report')}}">
                                    <a href="{{route('admin.products.order.report')}}">{{__('Order Report')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/products/tax-settings')}}">
                                    <a href="{{route('admin.products.tax.settings')}}">{{__('Tax Settings')}}</a>
                                </li>
                            </ul>
                        </li>
{{--                    @endif--}}
{{--                    @if(check_page_permission_by_string('Donations Manage') && !empty(get_static_option('donations_module_status')))--}}
                        <li class="main_dropdown
                    {{active_menu('admin-home/donations')}}
                        @if(request()->is('admin-home/donations/*')) active @endif
                                ">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Donations Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/donations')}}"><a
                                            href="{{route('admin.donations.all')}}">{{__('All Donations')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/new')}}"><a
                                            href="{{route('admin.donations.new')}}">{{__('Add New Donation')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/page-settings')}}"><a
                                            href="{{route('admin.donations.page.settings')}}">{{__('Donation Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/single-page-settings')}}"><a
                                            href="{{route('admin.donations.single.page.settings')}}">{{__('Donation Single Settings')}}</a>
                                </li>

                                <li class="{{active_menu('admin-home/donations/donations-payment-logs')}}"><a
                                            href="{{route('admin.donations.payment.logs')}}">{{__('Donation Payment Logs')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/payment-success-page-settings')}}"><a
                                            href="{{route('admin.donations.payment.success.page.settings')}}">{{__('Payment Success Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/payment-cancel-pag-settings')}}"><a
                                            href="{{route('admin.donations.payment.cancel.page.settings')}}">{{__('Payment Cancel Page Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/donations/report')}}">
                                    <a href="{{route('admin.donations.report')}}">{{__('Donation Report')}}</a>
                                </li>
                            </ul>
                        </li>
{{--                    @endif--}}
                    @if(check_page_permission('knowledgebase'))
                        <li class="main_dropdown {{active_menu('admin-home/knowledge')}} @if(request()->is('admin-home/knowledge/*')) active @endif">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i>
                                <span>{{__('Knowledgebase')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/knowledge')}}"><a
                                            href="{{route('admin.knowledge.all')}}">{{__('All Articles')}}</a></li>
                                <li class="{{active_menu('admin-home/knowledge/category')}}"><a
                                            href="{{route('admin.knowledge.category.all')}}">{{__('Topics')}}</a></li>
                                <li class="{{active_menu('admin-home/new-knowledge')}}"><a
                                            href="{{route('admin.knowledge.new')}}">{{__('Add New Article')}}</a></li>
                                <li class="{{active_menu('admin-home/knowledge/page-settings')}}"><a
                                            href="{{route('admin.knowledge.page.settings')}}">{{__('Knowledgebase Page Settings')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('home_variant'))
                        <li class="main_dropdown {{active_menu('admin-home/home-variant')}}">
                            <a href="{{route('admin.home.variant')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('Home Variant')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('nabvar_settings'))
                        <li class="main_dropdown {{active_menu('admin-home/navbar-settings')}}">
                            <a href="{{route('admin.navbar.settings')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('Nabvar Settings')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('home_page_manage'))
                        <li class="main_dropdown
                        @if(request()->is('admin-home/home-page-01/*')  ) active @endif
                        @if(request()->is('admin-home/job-home/*')  ) active @endif
                        @if(request()->is('admin-home/charity-home/*')  ) active @endif
                        @if(request()->is('admin-home/knowledge-home/*')  ) active @endif
                        @if(request()->is('admin-home/event-home/*')  ) active @endif
                        @if(request()->is('admin-home/product-home/*')  ) active @endif
                        @if(request()->is('admin-home/service-home/*')  ) active @endif
                        {{active_menu('admin-home/header')}}
                        {{active_menu('admin-home/keyfeatures')}}
                                ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Home Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                @if(get_static_option('home_page_variant') == '06')
                                    <li class="{{active_menu('admin-home/service-home/header-area')}}">
                                        <a href="{{route('admin.service.home.header.area')}}">
                                            {{__('Header Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/video-area')}}">
                                        <a href="{{route('admin.service.home.video.area')}}">
                                            {{__('Video Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/our-services-area')}}">
                                        <a href="{{route('admin.service.home.our.service.area')}}">
                                            {{__('Our Services Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/counterup-area')}}">
                                        <a href="{{route('admin.service.home.counterup.area')}}">
                                            {{__('Counterup Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/work-process-area')}}">
                                        <a href="{{route('admin.service.home.work.process.area')}}">
                                            {{__('Work Process Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/news-area')}}">
                                        <a href="{{route('admin.service.home.news.area')}}">
                                            {{__('News Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/service-home/testimonial-area')}}">
                                        <a href="{{route('admin.service.home.testimonial.area')}}">
                                            {{__('Testimonial Area')}}
                                        </a>
                                    </li>
                                @endif
                                @if(get_static_option('home_page_variant') == '08')
                                    <li class="{{active_menu('admin-home/product-home/header-slider')}}">
                                        <a href="{{route('admin.product.home.header.slider')}}">
                                            {{__('Header Slider Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/product-home/featured-product')}}">
                                        <a href="{{route('admin.product.home.feature.product')}}">
                                            {{__('Featured Product Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/product-home/decorate-area')}}">
                                        <a href="{{route('admin.product.home.decorate.area')}}">
                                            {{__('Decorate Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/product-home/latest-product-area')}}">
                                        <a href="{{route('admin.product.home.latest.product.area')}}">
                                            {{__('Latest Product Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/product-home/testimonial-area')}}">
                                        <a href="{{route('admin.product.home.testimonial.area')}}">
                                            {{__('Testimonial Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/product-home/cta-area')}}">
                                        <a href="{{route('admin.product.home.cta.area')}}">
                                            {{__('Call To Action Area')}}
                                        </a>
                                    </li>
                                @endif
                                @if(get_static_option('home_page_variant') == '07')
                                    <li class="{{active_menu('admin-home/event-home/featured-event')}}">
                                        <a href="{{route('admin.event.home.featured.event')}}">
                                            {{__('Featured Event Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/attend-event')}}">
                                        <a href="{{route('admin.event.home.attend.event')}}">
                                            {{__('Why Attend Event Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/event-speaker-area')}}">
                                        <a href="{{route('admin.event.home.event.speaker.area')}}">
                                            {{__('Event Speaker Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/counterup-area')}}">
                                        <a href="{{route('admin.event.home.counterup.area')}}">
                                            {{__('Counterup Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/upcoming-event-area')}}">
                                        <a href="{{route('admin.event.home.upcoming.event.area')}}">
                                            {{__('Upcoming Event Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/our-sponsors-area')}}">
                                        <a href="{{route('admin.event.home.our.sponsors.area')}}">
                                            {{__('Sponsors Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/event-home/latest-blog-area')}}">
                                        <a href="{{route('admin.event.home.latest.blog.area')}}">
                                            {{__('Latest Blog Area')}}
                                        </a>
                                    </li>
                                @endif


                                @if(get_static_option('home_page_variant') == '09')
                                    <li class="{{active_menu('admin-home/charity-home/icon-box-area')}}">
                                        <a href="{{route('admin.charity.home.icon.box.area')}}">
                                            {{__('Icon Box Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/about-area')}}">
                                        <a href="{{route('admin.charity.home.about.area')}}">
                                            {{__('About Us Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/service-area')}}"><a
                                                href="{{route('admin.charity.home.service.area')}}">{{__('Service Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/recent-cause')}}"><a
                                                href="{{route('admin.charity.home.recent.cause')}}">{{__('Recent Cause Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/our-gallery')}}"><a
                                                href="{{route('admin.charity.home.our.gallery')}}">{{__('Our Gallery Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/event-area')}}"><a
                                                href="{{route('admin.charity.home.event.area')}}">{{__('Event Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/counterup-area')}}"><a
                                                href="{{route('admin.charity.home.counterup.area')}}">{{__('Counterup Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/team-member-area')}}"><a
                                                href="{{route('admin.charity.home.team.member.area')}}">{{__('Team Member Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/testimonial-area')}}"><a
                                                href="{{route('admin.charity.home.testimonial.area')}}">{{__('Testimonial Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/charity-home/new-block-area')}}"><a
                                                href="{{route('admin.charity.home.news.blog.area')}}">{{__('News & Blog Area')}}</a>
                                    </li>
                                @endif
                                @if(get_static_option('home_page_variant') == '05')
                                    <li class="{{active_menu('admin-home/knowledge-home/header')}}">
                                        <a href="{{route('admin.knowledge.home.header')}}">
                                            {{__('Header Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/knowledge-home/highlight-box')}}">
                                        <a href="{{route('admin.knowledge.home.highlight.box')}}">
                                            {{__('Highlight Box Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/knowledge-home/popular-article')}}">
                                        <a href="{{route('admin.knowledge.home.popular.article')}}">
                                            {{__('Popular Article Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/knowledge-home/faq-area')}}">
                                        <a href="{{route('admin.knowledge.home.faq.area')}}">{{__('FAQ Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/team-member')}}"><a
                                                href="{{route('admin.homeone.team.member')}}">{{__('Team Member Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/knowledge-home/cta-area')}}">
                                        <a href="{{route('admin.knowledge.home.cta.area')}}">{{__('Call To Action Area')}}</a>
                                    </li>
                                @endif
                                @if(get_static_option('home_page_variant') == '10')
                                    <li class="{{active_menu('admin-home/job-home/header')}}">
                                        <a href="{{route('admin.job.home.header')}}">
                                            {{__('Header Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/job-home/featured-job')}}">
                                        <a href="{{route('admin.job.home.featured.job.area')}}">
                                            {{__('Featured Job Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/job-home/millions-job-area')}}">
                                        <a href="{{route('admin.job.home.millions.job.area')}}">
                                            {{__('Millions Job Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/job-home/latest-job-area')}}">
                                        <a href="{{route('admin.job.home.latest.job.area')}}">
                                            {{__('Latest Job Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/latest-news')}}">
                                        <a href="{{route('admin.homeone.latest.news')}}">{{__('Latest News Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/job-home/testimonial-area')}}">
                                        <a href="{{route('admin.job.home.testimonial.area')}}">
                                            {{__('Testimonial Area')}}
                                        </a>
                                    </li>
                                @endif
                                @if(
                                get_static_option('home_page_variant') == '01' ||
                                get_static_option('home_page_variant') == '02' ||
                                get_static_option('home_page_variant') == '03' ||
                                get_static_option('home_page_variant') == '04'
                                )
                                    <li class="{{active_menu('admin-home/header')}}">
                                        <a href="{{route('admin.header')}}">
                                            {{__('Header Area')}}
                                        </a>
                                    </li>
                                    <li class="{{active_menu('admin-home/keyfeatures')}}">
                                        <a href="{{route('admin.keyfeatures')}}">{{__('Key Features')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/about-us')}}"><a
                                                href="{{route('admin.homeone.about.us')}}">{{__('About Us Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/service-area')}}"><a
                                                href="{{route('admin.homeone.service.area')}}">{{__('Service Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/cta-area')}}"><a
                                                href="{{route('admin.homeone.cta.area')}}">{{__('Call To Action Area')}}</a>
                                    </li>

                                    <li class="{{active_menu('admin-home/home-page-01/recent-work')}}"><a
                                                href="{{route('admin.homeone.recent.work')}}">{{__('Recent Work Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/testimonial')}}"><a
                                                href="{{route('admin.homeone.testimonial')}}">{{__('Testimonial Area')}}</a>
                                    </li>
                                    @if(get_static_option('home_page_variant') == '03')
                                        <li class="{{active_menu('admin-home/home-page-01/faq-area')}}"><a
                                                    href="{{route('admin.homeone.faq.area')}}">{{__('FAQ Area')}}</a>
                                        </li>
                                    @endif
                                    <li class="{{active_menu('admin-home/home-page-01/latest-news')}}"><a
                                                href="{{route('admin.homeone.latest.news')}}">{{__('Latest News Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/team-member')}}"><a
                                                href="{{route('admin.homeone.team.member')}}">{{__('Team Member Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/price-plan')}}"><a
                                                href="{{route('admin.homeone.price.plan')}}">{{__('Price Plan Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/counterup')}}"><a
                                                href="{{route('admin.homeone.counterup')}}">{{__('Counterup Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/newsletter')}}"><a
                                                href="{{route('admin.homeone.newsletter')}}">{{__('Newsletter Area')}}</a>
                                    </li>
                                    <li class="{{active_menu('admin-home/home-page-01/section-manage')}}"><a
                                                href="{{route('admin.homeone.section.manage')}}">{{__('Section Manage')}}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    <li class="main_dropdown  @if(request()->is('admin-home/gigs/*')  ) active @endif">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-home"></i>
                            <span>{{__('Gigs Manage')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/gigs/all')}}">
                                <a href="{{route('admin.gigs.all')}}">{{__('All Gigs')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/new')}}">
                                <a href="{{route('admin.gigs.new')}}">{{__('New Gig')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/category')}}">
                                <a href="{{route('admin.gigs.category')}}">{{__('Category')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/page')}}">
                                <a href="{{route('admin.gigs.page.settings')}}">{{__('Gigs Page Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/single-page')}}">
                                <a href="{{route('admin.gigs.single.page.settings')}}">{{__('Gigs Single Page Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/success-page')}}">
                                <a href="{{route('admin.gigs.success.page.settings')}}">{{__('Order Success Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/cancel-page')}}">
                                <a href="{{route('admin.gigs.cancel.page.settings')}}">{{__('Order Cancel Settings')}}</a>
                            </li>
                            <li class="{{active_menu('admin-home/gigs/orders')}}">
                                <a href="{{route('admin.gigs.orders')}}">{{__('Gigs Order Manage')}}</a>
                            </li>
                        </ul>
                    </li>

{{--                    @if(check_page_permission_by_string('Gallery Page'))--}}
                        <li class="main_dropdown  @if(request()->is('admin-home/gallery/*')  ) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Gallery Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/gallery/all')}}">
                                    <a href="{{route('admin.gallery.all')}}">{{__('Gallery Items')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/gallery/category')}}">
                                    <a href="{{route('admin.gallery.category')}}">{{__('Category')}}</a>
                                </li>
                            </ul>
                        </li>
{{--                    @endif--}}
{{--                    @if(check_page_permission_by_string('404 Page Manage'))--}}
                        <li class="main_dropdown {{active_menu('admin-home/404-page-manage')}}">
                            <a href="{{route('admin.404.page.settings')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                                <span>{{__('404 Page Manage')}}</span></a>
                        </li>
{{--                    @endif--}}
                    @if(check_page_permission('about_page_manage'))
                        <li class="main_dropdown @if(request()->is('admin-home/about-page/*')  ) active @endif ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('About Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/about-page/about-us')}}"><a
                                            href="{{route('admin.about.page.about')}}">{{__('About Us Section')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/about-page/know-about')}}"><a
                                            href="{{route('admin.about.know')}}">{{__('Know Us Section')}}</a></li>
                                <li class="{{active_menu('admin-home/about-page/section-manage')}}"><a
                                            href="{{route('admin.about.page.section.manage')}}">{{__('Section Manage')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('contact_page_manage'))
                        <li class="main_dropdown @if(request()->is('admin-home/contact-page/*')  ) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Contact Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/contact-page/contact-info')}}"><a
                                            href="{{route('admin.contact.info')}}">{{__('Contact Info')}}</a></li>
                                <li class="{{active_menu('admin-home/contact-page/form-area')}}"><a
                                            href="{{route('admin.contact.page.form.area')}}">{{__('Form Area')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/contact-page/map')}}"><a
                                            href="{{route('admin.contact.page.map')}}">{{__('Google Map Area')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('quote_page_manage'))
                        <li class="main_dropdown {{active_menu('admin-home/quote-page')}}">
                            <a href="{{route('admin.quote.page')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Quote Page Manage')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('order_page_manage'))
                        <li class="main_dropdown {{active_menu('admin-home/order-page')}}">
                            <a href="{{route('admin.order.page')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Order Page Manage')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('price_plan_page_manage'))
                        <li class="main_dropdown {{active_menu('admin-home/price-plan-page/settings')}}">
                            <a href="{{route('admin.price.plan.page.settings')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Price Plan Page Manage')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('top_bar_settings'))
                        <li class="main_dropdown {{active_menu('admin-home/topbar')}}">
                            <a href="{{route('admin.topbar')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Top Bar Settings')}}</span>
                            </a>
                        </li>
                    @endif
                    @if(check_page_permission('services'))
                        <li class="main_dropdown
                        @if(request()->is('admin-home/services/*')) active @endif
                        {{active_menu('admin-home/services')}}
                                ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Services')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/services')}}">
                                    <a href="{{route('admin.services')}}">{{__('All Services')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/services/new')}}">
                                    <a href="{{route('admin.services.new')}}">{{__('New Services')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/services/category')}}">
                                    <a href="{{route('admin.service.category')}}">{{__('Category')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/services/single-page-settings')}}">
                                    <a href="{{route('admin.services.single.page.settings')}}">{{__('Service Single Settings')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('works'))
                        <li class="main_dropdown
                        @if(request()->is('admin-home/works/*')) active @endif
                        {{active_menu('admin-home/works')}}
                                ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Works')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/works')}}">
                                    <a href="{{route('admin.work')}}">{{__('All Works')}}</a></li>
                                <li class="{{active_menu('admin-home/works/new')}}">
                                    <a href="{{route('admin.work.new')}}">{{__('New Works')}}</a></li>
                                <li class="{{active_menu('admin-home/works/category')}}">
                                    <a href="{{route('admin.work.category')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/works/work-page-settings')}}">
                                    <a href="{{route('admin.work.page.settings')}}">{{__('Work Page Manage')}}</a></li>
                                <li class="{{active_menu('admin-home/works/single-page-settings')}}">
                                    <a href="{{route('admin.work.single.page.settings')}}">{{__('Work Single Page Manage')}}</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(check_page_permission('faq'))
                        <li class="main_dropdown {{active_menu('admin-home/faq')}}">
                            <a href="{{route('admin.faq')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                                <span>{{__('Faq')}}</span></a>
                        </li>
                    @endif
                    @if(check_page_permission('brand_logos'))
                        <li class="main_dropdown {{active_menu('admin-home/brands')}}">
                            <a href="{{route('admin.brands')}}" aria-expanded="true"><i class="ti-control-forward"></i>
                                <span>{{__('Brand Logos')}}</span></a>
                        </li>
                    @endif
                    @if(check_page_permission('price_plan'))
                        <li class="main_dropdown {{active_menu('admin-home/price-plan')}}">
                            <a href="{{route('admin.price.plan')}}" aria-expanded="true"><i
                                        class="ti-control-forward"></i>
                                <span>{{__('Price Plan')}}</span></a>
                        </li>
                    @endif
                    @if(check_page_permission('team_members'))
                        <li class="main_dropdown {{active_menu('admin-home/team-member')}}">
                            <a href="{{route('admin.team.member')}}" aria-expanded="true"><i
                                        class="ti-control-forward"></i>
                                <span>{{__('Team Members')}}</span></a>
                        </li>
                    @endif
                    @if(check_page_permission('testimonial'))
                        <li class="main_dropdown {{active_menu('admin-home/testimonial')}}">
                            <a href="{{route('admin.testimonial')}}" aria-expanded="true"><i
                                        class="ti-control-forward"></i>
                                <span>{{__('Testimonial')}}</span></a>
                        </li>
                    @endif
                    @if(check_page_permission('counterup'))
                        <li class="main_dropdown {{active_menu('admin-home/counterup')}}">
                            <a href="{{route('admin.counterup')}}" aria-expanded="true"><i
                                        class="ti-exchange-vertical"></i>
                                <span>{{__('Counterup')}}</span></a>
                        </li>
                    @endif

                    @if(!empty(get_static_option('site_maintenance_mode')))
                        <li class="main_dropdown {{active_menu('admin-home/maintains-page/settings')}}">
                            <a href="{{route('admin.maintains.page.settings')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Maintain Page Manage')}}</span>
                            </a>
                        </li>
                    @endif
{{--                    @if(check_page_permission_by_string('Popup Builder'))--}}
                        <li class="main_dropdown @if(request()->is('admin-home/popup-builder/*')) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Popup Builder')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/popup-builder/all')}}"><a
                                            href="{{route('admin.popup.builder.all')}}">{{__('All Popup')}}</a></li>
                                <li class="{{active_menu('admin-home/popup-builder/new')}}"><a
                                            href="{{route('admin.popup.builder.new')}}">{{__('New Popup')}}</a></li>
                            </ul>
                        </li>
{{--                    @endif--}}

                    @if(check_page_permission('general_settings'))
                        <li class="main_dropdown @if(request()->is('admin-home/general-settings/*')) active @endif">
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                                <span>{{__('General Settings')}}</span></a>
                            <ul class="collapse ">
                                <li class="{{active_menu('admin-home/general-settings/site-identity')}}"><a
                                            href="{{route('admin.general.site.identity')}}">{{__('Site Identity')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/basic-settings')}}"><a
                                            href="{{route('admin.general.basic.settings')}}">{{__('Basic Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/typography-settings')}}"><a
                                            href="{{route('admin.general.typography.settings')}}">{{__('Typography Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/seo-settings')}}"><a
                                            href="{{route('admin.general.seo.settings')}}">{{__('SEO Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/scripts')}}"><a
                                            href="{{route('admin.general.scripts.settings')}}">{{__('Third Party Scripts')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/email-template')}}"><a
                                            href="{{route('admin.general.email.template')}}">{{__('Email Template')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/email-settings')}}"><a
                                            href="{{route('admin.general.email.settings')}}">{{__('Email Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/smtp-settings')}}"><a
                                            href="{{route('admin.general.smtp.settings')}}">{{__('SMTP Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/regenerate-image')}}"><a
                                            href="{{route('admin.general.regenerate.thumbnail')}}">{{__('Regenerate Media Image')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/permalink-flush')}}"><a
                                            href="{{route('admin.general.permalink.flush')}}">{{__('Permalink Flush')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/page-settings')}}"><a
                                            href="{{route('admin.general.page.settings')}}">{{__('Page Settings')}}</a>
                                </li>
                                @if(!empty(get_static_option('site_payment_gateway')))
                                    <li class="{{active_menu('admin-home/general-settings/payment-settings')}}"><a
                                                href="{{route('admin.general.payment.settings')}}">{{__('Payment Gateway Settings')}}</a>
                                    </li>
                                @endif
                                <li class="{{active_menu('admin-home/general-settings/custom-css')}}"><a
                                            href="{{route('admin.general.custom.css')}}">{{__('Custom CSS')}}</a></li>
                                <li class="{{active_menu('admin-home/general-settings/custom-js')}}"><a
                                            href="{{route('admin.general.custom.js')}}">{{__('Custom JS')}}</a></li>

                                <li class="{{active_menu('admin-home/general-settings/cache-settings')}}"><a
                                            href="{{route('admin.general.cache.settings')}}">{{__('Cache Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/gdpr-settings')}}"><a
                                            href="{{route('admin.general.gdpr.settings')}}">{{__('GDPR Compliant Cookies Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/preloader-settings')}}"><a
                                            href="{{route('admin.general.preloader.settings')}}">{{__('Preloader Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/popup-settings')}}"><a
                                            href="{{route('admin.general.popup.settings')}}">{{__('Popup Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/module-settings')}}"><a
                                            href="{{route('admin.general.module.settings')}}">{{__('Module Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/sitemap-settings')}}"><a
                                            href="{{route('admin.general.sitemap.settings')}}">{{__('Sitemap Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/rss-settings')}}"><a
                                            href="{{route('admin.general.rss.feed.settings')}}">{{__('RSS Feed Settings')}}</a>
                                </li>
                                <li class="{{active_menu('admin-home/general-settings/license-setting')}}"><a
                                            href="{{route('admin.general.license.settings')}}">{{__('Licence Settings')}}</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(check_page_permission('languages'))
                        <li class="main_dropdown @if(request()->is('admin-home/languages/*') || request()->is('admin-home/languages') ) active @endif">
                            <a href="{{route('admin.languages')}}" aria-expanded="true"><i class="ti-signal"></i>
                                <span>{{__('Languages')}}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
