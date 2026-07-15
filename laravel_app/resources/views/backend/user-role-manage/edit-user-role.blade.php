@extends('backend.admin-master')
@section('site-title')
    {{__('Edit User Role')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap">
                            <h4 class="header-title">{{__('Edit User Role For:'.' '.$role_details->name)}}</h4>
                            <a href="{{route('admin.all.user.role')}}" class="btn btn-info btn-xs"><i
                                        class="fas fa-angle-double-left"></i>{{__('All Role')}}</a>
                        </div>
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
                        <form action="{{route('admin.user.role.update.permission')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$role_details->id}}">
                            <input type="hidden" name="name" value="{{$role_details->name}}">
                            @php
                                $header_variant = get_static_option('home_page_variant');
                                   $all_permissions ['admin_role_manage'] = [ 'all_admin' => 'admin.all.user', 'add_new_admin' => 'admin.new.user','all_admin_role' => 'admin.all.user.role'  ];
                                   $all_permissions ['user_manage'] = [ 'all_users' => 'admin.all.frontend.user', 'add_new_user' => 'admin.frontend.new.user'];
                                   $all_permissions['widgets_manage'] = [ 'all_widgets' => 'admin.widgets'];
                                   $all_permissions['menus_manage'] = [ 'all_menus' => 'admin.menu'];
                                   $all_permissions['form_builder'] = [ 'quote_form' => 'admin.form.builder.quote','contact_form' => 'admin.form.builder.contact','order_form' => 'admin.form.builder.order' ,'request_call_back_form' => 'admin.form.builder.call.back','job_apply_form' => 'admin.form.builder.job.apply','event_booking_form' => 'admin.form.builder.event.booking'];
                                   $all_permissions['newsletter_manage'] = [ 'all_subscriber' => 'admin.newsletter','send_mail_to_all' => 'admin.newsletter.mail'];
                                   $all_permissions['quote_manage'] = [ 'all_quote' => 'admin.quote.manage.all','pending_quote' => 'admin.quote.manage.pending','complete_quote' => 'admin.quote.manage.completed', 'quote_page_manage' => 'admin.quote.page'];
                                   $all_permissions['package_order_manage'] = [ 'all_order' => 'admin.order.manage.all','pending_order' => 'admin.order.manage.pending','in_progress_order' => 'admin.order.manage.in.progress','completed_order' => 'admin.order.manage.completed','success_order_page' => 'admin.order.success.page','cancel_order_page' => 'admin.order.cancel.page','all_payment_logs' => 'admin.payment.logs','order_page_manage' => 'admin.order.page'];
                                   $all_permissions['pages_manage'] = [ 'all_pages' => 'admin.page','add_new_page' => 'admin.page.new'];
                                   $all_permissions['gallery_manage'] = [ 'gallery_items' => 'admin.gallery.all','category' => 'admin.gallery.category'];
                                   $all_permissions['about_page_manage'] = [ 'about_us_section' => 'admin.about.page.about','know_us_section' => 'admin.about.know','section_manage' => 'admin.about.page.section.manage'];
                                   $all_permissions['contact_page_manage'] = [ 'contact_info' => 'admin.contact.info','form_area' => 'admin.contact.page.form.area','google_map_area' => 'admin.contact.page.map','section_manage' => 'admin.contact.section.manage'];
                                   $all_permissions['404_page_manage'] = [ '404_page_manage' => 'admin.404.page.settings'];
                                   $all_permissions['faq'] = [ 'faq' => 'admin.faq'];
                                   $all_permissions['brand_logos'] = [ 'brand_logos' => 'admin.brands'];
                                   $all_permissions['price_plan'] = [ 'price_plan' => 'admin.price.plan','price_plan_page_manage' => 'admin.price.plan.page.settings'];
                                   $all_permissions['testimonial'] = [ 'testimonial' => 'admin.testimonial'];
                                   $all_permissions['team_members'] = [ 'team_members' => 'admin.team.member'];
                                   $all_permissions['counterup'] = [ 'counterup' => 'admin.counterup'];
                                   $all_permissions['site_maintenance_mode'] = [ 'site_maintenance_mode' => 'admin.maintains.page.settings'];
                                   $all_permissions['popup_builder'] = [ 'all_popup' => 'admin.popup.builder.all','new_popup' => 'admin.popup.builder.new'];
                                   $all_permissions['feedback_page_manage'] = [ 'page_settings' => 'admin.feedback.page.settings','form_builder' => 'admin.feedback.page.form.builder','all_feedback' => 'admin.feedback.all'];

                                   if ($header_variant== '06'){
                                        $all_permissions['home_page_manage'] = [
                                            'header_area' => 'admin.service.home.header.area', 'video_area' => 'admin.service.home.video.area','our_services_area' => 'admin.service.home.our.service.area', 'counterup_area' => 'admin.service.home.counterup.area',
                                            'work_process_area' => 'admin.service.home.work.process.area', 'news_area' => 'admin.service.home.news.area','testimonial_area' => 'admin.service.home.testimonial.area','section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }elseif($header_variant == '08'){
                                        $all_permissions['home_page_manage'] = [
                                           'header_slider_area' => 'admin.product.home.header.slider','featured_product_area' => 'admin.product.home.feature.product', 'decorate_area' => 'admin.product.home.decorate.area','latest_product_area' => 'admin.product.home.latest.product.area','testimonial_area' => 'admin.product.home.testimonial.area','call_to_action_area' => 'admin.product.home.cta.area','section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }elseif($header_variant == '07'){
                                        $all_permissions['home_page_manage'] = [
                                            'header_area' => 'admin.header','featured_event_area' => 'admin.event.home.featured.event','why_attend_event_area' => 'admin.event.home.attend.event', 'event_speaker_area' => 'admin.event.home.event.speaker.area','counterup_area' => 'admin.event.home.counterup.area','upcoming_event_area' => 'admin.event.home.upcoming.event.area','sponsors_area' => 'admin.event.home.our.sponsors.area', 'latest_blog_area' => 'admin.event.home.latest.blog.area','section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }elseif($header_variant == '09'){
                                        $all_permissions['home_page_manage'] = [
                                            'header_area' => 'admin.header','icon_box_area' => 'admin.charity.home.icon.box.area','about_us_area' => 'admin.charity.home.about.area', 'service_area' => 'admin.charity.home.service.area','recent_cause_area' => 'admin.charity.home.recent.cause','our_gallery_area' => 'admin.charity.home.our.gallery','event_area' => 'admin.charity.home.event.area', 'counterup_area' => 'admin.charity.home.counterup.area','team_member_area' => 'admin.charity.home.team.member.area', 'testimonial_area' => 'admin.charity.home.testimonial.area' , 'news_&_blog_area' => 'admin.charity.home.news.blog.area','section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }elseif($header_variant == '05'){
                                        $all_permissions['home_page_manage'] = [
                                           'header_area' => 'admin.knowledge.home.header','highlight_box_area' => 'admin.knowledge.home.highlight.box', 'popular_article_area' => 'admin.knowledge.home.popular.article','faq_area' => 'admin.knowledge.home.faq.area','team_member_area' => 'admin.homeone.team.member','call_to_action_area' => 'admin.knowledge.home.cta.area','section_manage' => 'admin.homeone.section.manage'

                                       ];
                                   }elseif($header_variant == '10'){
                                        $all_permissions['home_page_manage'] = [
                                           'header_area' => 'admin.job.home.header','featured_job-area' => 'admin.job.home.featured.job.area', 'millions_job_area' => 'admin.job.home.millions.job.area','latest_job_area' => 'admin.job.home.latest.job.area','latest_news_area' => 'admin.homeone.latest.news','testimonial_area' => 'admin.job.home.testimonial.area','section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }elseif(
                                       $header_variant == '01' ||
                                       $header_variant == '02' ||
                                       $header_variant == '03' ||
                                       $header_variant == '04'
                                       ){
                                        $all_permissions['home_page_manage'] = [
                                           'header_area' => 'admin.header','key_features' => 'admin.keyfeatures', 'about_us_area' => 'admin.homeone.about.us','service_area' => 'admin.homeone.service.area','call_to_action_area' => 'admin.homeone.cta.area','recent_work_area' => 'admin.homeone.recent.work', 'testimonial_area' => 'admin.homeone.testimonial',
                                           'faq_area' => 'admin.homeone.faq.area', 'latest_news_area' => 'admin.homeone.latest.news', 'team_member_area' => 'admin.homeone.team.member', 'price_plan_area' => 'admin.homeone.price.plan', 'counterup_area' => 'admin.homeone.counterup', 'newsletter_area' => 'admin.homeone.newsletter', 'section_manage' => 'admin.homeone.section.manage'
                                       ];
                                   }

                                   $all_permissions['home_variant'] = [ 'home_variant' => 'admin.home.variant'];
                                   $all_permissions['navbar_settings'] = [ 'navbar_settings' => 'admin.navbar.settings'];
                                   $all_permissions['top_bar_settings'] = [ 'top_bar_settings' => 'admin.topbar'];
                                   if (get_static_option('blog_module_status') == 'on'){
                                   $all_permissions[ 'blogs_manage'] = [ 'all_blog' => 'admin.blog','category' => 'admin.blog.category','add_new_post' => 'admin.blog.new' ,'blog_page_settings' => 'admin.blog.page','blog_single_page_settings' => 'admin.blog.single.page'];
                                   }
                                  if (get_static_option('job_module_status') == 'on'){
                                        $all_permissions['job_post_manage'] = [ 'all_jobs' => 'admin.jobs.all','category' => 'admin.jobs.category.all','add_new_job' => 'admin.jobs.new','job_page_settings' => 'admin.jobs.page.settings','all_applicant' => 'admin.jobs.applicant','applicant_report' => 'admin.jobs.applicant.report'];
                                  }
                                    if (get_static_option('events_module_status') == 'on'){
                                        $all_permissions['events_manage'] = [ 'all_events' => 'admin.events.all','category' => 'admin.events.category.all','add_new_event' => 'admin.events.new' ,'event_page_settings' => 'admin.events.page.settings','event_single_settings' => 'admin.events.single.page.settings','event_attendance' => 'admin.events.attendance','event_attendance_logs' => 'admin.event.attendance.logs' ,'event_payment_logs' => 'admin.event.payment.logs','payment_success_page_settings' => 'admin.events.payment.success.page.settings','payment_cancel_page_settings' => 'admin.events.payment.cancel.page.settings','attendance_report' => 'admin.event.attendance.report' , 'payment_log_report' => 'admin.event.payment.report'];
                                    }
                                    if (get_static_option('product_module_status') == 'on'){
                                        $all_permissions['products_manage'] = [ 'all_products' => 'admin.products.all','add_new_product' => 'admin.products.new' ,'category' => 'admin.products.category.all','shipping' => 'admin.products.shipping.all','coupon' => 'admin.products.coupon.all','product_page_settings' => 'admin.products.page.settings','product_single_page_settings' => 'admin.products.single.page.settings' , 'order_success_page_settings' => 'admin.products.success.page.settings','order_cancel_page_settings' => 'admin.products.cancel.page.settings','orders' => 'admin.products.order.logs','ratings' => 'admin.products.ratings','order_report' => 'admin.products.order.report','tax_settings' => 'admin.products.tax.settings'];
                                    }
                                    if (get_static_option('donations_module_status') == 'on'){
                                        $all_permissions['donations_manage'] = [ 'all_donations' => 'admin.donations.all','add_new_donation' => 'admin.donations.new','donation_page_settings' => 'admin.donations.page.settings','donation_single_settings' => 'admin.donations.single.page.settings' , 'donation_payment_logs' => 'admin.donations.payment.logs','payment_success_page_settings' => 'admin.donations.payment.success.page.settings','payment_cancel_page_settings' => 'admin.donations.payment.cancel.page.settings','donation_report' => 'admin.donations.report'];
                                    }
                                    if (get_static_option('knowledgebase_module_status') == 'on'){
                                     $all_permissions['knowledgebase_manage'] = [ 'all_articles' => 'admin.knowledge.all','topics' => 'admin.knowledge.category.all','add_new_article' => 'admin.knowledge.new','knowledgebase_page_settings' => 'admin.knowledge.page.settings'];
                                    }
                                     if (get_static_option('gig_module_status') == 'on'){
                                        $all_permissions['gigs_manage'] = [ 'all_gigs' => 'admin.gigs.all', 'new_gig' => 'admin.gigs.new','category' => 'admin.gigs.category','gigs_page_settings' => 'admin.gigs.page.settings' , 'gigs_single_page_settings' => 'admin.gigs.single.page.settings','order_success_settings' => 'admin.gigs.success.page.settings','order_cancel_settings' => 'admin.gigs.cancel.page.settings','gigs_order_manage' => 'admin.gigs.orders'];
                                     }
                                      if (get_static_option('service_module_status') == 'on'){
                                        $all_permissions['services'] = [ 'all_services' => 'admin.services', 'new_services' => 'admin.services.new','category' => 'admin.service.category' ,'service_single_settings' => 'admin.services.single.page.settings'];
                                      }
                                      if (get_static_option('works_module_status') == 'on'){
                                        $all_permissions['works'] = [ 'all_works' => 'admin.work','new_works' => 'admin.work.new','category' => 'admin.work.category','work_page_manage' => 'admin.work.page.settings','work_single_page_manage' => 'admin.work.single.page.settings'];
                                      }
                                   $all_permissions['languages'] = [ 'languages' => 'admin.languages'];
                                   $all_permissions['general_settings'] = [ 'site_identity' => 'admin.general.site.identity','basic_settings' => 'admin.general.basic.settings','typography_settings' => 'admin.general.typography.settings',
                                  'seo_settings' => 'admin.general.seo.settings', 'third_party_scripts' => 'admin.general.scripts.settings','email_template' => 'admin.general.email.template',
                                  'email_settings' => 'admin.general.email.settings', 'smtp_settings' => 'admin.general.smtp.settings','regenerate_media_image' => 'admin.general.regenerate.thumbnail',
                                  'permalink_flush' => 'admin.general.permalink.flush', 'page_settings' => 'admin.general.page.settings','payment_gateway_settings' => 'admin.general.payment.settings',
                                  'custom_css' => 'admin.general.custom.css', 'custom_js' => 'admin.general.custom.js' , 'cache_settings' => 'admin.general.cache.settings','gdpr_compliant_cookies_settings' => 'admin.general.gdpr.settings',
                                  'preloader_settings' => 'admin.general.preloader.settings', 'popup_settings' => 'admin.general.popup.settings','module_settings' => 'admin.general.module.settings',
                                  'sitemap_settings' => 'admin.general.sitemap.settings', 'rss_feed_settings' => 'admin.general.rss.feed.settings', 'licence_settings' => 'admin.general.license.settings'
                                  ];
                            @endphp
                            <div class="row">
                                @foreach($all_permissions as $name => $permission)
                                    @php
                                        $permm = array_key_exists($name,$assigned_permissions) ? (array) $assigned_permissions[$name] : [];
                                    @endphp
                                    <div class="col-lg-12">
                                        <div class="form-group parent_page permission_parent_wrap">
                                            <h4 class="parent_page">
                                                {{str_replace('_',' ',$name)}}</h4>
                                            <ul class="children_page">
                                                @foreach($permission as $key => $value)
                                                    <li>
                                                        <div class="form-check">
                                                            <input type="checkbox" name="{{$name."['".$key."']"}}"
                                                                   @if(in_array($value,$permm)) checked
                                                                   @endif value="{{$value}}"
                                                                   class="form-check-input">
                                                            <label class="form-check-label">{{str_replace('_',' ',$key)}}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit"
                                    class="btn btn-primary mt-4 pr-4 pl-4">{{__('Save Permissions')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                /* check checkbox while click on label */
                $(document).on('click', '.permission_parent_wrap ul li label', function (e) {
                    var el = $(this);
                    var input = el.prev('input');

                    if (input.prop('checked')) {
                        input.prop('checked', false);
                    } else {
                        input.prop('checked', true);
                    }
                });

                /* check all checkbox while click on heading */
                $(document).on('click', '.permission_parent_wrap h4', function (e) {
                    var el = $(this);
                    var allInput = el.parent().find('input[type="checkbox"]');
                    allInput.each(function (value) {
                        var _this = $(this);
                        if (_this.prop('checked')) {
                            _this.prop('checked', false);
                        } else {
                            _this.prop('checked', true);
                        }
                    });
                });
            });


        })(jQuery);
    </script>
@endsection
