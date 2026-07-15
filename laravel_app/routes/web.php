<?php

use App\ProductOrder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::feeds();

Route::group(['middleware' => ['setlang','globalVariable']],function (){

    Route::get('/','FrontendController@index')->name('homepage');
    Route::get('/p/{id}/{any}','FrontendController@dynamic_single_page')->name('frontend.dynamic.page');
    Route::get('/plan-order/{id}','FrontendController@plan_order')->name('frontend.plan.order');

    //payment status route
    Route::get('/order-success/{id}','FrontendController@order_payment_success')->name('frontend.order.payment.success');
    Route::get('/order-cancel/{id}','FrontendController@order_payment_cancel')->name('frontend.order.payment.cancel');
    Route::get('/order-confirm/{id}','FrontendController@order_confirm')->name('frontend.order.confirm');

    //payment
    Route::post('/order-confirm','PaymentLogController@order_payment_form')->name('frontend.order.payment.form');

    //ipn route
    Route::post('/midtrans-ipn', 'MidtransController@ipn')->name('midtrans.ipn');
    Route::post('/xendit-ipn', 'XenditController@ipn')->name('xendit.ipn');
    Route::post('/paypal-ipn','PaymentLogController@paypal_ipn')->name('frontend.paypal.ipn');
    Route::post('/paytm-ipn','PaymentLogController@paytm_ipn')->name('frontend.paytm.ipn');
    Route::get('/paystack/callback','PaymentLogController@paystack_callback')->name('frontend.paystack.callback');
    Route::get('/mollie/callback','PaymentLogController@mollie_webhook')->name('frontend.mollie.webhook');
    Route::post('/stripe','PaymentLogController@stripe_ipn')->name('frontend.stripe.ipn');
    Route::post('/razorpay','PaymentLogController@razorpay_ipn')->name('frontend.razorpay.ipn');
    Route::post('/flutterwave/pay','PaymentLogController@flutterwave_pay')->name('frontend.flutterwave.pay');
    Route::get('/flutterwave/callback','PaymentLogController@flutterwave_callback')->name('frontend.flutterwave.callback');
    Route::post('/paystack/pay','PaymentLogController@paystack_pay')->name('frontend.paystack.pay');
    Route::get('/paystack/callback','PaymentLogController@paystack_callback')->name('frontend.paystack.callback');



    //language change
    Route::get('/lang','FrontendController@lang_change')->name('frontend.langchange');
    Route::get('/home/{id}','FrontendController@home_page_change');
    Route::post('/contact-message','FrontendFormController@send_contact_message')->name('frontend.contact.message');
    Route::post('/subscribe-newsletter','FrontendFormController@subscribe_newsletter')->name('frontend.subscribe.newsletter');
    Route::post('/request-quote','FrontendFormController@send_quote_message')->name('frontend.quote.message');
    Route::post('/place-order','FrontendFormController@send_order_message')->name('frontend.order.message');
    Route::post('/request-call-back','FrontendFormController@send_call_back_message')->name('frontend.call.back.message');

    //static page
    $user_lang  = get_user_lang();
    $quote_page_slug = !empty(get_static_option('quote_page_slug')) ? get_static_option('quote_page_slug') : 'quote';
    $about_page_slug = !empty(get_static_option('about_page_slug')) ? get_static_option('about_page_slug') : 'about';
    $faq_page_slug = !empty(get_static_option('faq_page_slug')) ? get_static_option('faq_page_slug') : 'faq';
    $team_page_slug = !empty(get_static_option('team_page_slug')) ? get_static_option('team_page_slug') : 'team';
    $price_plan_page_slug = !empty(get_static_option('price_plan_page_slug')) ? get_static_option('price_plan_page_slug') : 'price-plan';
    $contact_page_slug = !empty(get_static_option('contact_page_slug')) ? get_static_option('contact_page_slug') : 'contact';

    Route::get('/'.$quote_page_slug,'FrontendController@request_quote')->name('frontend.request.quote');
    Route::get('/'.$about_page_slug,'FrontendController@about_page')->name('frontend.about');
    Route::get('/'.$faq_page_slug,'FrontendController@faq_page')->name('frontend.faq');
    Route::get('/'.$team_page_slug,'FrontendController@team_page')->name('frontend.team');
    Route::get('/'.$contact_page_slug,'FrontendController@contact_page')->name('frontend.contact');
    Route::get('/'.$price_plan_page_slug,'FrontendController@price_plan_page')->name('frontend.price.plan');

    //image gallery
    $testimonial_page_slug = !empty(get_static_option('testimonial_page_slug')) ? get_static_option('testimonial_page_slug') : 'testimonials';
    $feedback_page_slug = !empty(get_static_option('feedback_page_slug')) ? get_static_option('feedback_page_slug') : 'feedback';
    $clients_feedback_page_slug = !empty(get_static_option('clients_feedback_page_slug')) ? get_static_option('clients_feedback_page_slug') : 'clients-feedback';
    $image_gallery_page_slug = !empty(get_static_option('image_gallery_page_slug')) ? get_static_option('image_gallery_page_slug') : 'image-gallery';

    //testimonials
    Route::get('/'.$testimonial_page_slug,'FrontendController@testimonials')->name('frontend.testimonials');
    Route::get('/'.$feedback_page_slug,'FrontendController@feedback_page')->name('frontend.feedback');
    Route::get('/'.$clients_feedback_page_slug,'FrontendController@clients_feedback_page')->name('frontend.clients.feedback');
    Route::post('/'.$clients_feedback_page_slug.'/submit','FrontendFormController@clients_feedback_store')->name('frontend.clients.feedback.store');
    //image gallery
    Route::get('/'.$image_gallery_page_slug.'','FrontendController@image_gallery_page')->name('frontend.image.gallery');


    //product invoice for user
    Route::post('/package-user/generate-invoice','InvoiceGeneratorController@generate_package_invoice')->name('frontend.package.invoice.generate');
    //user login
    Route::get('/login','Auth\LoginController@showLoginForm')->name('user.login');
    Route::post('/login','Auth\LoginController@login');
    Route::post('/ajax-login','FrontendController@ajax_login')->name('user.ajax.login');

    Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('user.register');
    Route::post('/register','Auth\RegisterController@register');
    Route::get('/login/forget-password','FrontendController@showUserForgetPasswordForm')->name('user.forget.password');
    Route::get('/login/reset-password/{user}/{token}','FrontendController@showUserResetPasswordForm')->name('user.reset.password');
    Route::post('/login/reset-password','FrontendController@UserResetPassword')->name('user.reset.password.change');
    Route::post('/login/forget-password','FrontendController@sendUserForgetPasswordMail');
    Route::post('/logout','Auth\LoginController@logout')->name('user.logout');

    //user email verify
    Route::get('/user/email-verify','UserDashboardController@user_email_verify_index')->name('user.email.verify');
    Route::get('/user/resend-verify-code','UserDashboardController@reset_user_email_verify_code')->name('user.resend.verify.mail');
    Route::post('/user/email-verify','UserDashboardController@user_email_verify');

    //cancel order
    Route::post('/package-order-cancel','UserDashboardController@package_order_cancel')->name('frontend.package.order.cancel');
    Route::post('/product-order-cancel','UserDashboardController@product_order_cancel')->name('frontend.product.order.cancel');


});
//gig
Route::group(['middleware' => ['setlang','globalVariable','module_permission:gigs']],function (){

    //gigs
    $gig_page_slug = !empty(get_static_option('gig_page_slug')) ? get_static_option('gig_page_slug') : 'gigs';
    Route::get('/'.$gig_page_slug,'FrontendController@gig_page')->name('frontend.gigs');
    Route::get('/'.$gig_page_slug.'/{slug}','FrontendController@gig_single_page')->name('frontend.gigs.single');
    Route::get('/'.$gig_page_slug.'-search/','FrontendController@gig_search_page')->name('frontend.gigs.search');
    Route::get('/'.$gig_page_slug.'/category/{id}/{any}','FrontendController@category_wise_gig_page')->name('frontend.gigs.category');
    Route::get('/'.$gig_page_slug.'-order','FrontendController@redirect_gig_order_page')->name('frontend.gigs.order');
    Route::post('/'.$gig_page_slug.'-new-order','GigOrderController@gig_new_order')->name('frontend.gigs.order.new');

    //gig ipn route
    Route::post('/gig-paypal-ipn','GigOrderController@paypal_ipn')->name('frontend.gig.paypal.ipn');
    Route::post('/gig-paytm-ipn','GigOrderController@paytm_ipn')->name('frontend.gig.paytm.ipn');
    Route::get('/gig-paystack/callback','GigOrderController@paystack_callback')->name('frontend.gig.paystack.callback');
    Route::get('/gig-mollie/callback','GigOrderController@mollie_webhook')->name('frontend.gig.mollie.webhook');
    Route::post('/gig-stripe','GigOrderController@stripe_ipn')->name('frontend.gig.stripe.ipn');
    Route::post('/gig-razorpay','GigOrderController@razorpay_ipn')->name('frontend.gig.razorpay.ipn');
    Route::post('/gig-flutterwave/pay','GigOrderController@flutterwave_pay')->name('frontend.gig.flutterwave.pay');
    Route::get('/gig-flutterwave/callback','GigOrderController@flutterwave_callback')->name('frontend.gig.flutterwave.callback');
    //
    Route::get('gig-order-success/{id}','FrontendController@gig_order_payment_success')->name('frontend.gig.order.payment.success');
    Route::get('gig-order-cancel/{id}','FrontendController@gig_order_payment_cancel')->name('frontend.gig.order.payment.cancel');
    //generate invoice
    Route::post('/gig-user/generate-invoice','InvoiceGeneratorController@generate_gig_invoice')->name('frontend.gig.invoice.generate');
});

//blog
Route::group(['middleware' => ['setlang','globalVariable','module_permission:blogs']],function (){

    //blog
    $blog_page_slug = !empty(get_static_option('blog_page_slug')) ? get_static_option('blog_page_slug') : 'blog';
    Route::get('/'.$blog_page_slug.'/{slug}','FrontendController@blog_single_page')->name('frontend.blog.single');
    Route::get('/'.$blog_page_slug.'-search/','FrontendController@blog_search_page')->name('frontend.blog.search');
    Route::get('/'.$blog_page_slug.'/category/{id}/{any}','FrontendController@category_wise_blog_page')->name('frontend.blog.category');
    Route::get('/'.$blog_page_slug.'-tags/{name}','FrontendController@tags_wise_blog_page')->name('frontend.blog.tags.page');
    Route::get('/'.$blog_page_slug,'FrontendController@blog_page')->name('frontend.blog');
});

//works
Route::group(['middleware' => ['setlang','globalVariable','module_permission:works']],function (){
    $work_page_slug = !empty(get_static_option('work_page_slug')) ? get_static_option('work_page_slug') : 'work';
    Route::get('/'.$work_page_slug,'FrontendController@work_page')->name('frontend.work');
    Route::get('/'.$work_page_slug.'-category/{id}/{any}','FrontendController@category_wise_works_page')->name('frontend.works.category');
    Route::get('/'.$work_page_slug.'/{slug}','FrontendController@work_single_page')->name('frontend.work.single');
});

//service
Route::group(['middleware' => ['setlang','globalVariable','module_permission:services']],function (){
    $service_page_slug = !empty(get_static_option('service_page_slug')) ? get_static_option('service_page_slug') : 'service';
    Route::get('/'.$service_page_slug,'FrontendController@service_page')->name('frontend.service');
    Route::get('/'.$service_page_slug.'/category/{id}/{any}','FrontendController@category_wise_services_page')->name('frontend.services.category');
    Route::get('/'.$service_page_slug.'/{slug}','FrontendController@services_single_page')->name('frontend.services.single');
    Route::get('/'.$service_page_slug.'-search','FrontendController@services_search')->name('frontend.services.search');
});

//knowledgebase
Route::group(['middleware' => ['setlang','globalVariable','module_permission:knowledgebase']],function (){
    //knowledgebase
    $knowledgebase_page_slug = !empty(get_static_option('knowledgebase_page_slug')) ? get_static_option('knowledgebase_page_slug') : 'knowledgebase';
    Route::get('/'.$knowledgebase_page_slug,'FrontendController@knowledgebase')->name('frontend.knowledgebase');
    Route::get('/'.$knowledgebase_page_slug.'/{slug}','FrontendController@knowledgebase_single')->name('frontend.knowledgebase.single');
    Route::get('/'.$knowledgebase_page_slug.'-category/{id}/{any}','FrontendController@knowledgebase_category')->name('frontend.knowledgebase.category');
    Route::get('/'.$knowledgebase_page_slug.'-search','FrontendController@knowledgebase_search')->name('frontend.knowledgebase.search');
});

//jobs
Route::group(['middleware' => ['setlang','globalVariable','module_permission:job_post']],function (){

    //job post
    $career_with_us_page_slug = !empty(get_static_option('career_with_us_page_slug')) ? get_static_option('career_with_us_page_slug') : 'jobs';
    Route::get('/'.$career_with_us_page_slug,'FrontendController@jobs')->name('frontend.jobs');
    Route::get('/'.$career_with_us_page_slug.'/{slug}','FrontendController@jobs_single')->name('frontend.jobs.single');
    Route::get('/'.$career_with_us_page_slug.'-category/{id}/{any}','FrontendController@jobs_category')->name('frontend.jobs.category');
    Route::get('/'.$career_with_us_page_slug.'-search','FrontendController@jobs_search')->name('frontend.jobs.search');
    Route::get('/'.$career_with_us_page_slug.'-apply/{id}','FrontendController@jobs_apply')->name('frontend.jobs.apply');
    Route::post('/apply','FrontendFormController@store_jobs_applicant_data')->name('frontend.jobs.apply.store');

});

//event
Route::group(['middleware' => ['setlang','globalVariable','module_permission:events']],function (){

    //events
    $events_page_slug = !empty(get_static_option('events_page_slug')) ? get_static_option('events_page_slug') : 'events';
    Route::get('/'.$events_page_slug,'FrontendController@events')->name('frontend.events');
    Route::get('/'.$events_page_slug.'/{slug}','FrontendController@events_single')->name('frontend.events.single');
    Route::get('/'.$events_page_slug.'-category/{id}/{any}','FrontendController@events_category')->name('frontend.events.category');
    Route::get('/'.$events_page_slug.'-search','FrontendController@events_search')->name('frontend.events.search');
    Route::get('/'.$events_page_slug.'-booking/{id}','FrontendController@event_booking')->name('frontend.event.booking');
    Route::post('/'.$events_page_slug.'-booking','FrontendFormController@store_event_booking_data')->name('frontend.event.booking.store');

    //event payment ipn
    Route::post('/event-paypal-ipn','EventPaymentLogsController@paypal_ipn')->name('frontend.event.paypal.ipn');
    Route::post('/event-paytm-ipn','EventPaymentLogsController@paytm_ipn')->name('frontend.event.paytm.ipn');
    Route::post('/event-stripe','EventPaymentLogsController@stripe_ipn')->name('frontend.event.stripe.ipn');
    Route::post('/event-razorpay','EventPaymentLogsController@razorpay_ipn')->name('frontend.event.razorpay.ipn');
    Route::post('/event-paystack/pay','EventPaymentLogsController@paystack_pay')->name('frontend.event.paystack.pay');
    Route::post('/event-flullterwave/pay','EventPaymentLogsController@flutterwave_pay')->name('frontend.event.flutterwave.pay');
    Route::get('/event-flullterwave/callback','EventPaymentLogsController@flutterwave_callback')->name('frontend.event.flutterwave.callback');
    Route::get('/event-mollie/webhook','EventPaymentLogsController@mollie_webhook')->name('frontend.event.mollie.webhook');
    //event booking
    Route::get('/booking-confirm/{id}','FrontendController@booking_confirm')->name('frontend.event.booking.confirm');
    Route::post('/booking-confirm','EventPaymentLogsController@booking_payment_form')->name('frontend.event.payment.confirm');
    Route::get('/attendance-success/{id}','FrontendController@event_payment_success')->name('frontend.event.payment.success');
    Route::get('/attendance-cancel/{id}','FrontendController@event_payment_cancel')->name('frontend.event.payment.cancel');
    //invoice generate
    Route::post('/event-user/generate-invoice','InvoiceGeneratorController@generate_event_invoice')->name('frontend.event.invoice.generate');
});

//donation
Route::group(['middleware' => ['setlang','globalVariable','module_permission:donations']],function (){

    $donation_page_slug = !empty(get_static_option('donation_page_slug')) ? get_static_option('donation_page_slug') : 'donations';
    //donation page
    Route::get('/'.$donation_page_slug,'FrontendController@donations')->name('frontend.donations');
    Route::get('/'.$donation_page_slug.'/{slug}','FrontendController@donations_single')->name('frontend.donations.single');
    Route::post('/'.$donation_page_slug.'/donation','DonationLogController@store_donation_logs')->name('frontend.donations.log.store');

    $donor_page_slug = !empty(get_static_option('donor_page_slug')) ? get_static_option('donor_page_slug') : 'donor-list';
    Route::get('/'.$donor_page_slug,'FrontendController@donor_list')->name('frontend.donor.list');
    //donation
    Route::get('/donation-success/{id}','FrontendController@donation_payment_success')->name('frontend.donation.payment.success');
    Route::get('/donation-cancel/{id}','FrontendController@donation_payment_cancel')->name('frontend.donation.payment.cancel');
    Route::post('/donation-user/generate-invoice','InvoiceGeneratorController@generate_donation_invoice')->name('frontend.donation.invoice.generate');
    //donation payment ipn
    Route::post('/donation-paypal-ipn','DonationLogController@paypal_ipn')->name('frontend.donation.paypal.ipn');
    Route::post('/donation-paytm-ipn','DonationLogController@paytm_ipn')->name('frontend.donation.paytm.ipn');
    Route::post('/donation-stripe','DonationLogController@stripe_ipn')->name('frontend.donation.stripe.ipn');
    Route::post('/donation-razorpay','DonationLogController@razorpay_ipn')->name('frontend.donation.razorpay.ipn');
    Route::post('/donation-paystack/pay','DonationLogController@paystack_pay')->name('frontend.donation.paystack.pay');
    Route::get('/donation-mollie/webhook','DonationLogController@mollie_webhook')->name('frontend.donation.mollie.webhook');
    Route::post('/donation-flutterwave/pay','DonationLogController@flutterwave_pay')->name('frontend.donation.flutterwave.pay');
    Route::get('/donation-flutterwave/callback','DonationLogController@flutterwave_callback')->name('frontend.donation.flutterwave.callback');

});

//product
Route::group(['middleware' => ['setlang','globalVariable','module_permission:products']],function (){

    $product_page_slug = !empty(get_static_option('product_page_slug')) ? get_static_option('product_page_slug') : 'product';
    //product
    Route::get('/'.$product_page_slug,'FrontendController@products')->name('frontend.products');
    Route::get('/'.$product_page_slug.'/{slug}','FrontendController@product_single')->name('frontend.products.single');
    Route::get('/'.$product_page_slug.'-category/{id}/{any}','FrontendController@products_category')->name('frontend.products.category');
    Route::get('/'.$product_page_slug.'-cart','FrontendController@products_cart')->name('frontend.products.cart');
    Route::post('/'.$product_page_slug.'-cart/remove','ProductCartController@remove_cart_item')->name('frontend.products.cart.ajax.remove');
    Route::post('/'.$product_page_slug.'-item/add-to-cart','ProductCartController@add_to_cart')->name('frontend.products.add.to.cart');
    Route::post('/'.$product_page_slug.'-item/ajax/add-to-cart','ProductCartController@ajax_add_to_cart')->name('frontend.products.add.to.cart.ajax');
    Route::post('/'.$product_page_slug.'-item/ajax/coupon','ProductCartController@ajax_coupon_code')->name('frontend.products.coupon.code');
    Route::post('/'.$product_page_slug.'-item/ajax/shipping','ProductCartController@ajax_shipping_apply')->name('frontend.products.shipping.apply');
    Route::post('/'.$product_page_slug.'-item/ajax/cart-update','ProductCartController@ajax_cart_update')->name('frontend.products.ajax.cart.update');
    Route::get('/'.$product_page_slug.'-checkout','FrontendController@product_checkout')->name('frontend.products.checkout');
    Route::post('/'.$product_page_slug.'-checkout','ProductOrderController@product_checkout');
    Route::post('/'.$product_page_slug.'-ratings','FrontendController@product_ratings')->name('product.ratings.store');

    //product order
    Route::get('/'.$product_page_slug.'-success/{id}','FrontendController@product_payment_success')->name('frontend.product.payment.success');
    Route::get('/'.$product_page_slug.'-cancel/{id}','FrontendController@product_payment_cancel')->name('frontend.product.payment.cancel');
    Route::get('/'.$product_page_slug.'-view-order/{id}','FrontendController@product_order_view')->name('frontend.product.order.view');

    //product payment ipn
    Route::post('/product-paypal-ipn','ProductOrderController@paypal_ipn')->name('frontend.product.paypal.ipn');
    Route::post('/product-paytm-ipn','ProductOrderController@paytm_ipn')->name('frontend.product.paytm.ipn');
    Route::post('/product-stripe','ProductOrderController@stripe_ipn')->name('frontend.product.stripe.ipn');
    Route::post('/product-razorpay','ProductOrderController@razorpay_ipn')->name('frontend.product.razorpay.ipn');
    Route::post('/product-paystack/pay','ProductOrderController@paystack_pay')->name('frontend.product.paystack.pay');
    Route::post('/product-flullterwave/pay','ProductOrderController@flutterwave_pay')->name('frontend.product.flutterwave.pay');
    Route::get('/product-flullterwave/callback','ProductOrderController@flutterwave_callback')->name('frontend.product.flutterwave.callback');
    Route::get('/product-mollie/webhook','ProductOrderController@mollie_webhook')->name('frontend.product.mollie.webhook');

    //invoice generator
    Route::post('/products-user/generate-invoice','InvoiceGeneratorController@generate_product_invoice')->name('frontend.product.invoice.generate');
});

//user dashboard
Route::prefix('user-home')->middleware(['userEmailVerify','setlang','globalVariable'])->group(function (){
    
    $gig_page_slug = !empty(get_static_option('gig_page_slug')) ? get_static_option('gig_page_slug') : 'gigs';
    Route::get('/', 'UserDashboardController@user_index')->name('user.home');
    Route::get('/'.$gig_page_slug.'-details/{id}', 'UserDashboardController@gig_details')->name('user.home.gig.details');
    Route::get('/download/file/{id}', 'UserDashboardController@download_file')->name('user.dashboard.download.file');
    Route::post('/gig-new-message', 'UserDashboardController@gig_new_message')->name('user.home.gig.new.message');

    Route::post('/profile-update','UserDashboardController@user_profile_update')->name('user.profile.update');
    Route::post('/password-change','UserDashboardController@user_password_change')->name('user.password.change');
});

//user dashboard
Route::prefix('user-home')->middleware(['userEmailVerify','setlang','globalVariable'])->group(function (){
    Route::get('/', 'UserDashboardController@user_index')->name('user.home');
    Route::get('/download/file/{id}', 'UserDashboardController@download_file')->name('user.dashboard.download.file');
    Route::post('/profile-update','UserDashboardController@user_profile_update')->name('user.profile.update');
    Route::post('/password-change','UserDashboardController@user_password_change')->name('user.password.change');
});

//frontend user manage
Route::prefix('admin-home')->middleware(['admin_permission:user_manage'])->group(function (){
    //user role management
    Route::get('/frontend/new-user','FrontendUserManageController@new_user')->name('admin.frontend.new.user');
    Route::post('/frontend/new-user','FrontendUserManageController@new_user_add');
    Route::post('/frontend/user-update','FrontendUserManageController@user_update')->name('admin.frontend.user.update');
    Route::post('/frontend/user-password-chnage','FrontendUserManageController@user_password_change')->name('admin.frontend.user.password.change');
    Route::post('/frontend/delete-user/{id}','FrontendUserManageController@new_user_delete')->name('admin.frontend.delete.user');
    Route::get('/frontend/all-user','FrontendUserManageController@all_user')->name('admin.all.frontend.user');
    Route::post('/frontend/bulk-action','FrontendUserManageController@bulk_action')->name('admin.frontend.bulk.action');
});

//404 page manage
Route::prefix('admin-home')->middleware(['admin_permission:404_page_manage'])->group(function (){
    // work single page
    Route::get('404-page-manage','Error404PageManage@error_404_page_settings')->name('admin.404.page.settings');
    Route::post('404-page-manage','Error404PageManage@update_error_404_page_settings');
});

//feedback page manage
Route::prefix('admin-home')->middleware(['admin_permission:feedback_page_manage'])->group(function (){
    Route::get('/feedback-management','FeedbackController@feedback_management')->name('admin.feedback.management');
    //feedback page
    Route::get('/feedback-page/page-settings','FeedbackController@page_settings')->name('admin.feedback.page.settings');
    Route::post('/feedback-page/page-settings','FeedbackController@update_page_settings');
    //form builder
    Route::get('/feedback-page/form-builder','FeedbackController@form_builder')->name('admin.feedback.page.form.builder');
    Route::post('/feedback-page/form-builder','FeedbackController@update_form_builder');
    //all feedback
    Route::get('/feedback-page/all-feedback','FeedbackController@all_feedback')->name('admin.feedback.all');
    Route::post('/feedback-page/all-feedback/delete/{id}','FeedbackController@delete_feedback')->name('admin.feedback.delete');
    Route::post('/feedback-page/all-feedback/bulk-action','FeedbackController@bulk_action')->name('admin.feedback.bulk.action');
});


//widget manage
Route::prefix('admin-home')->middleware(['admin_permission:widgets_manage'])->group(function (){
    //widger manage
    Route::get('/widgets','WidgetsController@index')->name('admin.widgets');
    Route::post('/widgets/create','WidgetsController@new_widget')->name('admin.widgets.new');
    Route::post('/widgets/markup','WidgetsController@widget_markup')->name('admin.widgets.markup');
    Route::post('/widgets/update','WidgetsController@update_widget')->name('admin.widgets.update');
    Route::post('/widgets/update/order','WidgetsController@update_order_widget')->name('admin.widgets.update.order');
    Route::post('/widgets/delete','WidgetsController@delete_widget')->name('admin.widgets.delete');
});


//admin login
Route::get('/login/admin','Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::get('/login/admin/forget-password','FrontendController@showAdminForgetPasswordForm')->name('admin.forget.password');
Route::get('/login/admin/reset-password/{user}/{token}','FrontendController@showAdminResetPasswordForm')->name('admin.reset.password');
Route::post('/login/admin/reset-password','FrontendController@AdminResetPassword')->name('admin.reset.password.change');
Route::post('/login/admin/forget-password','FrontendController@sendAdminForgetPasswordMail');
Route::post('/logout/admin','AdminDashboardController@adminLogout')->name('admin.logout');
Route::post('/login/admin','Auth\LoginController@adminLogin');

//events routes
Route::prefix('admin-home')->middleware(['admin_permission:events_manage'])->group(function (){

    Route::get('/events-management','EventsController@events_management')->name('admin.events');
    Route::get('/events','EventsController@all_events')->name('admin.events.all');
    Route::get('/events/new','EventsController@new_event')->name('admin.events.new');
    Route::post('/events/new','EventsController@store_event');
    Route::get('/events/edit/{id}','EventsController@edit_event')->name('admin.events.edit');
    Route::post('/events/update','EventsController@update_event')->name('admin.events.update');
    Route::post('/events/delete/{id}','EventsController@delete_event')->name('admin.events.delete');
    Route::post('/events/clone','EventsController@clone_event')->name('admin.events.clone');
    Route::post('/events/bulk-action','EventsController@bulk_action')->name('admin.events.bulk.action');

    //event page settings
    Route::get('/events/page-settings','EventsController@page_settings')->name('admin.events.page.settings');
    Route::post('/events/page-settings','EventsController@update_page_settings');
    //payment success
    Route::get('/events/payment-success-page-settings','EventsController@payment_success_page_settings')->name('admin.events.payment.success.page.settings');
    Route::post('/events/payment-success-page-settings','EventsController@update_payment_success_page_settings');
    //payment cancel
    Route::get('/events/payment-cancel-pag-settings','EventsController@payment_cancel_page_settings')->name('admin.events.payment.cancel.page.settings');
    Route::post('/events/payment-cancel-pag-settings','EventsController@update_payment_cancel_page_settings');

    //event single page settings
    Route::get('/events/single-page-settings','EventsController@single_page_settings')->name('admin.events.single.page.settings');
    Route::post('/events/single-page-settings','EventsController@update_single_page_settings');
    Route::get('/events/attendance','EventsController@event_attendance')->name('admin.events.attendance');
    Route::post('/events/attendance','EventsController@update_event_attendance');
    //event attendance logs
    Route::get('/events/event-attendance-logs','EventsController@event_attendance_logs')->name('admin.event.attendance.logs');
    Route::post('/events/event-attendance-logs','EventsController@update_event_attendance_logs_status');
    Route::post('/events/event-attendance-logs/delete/{id}','EventsController@delete_event_attendance_logs')->name('admin.event.attendance.logs.delete');
    Route::post('/events/event-attendance-logs/send-mail','EventsController@send_mail_event_attendance_logs')->name('admin.event.attendance.send.mail');
    Route::post('/events/event-attendance-logs/bulk-action','EventsController@attendance_logs_bulk_action')->name('admin.event.attendance.bulk.action');
    //event payment logs
    Route::get('/events/event-payment-logs','EventsController@event_payment_logs')->name('admin.event.payment.logs');
    Route::post('/events/event-payment-logs/delete/{id}','EventsController@delete_event_payment_logs')->name('admin.event.payment.delete');
    Route::post('/events/event-payment-logs/approve/{id}','EventsController@approve_event_payment')->name('admin.event.payment.approve');
    Route::post('/events/event-payment-logs/bulk-action','EventsController@payment_logs_bulk_action')->name('admin.event.payment.bulk.action');

    Route::get('/events/payment/report','EventsController@payment_report')->name('admin.event.payment.report');
    Route::get('/events/attendance/report','EventsController@attendance_report')->name('admin.event.attendance.report');

    //event category
    Route::get('/events/category','EventsCategoryController@all_events_category')->name('admin.events.category.all');
    Route::post('/events/category/new','EventsCategoryController@store_events_category')->name('admin.events.category.new');
    Route::post('/events/category/update','EventsCategoryController@update_events_category')->name('admin.events.category.update');
    Route::post('/events/category/delete/{id}','EventsCategoryController@delete_events_category')->name('admin.events.category.delete');
    Route::post('/events/category/lang','EventsCategoryController@Category_by_language_slug')->name('admin.events.category.by.lang');
    Route::post('/events/category/bulk-action','EventsCategoryController@bulk_action')->name('admin.events.category.bulk.action');

});

//donation routes
Route::prefix('admin-home/donations')->middleware(['admin_permission:donations_manage'])->group(function (){
    Route::get('/donations-management','DonationController@donations_management')->name('admin.donations.management');
    Route::get('/','DonationController@all_donation')->name('admin.donations.all');
    Route::get('/new','DonationController@new_donation')->name('admin.donations.new');
    Route::post('/new','DonationController@store_donation');
    Route::get('/edit/{id}','DonationController@edit_donation')->name('admin.donations.edit');
    Route::post('/update','DonationController@update_donation')->name('admin.donations.update');
    Route::post('/delete/{id}','DonationController@delete_donation')->name('admin.donations.delete');
    Route::post('/clone','DonationController@clone_donation')->name('admin.donations.clone');
    Route::post('/bulk-action','DonationController@bulk_action')->name('admin.donations.bulk.action');

    //donation page settings
    Route::get('/page-settings','DonationController@page_settings')->name('admin.donations.page.settings');
    Route::post('/page-settings','DonationController@update_page_settings');
    //donation single page settings
    Route::get('/single-page-settings','DonationController@single_page_settings')->name('admin.donations.single.page.settings');
    Route::post('/single-page-settings','DonationController@update_single_page_settings');
    //payment success
    Route::get('/payment-success-page-settings','DonationController@payment_success_page_settings')->name('admin.donations.payment.success.page.settings');
    Route::post('/payment-success-page-settings','DonationController@update_payment_success_page_settings');
    //payment cancel
    Route::get('/payment-cancel-pag-settings','DonationController@payment_cancel_page_settings')->name('admin.donations.payment.cancel.page.settings');
    Route::post('/payment-cancel-pag-settings','DonationController@update_payment_cancel_page_settings');
    //report generate
    Route::get('/report','DonationController@donation_report')->name('admin.donations.report');

    //donation payment logs
    Route::get('/donations-payment-logs','DonationController@event_payment_logs')->name('admin.donations.payment.logs');
    Route::post('/donations-payment-logs/delete/{id}','DonationController@delete_event_payment_logs')->name('admin.donations.payment.delete');
    Route::post('/donations-payment-logs/approve/{id}','DonationController@approve_event_payment')->name('admin.donations.payment.approve');
    Route::post('/donations-payment-logs/bulk-action','DonationController@donation_payment_logs_bulk_action')->name('admin.donations.payment.bulk.action');

});

//knowledgebase routes
Route::prefix('admin-home')->middleware(['admin_permission:knowledgebase_manage'])->group(function (){

    Route::get('/knowledge-management','KnowledgebaseController@knowledgebase_management')->name('admin.knowledge.management');
    Route::get('/knowledge','KnowledgebaseController@all_knowledgebases')->name('admin.knowledge.all');
    Route::get('/knowledge/new','KnowledgebaseController@new_knowledgebase')->name('admin.knowledge.new');
    Route::post('/knowledge/new','KnowledgebaseController@store_knowledgebases');
    Route::get('/knowledge/edit/{id}','KnowledgebaseController@edit_knowledgebases')->name('admin.knowledge.edit');
    Route::post('/knowledge/update','KnowledgebaseController@update_knowledgebases')->name('admin.knowledge.update');
    Route::post('/knowledge/delete/{id}','KnowledgebaseController@delete_knowledgebases')->name('admin.knowledge.delete');
    Route::post('/knowledge/clone','KnowledgebaseController@clone_knowledgebases')->name('admin.knowledge.clone');
    Route::post('/knowledge/bulk-action','KnowledgebaseController@bulk_action')->name('admin.knowledge.bulk.action');

    //knowledge base page settings
    Route::get('/knowledge/page-settings','KnowledgebaseController@page_settings')->name('admin.knowledge.page.settings');
    Route::post('/knowledge/page-settings','KnowledgebaseController@update_page_settings');

    //knowledge base category
    Route::get('/knowledge/category','KnowledgebaseTopicsController@all_knowledgebase_category')->name('admin.knowledge.category.all');
    Route::post('/knowledge/category/new','KnowledgebaseTopicsController@store_knowledgebase_category')->name('admin.knowledge.category.new');
    Route::post('/knowledge/category/update','KnowledgebaseTopicsController@update_knowledgebase_category')->name('admin.knowledge.category.update');
    Route::post('/knowledge/category/delete/{id}','KnowledgebaseTopicsController@delete_knowledgebase_category')->name('admin.knowledge.category.delete');
    Route::post('/knowledge/category/lang','KnowledgebaseTopicsController@category_by_language_slug')->name('admin.knowledge.category.by.lang');
    Route::post('/knowledge/category/bulk-action','KnowledgebaseTopicsController@bulk_action')->name('admin.knowledge.category.bulk.action');

});

//job post routes
Route::prefix('admin-home')->middleware(['admin_permission:job_post_manage'])->group(function (){

    Route::get('/jobs-management','JobsController@jobs_management')->name('admin.jobs.management');
    Route::get('/jobs','JobsController@all_jobs')->name('admin.jobs.all');
    Route::get('/jobs/new','JobsController@new_job')->name('admin.jobs.new');
    Route::post('/jobs/new','JobsController@store_job');
    Route::get('/jobs/edit/{id}','JobsController@edit_job')->name('admin.jobs.edit');
    Route::post('/jobs/update','JobsController@update_job')->name('admin.jobs.update');
    Route::post('/jobs/delete/{id}','JobsController@delete_job')->name('admin.jobs.delete');
    Route::post('/jobs/bulk-action','JobsController@bulk_action')->name('admin.jobs.bulk.action');
    Route::post('/jobs/clone','JobsController@clone')->name('admin.jobs.clone');

    //job page settings
    Route::get('/jobs/page-settings','JobsController@page_settings')->name('admin.jobs.page.settings');
    Route::post('/jobs/page-settings','JobsController@update_page_settings');

    //job category
    Route::get('/jobs/category','JobsCategoryController@all_jobs_category')->name('admin.jobs.category.all');
    Route::post('/jobs/category/new','JobsCategoryController@store_jobs_category')->name('admin.jobs.category.new');
    Route::post('/jobs/category/update','JobsCategoryController@update_jobs_category')->name('admin.jobs.category.update');
    Route::post('/jobs/category/delete/{id}','JobsCategoryController@delete_jobs_category')->name('admin.jobs.category.delete');
    Route::post('/jobs/category/lang','JobsCategoryController@Language_by_slug')->name('admin.jobs.category.by.lang');
    Route::post('/jobs/category/bulk-action','JobsCategoryController@bulk_action')->name('admin.jobs.category.bulk.action');

    //job applicant
    Route::get('/jobs/applicant','JobsController@all_jobs_applicant')->name('admin.jobs.applicant');
    Route::post('/jobs/applicant/delete/{id}','JobsController@delete_job_applicant')->name('admin.jobs.applicant.delete');
    Route::post('/jobs/applicant/bulk-delete','JobsController@job_applicant_bulk_delete')->name('admin.jobs.applicant.bulk.delete');
    Route::get('/jobs/applicant/report','JobsController@job_applicant_report')->name('admin.jobs.applicant.report');

});

//quote manage route
Route::prefix('admin-home')->middleware(['admin_permission:quote_manage'])->group(function (){

    Route::get('/quote-management','QuoteManageController@quote_management')->name('admin.quote.management');
    Route::get('/quote-manage/all','QuoteManageController@all_quotes')->name('admin.quote.manage.all');
    Route::get('/quote-manage/pending','QuoteManageController@pending_quotes')->name('admin.quote.manage.pending');
    Route::get('/quote-manage/completed','QuoteManageController@completed_quotes')->name('admin.quote.manage.completed');
    Route::post('/quote-manage/change-status','QuoteManageController@change_status')->name('admin.quote.manage.change.status');
    Route::post('/quote-manage/send-mail','QuoteManageController@send_mail')->name('admin.quote.manage.send.mail');
    Route::post('/quote-manage/delete/{id}','QuoteManageController@quote_delete')->name('admin.quote.manage.delete');
    Route::post('/quote-manage/bulk-action','QuoteManageController@bulk_action')->name('admin.quote.manage.bulk.action');

    //quote
    Route::get('/quote-page','QuotePageController@index')->name('admin.quote.page');
    Route::post('/quote-page','QuotePageController@udpate');
});

//order manage route
Route::prefix('admin-home')->middleware(['admin_permission:package_order_manage'])->group(function (){
    Route::get('/order-management','OrderManageController@order_management')->name('admin.order.management');
    Route::get('/order-manage/all','OrderManageController@all_orders')->name('admin.order.manage.all');
    Route::get('/order-manage/pending','OrderManageController@pending_orders')->name('admin.order.manage.pending');
    Route::get('/order-manage/completed','OrderManageController@completed_orders')->name('admin.order.manage.completed');
    Route::get('/order-manage/in-progress','OrderManageController@in_progress_orders')->name('admin.order.manage.in.progress');

    Route::post('/order-manage/change-status','OrderManageController@change_status')->name('admin.order.manage.change.status');
    Route::post('/order-manage/send-mail','OrderManageController@send_mail')->name('admin.order.manage.send.mail');
    Route::post('/order-manage/delete/{id}','OrderManageController@order_delete')->name('admin.order.manage.delete');

    //thank you page
    Route::get('/order-manage/success-page','OrderManageController@order_success_payment')->name('admin.order.success.page');
    Route::post('/order-manage/success-page','OrderManageController@update_order_success_payment');
    //cancel page
    Route::get('/order-manage/cancel-page','OrderManageController@order_cancel_payment')->name('admin.order.cancel.page');
    Route::post('/order-manage/cancel-page','OrderManageController@update_order_cancel_payment');
    Route::post('/order-manage/bulk-action','OrderManageController@order_bulk_action')->name('admin.order.bulk.action');

    //order
    Route::get('/order-page','OrderPageController@index')->name('admin.order.page');
    Route::post('/order-page','OrderPageController@udpate');
    Route::get('/payment-logs','OrderManageController@all_payment_logs')->name('admin.payment.logs');
    Route::post('/payment-logs/delete/{id}','OrderManageController@payment_logs_delete')->name('admin.payment.delete');
    Route::post('/payment-logs/approve/{id}','OrderManageController@payment_logs_approve')->name('admin.payment.approve');
    Route::post('/payment-logs/bulk-action','OrderManageController@bulk_action')->name('admin.payment.bulk.action');

});


/* media upload routes */
Route::prefix('admin-home')->group(function (){
    Route::post('/media-upload/all','MediaUploadController@all_upload_media_file')->name('admin.upload.media.file.all');
    Route::post('/media-upload','MediaUploadController@upload_media_file')->name('admin.upload.media.file');
});
Route::prefix('admin-home')->group(function (){
    Route::post('/media-upload/delete','MediaUploadController@delete_upload_media_file')->name('admin.upload.media.file.delete');
});
/* media upload routes end */

//user role manage
Route::prefix('admin-home')->middleware(['admin_permission:admin_role_manage'])->group(function (){
    //user role management
    Route::get('/new-user','UserRoleManageController@new_user')->name('admin.new.user');
    Route::post('/new-user','UserRoleManageController@new_user_add');
    Route::post('/user-update','UserRoleManageController@user_update')->name('admin.user.update');
    Route::post('/user-password-chnage','UserRoleManageController@user_password_change')->name('admin.user.password.change');
    Route::post('/delete-user/{id}','UserRoleManageController@new_user_delete')->name('admin.delete.user');
    Route::get('/all-user','UserRoleManageController@all_user')->name('admin.all.user');
    Route::get('/all-user/role','UserRoleManageController@all_user_role')->name('admin.all.user.role');
    Route::post('/all-user/role','UserRoleManageController@add_new_user_role');
    Route::post('/all-user/role/delete/{id}','UserRoleManageController@delete_user_role')->name('admin.user.role.delete');
    Route::get('/all-user/role/edit/{id}','UserRoleManageController@edit_user_role')->name('admin.user.role.edit');
    Route::post('/all-user/role/update-permission','UserRoleManageController@update_user_role_permission')->name('admin.user.role.update.permission');
    Route::post('/all-user/role/update','UserRoleManageController@update_user_role')->name('admin.user.role.update');
});


//blogs
Route::prefix('admin-home')->middleware(['admin_permission:blogs_manage'])->group(function (){
    //blog
    Route::get('/blog','BlogController@index')->name('admin.blog');
    Route::get('/blog/new','BlogController@new_blog')->name('admin.blog.new');
    Route::post('/blog/new','BlogController@store_new_blog');
    Route::get('/blog-edit/{id}','BlogController@edit_blog')->name('admin.blog.edit');
    Route::post('/blog-update/{id}','BlogController@update_blog')->name('admin.blog.update');
    Route::post('/blog-delete/{id}','BlogController@delete_blog')->name('admin.blog.delete');
    Route::get('/blog-category','BlogController@category')->name('admin.blog.category');
    Route::post('/blog-category','BlogController@new_category');
    Route::post('/delete-blog-category/{id}','BlogController@delete_category')->name('admin.blog.category.delete');
    Route::post('/update-blog-category','BlogController@update_category')->name('admin.blog.category.update');
    Route::post('/blog-lang-by-cat','BlogController@Language_by_slug')->name('admin.blog.lang.cat');
    Route::post('/blog/clone','BlogController@clone_blog')->name('admin.blog.clone');
    //bulk action
    Route::post('/blog/bulk-action','BlogController@bulk_action')->name('admin.blog.bulk.action');
    Route::post('/blog/category/bulk-action','BlogController@category_bulk_action')->name('admin.blog.category.bulk.action');

    Route::get('/blog-page','AdminDashboardController@blog_page')->name('admin.blog.page');
    Route::post('/blog-page','AdminDashboardController@blog_page_update');

    //blog single page
    Route::get('/blog-single-page','AdminDashboardController@blog_single_page')->name('admin.blog.single.page');
    Route::post('/blog-single-page','AdminDashboardController@blog_single_page_update');
});

//brad logos
Route::prefix('admin-home')->middleware(['admin_permission:brand_logos'])->group(function (){
    //brand logos
    Route::get('/brands','BrandController@index')->name('admin.brands');
    Route::post('/brands','BrandController@store');
    Route::post('/update-brands','BrandController@update')->name('admin.brands.update');
    Route::post('/delete-brands/{id}','BrandController@delete')->name('admin.brands.delete');
    Route::post('/brands/bulk-action','BrandController@bulk_action')->name('admin.brands.bulk.action');
});

//about us page manage
Route::prefix('admin-home')->middleware(['admin_permission:about_page_manage'])->group(function (){
    //about page
    Route::get('/about-page/about-us','AboutPageController@about_page_about_section')->name('admin.about.page.about');
    Route::post('/about-page/about-us','AboutPageController@about_page_update_about_section');
    Route::get('/about-page/know-about','AboutPageController@about_page_know_about_section')->name('admin.about.know');
    Route::post('/about-page/know-about','AboutPageController@about_page_update_know_about_section');
    Route::post('/about-page/know-about/store','KnowAboutController@store')->name('know.about.store');
    Route::post('/about-page/know-about/update','KnowAboutController@update')->name('know.about.update');
    Route::post('/about-page/know-about/delete/{id}','KnowAboutController@delete')->name('know.about.delete');
    Route::get('/about-page/section-manage','AboutPageController@about_page_section_manage')->name('admin.about.page.section.manage');
    Route::post('/about-page/section-manage','AboutPageController@about_page_update_section_manage');
});

//contact page manage
Route::prefix('admin-home')->middleware(['admin_permission:contact_page_manage'])->group(function (){
    //contact page
    Route::get('/contact-page/form-area','ContactPageController@contact_page_form_area')->name('admin.contact.page.form.area');
    Route::post('/contact-page/form-area','ContactPageController@contact_page_update_form_area');
    Route::get('/contact-page/map','ContactPageController@contact_page_map_area')->name('admin.contact.page.map');
    Route::post('/contact-page/map','ContactPageController@contact_page_update_map_area');

    Route::get('/contact-page/section-manage','ContactPageController@contact_page_section_manage')->name('admin.contact.section.manage');
    Route::post('/contact-page/section-manage','ContactPageController@contact_page_update_section_manage');
    //contact info
    Route::get('/contact-page/contact-info','ContactInfoController@index')->name('admin.contact.info');
    Route::post('/contact-page/contact-info','ContactInfoController@store');
    Route::post('/contact-page/contact-info/title','ContactInfoController@contact_info_title')->name('admin.contact.info.title');
    Route::post('contact-page/contact-info/update','ContactInfoController@update')->name('admin.contact.info.update');
    Route::post('contact-page/contact-info/delete/{id}','ContactInfoController@delete')->name('admin.contact.info.delete');
    Route::post('contact-page/contact-info/bulk-action','ContactInfoController@bulk_action')->name('admin.contact.info.bulk.action');
});

//counterup
Route::prefix('admin-home')->middleware(['admin_permission:counterup'])->group(function (){
    Route::get('/counterup','CounterUpController@index')->name('admin.counterup');
    Route::post('/counterup','CounterUpController@store');
    Route::post('/update-counterup','CounterUpController@update')->name('admin.counterup.update');
    Route::post('/delete-counterup/{id}','CounterUpController@delete')->name('admin.counterup.delete');
    Route::post('/counterup/bulk-action','CounterUpController@bulk_action')->name('admin.counterup.bulk.action');
});

//faq
Route::prefix('admin-home')->middleware(['admin_permission:faq'])->group(function (){
    //faq
    Route::get('/faq','FaqController@index')->name('admin.faq');
    Route::post('/faq','FaqController@store');
    Route::post('/update-faq','FaqController@update')->name('admin.faq.update');
    Route::post('/delete-faq/{id}','FaqController@delete')->name('admin.faq.delete');
    Route::post('/faq/bulk-action','FaqController@bulk_action')->name('admin.faq.bulk.action');
});


//form builder
Route::prefix('admin-home')->middleware(['admin_permission:form_builder'])->group(function (){
    //form builder routes
    Route::get('/form-builder-management','FormBuilderController@form_builder_management')->name('admin.form.builder.management');
    Route::get('/form-builder/quote-form','FormBuilderController@quote_form_index')->name('admin.form.builder.quote');
    Route::post('/form-builder/quote-form','FormBuilderController@update_quote_form');
    Route::get('/form-builder/order-form','FormBuilderController@order_form_index')->name('admin.form.builder.order');
    Route::post('/form-builder/order-form','FormBuilderController@update_order_form');
    Route::get('/form-builder/contact-form','FormBuilderController@contact_form_index')->name('admin.form.builder.contact');
    Route::post('/form-builder/contact-form','FormBuilderController@update_contact_form');
    Route::get('/form-builder/call-back-form','FormBuilderController@call_back_form_index')->name('admin.form.builder.call.back');
    Route::post('/form-builder/call-back-form','FormBuilderController@update_call_back_form');
    //added in version 2.3
    Route::get('/form-builder/job-apply-form','FormBuilderController@apply_job_form_index')->name('admin.form.builder.job.apply');
    Route::post('/form-builder/job-apply-form','FormBuilderController@update_apply_job_form');
    Route::get('/form-builder/event-booking-form','FormBuilderController@event_booking_index')->name('admin.form.builder.event.booking');
    Route::post('/form-builder/event-booking-form','FormBuilderController@update_event_booking_form');
});

//general settings
Route::prefix('admin-home')->middleware(['admin_permission:general_settings'])->group(function (){
    //general settings
    Route::get('/general-settings/site-identity','GeneralSettingsController@site_identity')->name('admin.general.site.identity');
    Route::post('/general-settings/site-identity','GeneralSettingsController@update_site_identity');
    Route::get('/general-settings/basic-settings','GeneralSettingsController@basic_settings')->name('admin.general.basic.settings');
    Route::post('/general-settings/basic-settings','GeneralSettingsController@update_basic_settings');
    Route::get('/general-settings/seo-settings','GeneralSettingsController@seo_settings')->name('admin.general.seo.settings');
    Route::post('/general-settings/seo-settings','GeneralSettingsController@update_seo_settings');
    Route::get('/general-settings/scripts','GeneralSettingsController@scripts_settings')->name('admin.general.scripts.settings');
    Route::post('/general-settings/scripts','GeneralSettingsController@update_scripts_settings');
    Route::get('/general-settings/email-template','GeneralSettingsController@email_template_settings')->name('admin.general.email.template');
    Route::post('/general-settings/email-template','GeneralSettingsController@update_email_template_settings');
    Route::get('/general-settings/email-settings','GeneralSettingsController@email_settings')->name('admin.general.email.settings');
    Route::post('/general-settings/email-settings','GeneralSettingsController@update_email_settings');
    Route::get('/general-settings/typography-settings','GeneralSettingsController@typography_settings')->name('admin.general.typography.settings');
    Route::post('/general-settings/typography-settings','GeneralSettingsController@update_typography_settings');
    Route::post('/general-settings/typography-settings/single','GeneralSettingsController@get_single_font_variant')->name('admin.general.typography.single');
    Route::get('/general-settings/cache-settings','GeneralSettingsController@cache_settings')->name('admin.general.cache.settings');
    Route::post('/general-settings/cache-settings','GeneralSettingsController@update_cache_settings');
    Route::get('/general-settings/page-settings','GeneralSettingsController@page_settings')->name('admin.general.page.settings');
    Route::post('/general-settings/page-settings','GeneralSettingsController@update_page_settings');
    Route::get('/general-settings/backup-settings','GeneralSettingsController@backup_settings')->name('admin.general.backup.settings');
    Route::post('/general-settings/backup-settings','GeneralSettingsController@update_backup_settings');
    Route::post('/general-settings/backup-settings/delete','GeneralSettingsController@delete_backup_settings')->name('admin.general.backup.settings.delete');
    Route::post('/general-settings/backup-settings/restore','GeneralSettingsController@restore_backup_settings')->name('admin.general.backup.settings.restore');
    Route::get('/general-settings/update-system','GeneralSettingsController@update_system')->name('admin.general.update.system');
    Route::post('/general-settings/update-system','GeneralSettingsController@update_system_version');
    Route::get('/general-settings/license-setting','GeneralSettingsController@license_settings')->name('admin.general.license.settings');
    Route::post('/general-settings/license-setting','GeneralSettingsController@update_license_settings');
    Route::get('/general-settings/custom-css','GeneralSettingsController@custom_css_settings')->name('admin.general.custom.css');
    Route::post('/general-settings/custom-css','GeneralSettingsController@update_custom_css_settings');
    Route::get('/general-settings/gdpr-settings','GeneralSettingsController@gdpr_settings')->name('admin.general.gdpr.settings');
    Route::post('/general-settings/gdpr-settings','GeneralSettingsController@update_gdpr_cookie_settings');

    //update script
    Route::get('/general-settings/update-script','ScriptUpdateController@index')->name('admin.general.script.update');
    Route::post('/general-settings/update-script','ScriptUpdateController@update_script');

    //custom js
    Route::get('/general-settings/custom-js','GeneralSettingsController@custom_js_settings')->name('admin.general.custom.js');
    Route::post('/general-settings/custom-js','GeneralSettingsController@update_custom_js_settings');

    //regenerate media image
    Route::get('/general-settings/regenerate-image','GeneralSettingsController@regenerate_image_settings')->name('admin.general.regenerate.thumbnail');
    Route::post('/general-settings/regenerate-image','GeneralSettingsController@update_regenerate_image_settings');

    //permalink flush
    Route::get('/general-settings/permalink-flush','GeneralSettingsController@permalink_flush_settings')->name('admin.general.permalink.flush');
    Route::post('/general-settings/permalink-flush','GeneralSettingsController@update_permalink_flush_settings');

    //smtp settings
    Route::get('/general-settings/smtp-settings','GeneralSettingsController@smtp_settings')->name('admin.general.smtp.settings');
    Route::post('/general-settings/smtp-settings','GeneralSettingsController@update_smtp_settings');

    //payment gateway
    Route::get('/general-settings/payment-settings','GeneralSettingsController@payment_settings')->name('admin.general.payment.settings');
    Route::post('/general-settings/payment-settings','GeneralSettingsController@update_payment_settings');

    //module settings
    Route::get('/general-settings/module-settings','GeneralSettingsController@module_settings')->name('admin.general.module.settings');
    Route::post('/general-settings/module-settings','GeneralSettingsController@update_module_settings');

    //rss feed
    Route::get('/general-settings/rss-settings','GeneralSettingsController@rss_feed_settings')->name('admin.general.rss.feed.settings');
    Route::post('/general-settings/rss-settings','GeneralSettingsController@update_rss_feed_settings');

    //preloader
    Route::get('/general-settings/preloader-settings','GeneralSettingsController@preloader_settings')->name('admin.general.preloader.settings');
    Route::post('/general-settings/preloader-settings','GeneralSettingsController@update_preloader_settings');

    //preloader
    Route::get('/general-settings/popup-settings','GeneralSettingsController@popup_settings')->name('admin.general.popup.settings');
    Route::post('/general-settings/popup-settings','GeneralSettingsController@update_popup_settings');

    //sitemap
    Route::get('/general-settings/sitemap-settings','GeneralSettingsController@sitemap_settings')->name('admin.general.sitemap.settings');
    Route::post('/general-settings/sitemap-settings','GeneralSettingsController@update_sitemap_settings');
    Route::post('/general-settings/sitemap-settings/delete','GeneralSettingsController@delete_sitemap_settings')->name('admin.general.sitemap.settings.delete');

});


//preloader builder manage
Route::prefix('admin-home')->middleware(['admin_permission:popup_builder'])->group(function (){
    Route::get('/popup-management','PopupBuilderController@popup_management')->name('admin.popup.management');
    //popup page
    Route::get('/popup-builder/all','PopupBuilderController@all_popup')->name('admin.popup.builder.all');
    Route::get('/popup-builder/new','PopupBuilderController@new_popup')->name('admin.popup.builder.new');
    Route::post('/popup-builder/new','PopupBuilderController@store_popup');
    Route::get('/popup-builder/edit/{id}','PopupBuilderController@edit_popup')->name('admin.popup.builder.edit');
    Route::post('/popup-builder/update/{id}','PopupBuilderController@update_popup')->name('admin.popup.builder.update');
    Route::post('/popup-builder/delete/{id}','PopupBuilderController@delete_popup')->name('admin.popup.builder.delete');
    Route::post('/popup-builder/clone/{id}','PopupBuilderController@clone_popup')->name('admin.popup.builder.clone');
    Route::post('/popup-builder/bulk-action','PopupBuilderController@bulk_action')->name('admin.popup.builder.bulk.action');

});


//home page manage
Route::prefix('admin-home')->middleware(['admin_permission:home_page_manage'])->group(function (){
    //home page one
    Route::get('/home-page-01/counterup','HomePageController@home_01_counterup')->name('admin.homeone.counterup');
    Route::post('/home-page-01/counterup','HomePageController@home_01_update_counterup');
    Route::get('/home-page-01/latest-news','HomePageController@home_01_latest_news')->name('admin.homeone.latest.news');
    Route::post('/home-page-01/latest-news','HomePageController@home_01_update_latest_news');
    Route::get('/home-page-01/testimonial','HomePageController@home_01_testimonial')->name('admin.homeone.testimonial');
    Route::post('/home-page-01/testimonial','HomePageController@home_01_update_testimonial');
    Route::get('/home-page-01/service-area','HomePageController@home_01_service_area')->name('admin.homeone.service.area');
    Route::post('/home-page-01/service-area','HomePageController@home_01_update_service_area');
    Route::get('/home-page-01/recent-work','HomePageController@home_01_recent_work')->name('admin.homeone.recent.work');
    Route::post('/home-page-01/recent-work','HomePageController@home_01_update_recent_work');
    Route::get('/home-page-01/about-us','HomePageController@home_01_about_us')->name('admin.homeone.about.us');
    Route::post('/home-page-01/about-us','HomePageController@home_01_update_about_us');
    Route::get('/home-page-01/newsletter','HomePageController@home_01_newsletter')->name('admin.homeone.newsletter');
    Route::post('/home-page-01/newsletter','HomePageController@home_01_update_newsletter');
    Route::get('/home-page-01/cta-area','HomePageController@home_01_cta_area')->name('admin.homeone.cta.area');
    Route::post('/home-page-01/cta-area','HomePageController@home_01_update_cta_area');
    Route::get('/home-page-01/section-manage','HomePageController@home_01_section_manage')->name('admin.homeone.section.manage');
    Route::post('/home-page-01/section-manage','HomePageController@home_01_update_section_manage');
    Route::get('/home-page-01/price-plan','HomePageController@home_01_price_plan')->name('admin.homeone.price.plan');
    Route::post('/home-page-01/price-plan','HomePageController@home_01_update_price_plan');
    Route::get('/home-page-01/team-member','HomePageController@home_01_team_member')->name('admin.homeone.team.member');
    Route::post('/home-page-01/team-member','HomePageController@home_01_update_team_member');
    Route::get('/home-page-01/faq-area','HomePageController@home_01_faq_area')->name('admin.homeone.faq.area');
    Route::post('/home-page-01/faq-area','HomePageController@home_01_update_faq_area');
    //key features
    Route::get('/keyfeatures','KeyFeaturesController@index')->name('admin.keyfeatures');
    Route::post('/keyfeatures','KeyFeaturesController@store');
    Route::post('/home-page-01/keyfeatures','KeyFeaturesController@update_section_settings')->name('admin.keyfeature.section');
    Route::post('/update-keyfeatures','KeyFeaturesController@update')->name('admin.keyfeatures.update');
    Route::post('/delete-keyfeatures/{id}','KeyFeaturesController@delete')->name('admin.keyfeatures.delete');

    // all section manage
    Route::post('/knowledge-home/section-manage','HomePageController@knowledge_update_section_manage')->name('admin.knowledge.home.section.manage');
    Route::post('/service-home/section-manage','HomePageController@service_update_section_manage')->name('admin.service.home.section.manage');
    Route::post('/event-home/section-manage','HomePageController@event_update_section_manage')->name('admin.event.home.section.manage');
    Route::post('/product-home/section-manage','HomePageController@prodcut_update_section_manage')->name('admin.product.home.section.manage');
    Route::post('/charity-home/section-manage','HomePageController@charity_update_section_manage')->name('admin.charity.home.section.manage');
    Route::post('/job-home/section-manage','HomePageController@job_update_section_manage')->name('admin.job.home.section.manage');

    //header slider
    Route::get('/header','HeaderSliderController@index')->name('admin.header');
    Route::post('/header','HeaderSliderController@store');
    Route::post('/update-header','HeaderSliderController@update')->name('admin.header.update');
    Route::post('/delete-header/{id}','HeaderSliderController@delete')->name('admin.header.delete');

    //job page manage routes
    Route::get('/job-home/header','JobHomePageController@header_index')->name('admin.job.home.header');
    Route::post('/job-home/header','JobHomePageController@header_update');
    Route::get('/job-home/featured-job','JobHomePageController@featured_job_index')->name('admin.job.home.featured.job.area');
    Route::post('/job-home/featured-job','JobHomePageController@featured_job_update');
    Route::get('/job-home/millions-job-area','JobHomePageController@millions_job_index')->name('admin.job.home.millions.job.area');
    Route::post('/job-home/millions-job-area','JobHomePageController@millions_job_update');
    Route::get('/job-home/latest-job-area','JobHomePageController@latest_job_index')->name('admin.job.home.latest.job.area');
    Route::post('/job-home/latest-job-area','JobHomePageController@latest_job_update');
    Route::get('/job-home/testimonial-area','JobHomePageController@testimonial_index')->name('admin.job.home.testimonial.area');
    Route::post('/job-home/testimonial-area','JobHomePageController@testimonial_update');

    /* knowledgebae home */
    Route::get('/knowledge-home/header','KnowledgeHomePageController@header_index')->name('admin.knowledge.home.header');
    Route::post('/knowledge-home/header','KnowledgeHomePageController@header_update');
    Route::get('/knowledge-home/highlight-box','KnowledgeHomePageController@highlight_box_index')->name('admin.knowledge.home.highlight.box');
    Route::post('/knowledge-home/highlight-box','KnowledgeHomePageController@highlight_box_update');
    Route::get('/knowledge-home/popular-article','KnowledgeHomePageController@popular_article_index')->name('admin.knowledge.home.popular.article');
    Route::post('/knowledge-home/popular-article','KnowledgeHomePageController@popular_article_update');
    Route::get('/knowledge-home/faq-area','KnowledgeHomePageController@faq_area_index')->name('admin.knowledge.home.faq.area');
    Route::post('/knowledge-home/faq-area','KnowledgeHomePageController@faq_area_update');
    Route::get('/knowledge-home/cta-area','KnowledgeHomePageController@cta_area_index')->name('admin.knowledge.home.cta.area');
    Route::post('/knowledge-home/cta-area','KnowledgeHomePageController@cta_area_update');

    /* charity home */
    Route::get('/charity-home/icon-box-area','CharityHomePageController@icon_box_area_index')->name('admin.charity.home.icon.box.area');
    Route::post('/charity-home/icon-box-area','CharityHomePageController@icon_box_area_update');
    Route::get('/charity-home/about-area','CharityHomePageController@about_area_index')->name('admin.charity.home.about.area');
    Route::post('/charity-home/about-area','CharityHomePageController@about_area_update');
    Route::get('/charity-home/service-area','CharityHomePageController@service_area_index')->name('admin.charity.home.service.area');
    Route::post('/charity-home/service-area','CharityHomePageController@service_area_update');
    Route::get('/charity-home/recent-cause','CharityHomePageController@recent_cause_index')->name('admin.charity.home.recent.cause');
    Route::post('/charity-home/recent-cause','CharityHomePageController@recent_cause_update');
    Route::get('/charity-home/our-gallery','CharityHomePageController@our_gallery_index')->name('admin.charity.home.our.gallery');
    Route::post('/charity-home/our-gallery','CharityHomePageController@our_gallery_update');
    Route::get('/charity-home/event-area','CharityHomePageController@event_area_index')->name('admin.charity.home.event.area');
    Route::post('/charity-home/event-area','CharityHomePageController@event_area_update');
    Route::get('/charity-home/counterup-area','CharityHomePageController@counterup_area_index')->name('admin.charity.home.counterup.area');
    Route::post('/charity-home/counterup-area','CharityHomePageController@counterup_area_update');
    Route::get('/charity-home/team-member-area','CharityHomePageController@team_member_area_index')->name('admin.charity.home.team.member.area');
    Route::post('/charity-home/team-member-area','CharityHomePageController@team_member_area_update');
    Route::get('/charity-home/testimonial-area','CharityHomePageController@testimonial_area_index')->name('admin.charity.home.testimonial.area');
    Route::post('/charity-home/testimonial-area','CharityHomePageController@testimonial_area_update');
    Route::get('/charity-home/new-block-area','CharityHomePageController@news_blog_area_index')->name('admin.charity.home.news.blog.area');
    Route::post('/charity-home/new-block-area','CharityHomePageController@news_blog_area_update');

    /* Event home */
    Route::get('/event-home/featured-event','EventHomePageController@featured_event_area_index')->name('admin.event.home.featured.event');
    Route::post('/event-home/featured-event','EventHomePageController@featured_event_area_update');
    Route::get('/event-home/attend-event','EventHomePageController@attend_event_area_index')->name('admin.event.home.attend.event');
    Route::post('/event-home/attend-event','EventHomePageController@attend_event_area_update');
    Route::get('/event-home/event-speaker-area','EventHomePageController@event_speaker_area_index')->name('admin.event.home.event.speaker.area');
    Route::post('/event-home/event-speaker-area','EventHomePageController@event_speaker_area_update');
    Route::get('/event-home/counterup-area','EventHomePageController@counterup_area_index')->name('admin.event.home.counterup.area');
    Route::post('/event-home/counterup-area','EventHomePageController@counterup_area_update');
    Route::get('/event-home/upcoming-event-area','EventHomePageController@upcoming_event_area_index')->name('admin.event.home.upcoming.event.area');
    Route::post('/event-home/upcoming-event-area','EventHomePageController@upcoming_event_area_update');
    Route::get('/event-home/our-sponsors-area','EventHomePageController@our_sponsors_area_index')->name('admin.event.home.our.sponsors.area');
    Route::post('/event-home/our-sponsors-area','EventHomePageController@our_sponsors_area_update');
    Route::get('/event-home/latest-blog-area','EventHomePageController@latest_blog_area_index')->name('admin.event.home.latest.blog.area');
    Route::post('/event-home/latest-blog-area','EventHomePageController@latest_blog_area_update');

    /* product home */
    Route::get('/product-home/header-slider','ProductHomePageController@header_slider_index')->name('admin.product.home.header.slider');
    Route::post('/product-home/header-slider','ProductHomePageController@header_slider_update');
    Route::get('/product-home/featured-product','ProductHomePageController@featured_product_index')->name('admin.product.home.feature.product');
    Route::post('/product-home/featured-product','ProductHomePageController@featured_product_update');
    Route::post('/product-home/featured-product/product-by-lang','ProductHomePageController@get_product_by_lang')->name('admin.product.home.product.by.lang');
    Route::get('/product-home/decorate-area','ProductHomePageController@decorate_area_index')->name('admin.product.home.decorate.area');
    Route::post('/product-home/decorate-area','ProductHomePageController@decorate_area_update');
    Route::get('/product-home/latest-product-area','ProductHomePageController@latest_product_area_index')->name('admin.product.home.latest.product.area');
    Route::post('/product-home/latest-product-area','ProductHomePageController@latest_product_area_update');
    Route::get('/product-home/testimonial-area','ProductHomePageController@testimonial_index')->name('admin.product.home.testimonial.area');
    Route::post('/product-home/testimonial-area','ProductHomePageController@testimonial_update');
    Route::get('/product-home/cta-area','ProductHomePageController@cta_index')->name('admin.product.home.cta.area');
    Route::post('/product-home/cta-area','ProductHomePageController@cta_update');

    /* service home */
    Route::get('/service-home/header-area','ServiceHomePageController@header_index')->name('admin.service.home.header.area');
    Route::post('/service-home/header-area','ServiceHomePageController@header_update');
    Route::get('/service-home/video-area','ServiceHomePageController@video_index')->name('admin.service.home.video.area');
    Route::post('/service-home/video-area','ServiceHomePageController@video_update');
    Route::get('/service-home/our-services-area','ServiceHomePageController@our_service_index')->name('admin.service.home.our.service.area');
    Route::post('/service-home/our-services-area','ServiceHomePageController@our_service_update');
    Route::get('/service-home/counterup-area','ServiceHomePageController@counterup_index')->name('admin.service.home.counterup.area');
    Route::post('/service-home/counterup-area','ServiceHomePageController@counterup_update');
    Route::get('/service-home/work-process-area','ServiceHomePageController@work_process_index')->name('admin.service.home.work.process.area');
    Route::post('/service-home/work-process-area','ServiceHomePageController@work_process_update');
    Route::get('/service-home/news-area','ServiceHomePageController@news_area_index')->name('admin.service.home.news.area');
    Route::post('/service-home/news-area','ServiceHomePageController@news_area_update');
    Route::get('/service-home/testimonial-area','ServiceHomePageController@testimonial_area_index')->name('admin.service.home.testimonial.area');
    Route::post('/service-home/testimonial-area','ServiceHomePageController@testimonial_area_update');

});



//products routes
Route::prefix('admin-home')->middleware(['admin_permission:products_manage'])->group(function (){
    //products
    Route::get('/products-management','ProductsController@products_management')->name('admin.products');
    Route::get('/products','ProductsController@all_product')->name('admin.products.all');
    Route::get('/products/new','ProductsController@new_product')->name('admin.products.new');
    Route::post('/products/new','ProductsController@store_product');
    Route::get('/products/edit/{id}','ProductsController@edit_product')->name('admin.products.edit');
    Route::post('/products/update','ProductsController@update_product')->name('admin.products.update');
    Route::post('/products/delete/{id}','ProductsController@delete_product')->name('admin.products.delete');
    Route::post('/products/clone','ProductsController@clone_product')->name('admin.products.clone');
    Route::post('/products/bulk-action','ProductsController@bulk_action')->name('admin.products.bulk.action');
    Route::get('/products/file/download/{id}','ProductsController@download_file')->name('admin.products.file.download');
    //product ratings
    Route::get('/products/product-ratings','ProductsController@product_ratings')->name('admin.products.ratings');
    Route::post('/products/product-ratings/delete/{id}','ProductsController@product_ratings_delete')->name('admin.products.ratings.delete');
    Route::post('/products/product-ratings/bulk-action','ProductsController@product_ratings_bulk_action')->name('admin.products.ratings.bulk.action');

    //orders
    Route::get('/products/product-order-logs','ProductsController@product_order_logs')->name('admin.products.order.logs');
    Route::post('/products/product-order-logs/approve/{id}','ProductsController@product_order_payment_approve')->name('admin.products.order.payment.approve');
    Route::post('/products/product-order-logs/delete/{id}','ProductsController@product_order_delete')->name('admin.product.payment.delete');
    Route::post('/products/product-order-logs/status-change','ProductsController@product_order_status_change')->name('admin.product.order.status.change');
    Route::post('/products/product-order-logs/bulk-actoin','ProductsController@product_order_bulk_action')->name('admin.product.order.bulk.action');
    Route::post('/products/generate-invoice','ProductsController@generate_invoice')->name('admin.product.invoice.generate');

    //products  page settings
    Route::get('/products/page-settings','ProductsController@page_settings')->name('admin.products.page.settings');
    Route::post('/products/page-settings','ProductsController@update_page_settings');
    Route::get('/products/single-page-settings','ProductsController@single_page_settings')->name('admin.products.single.page.settings');
    Route::post('/products/single-page-settings','ProductsController@update_single_page_settings');

    Route::get('/products/success-page-settings','ProductsController@success_page_settings')->name('admin.products.success.page.settings');
    Route::post('/products/success-page-settings','ProductsController@update_success_page_settings');
    Route::get('/products/cancel-page-settings','ProductsController@cancel_page_settings')->name('admin.products.cancel.page.settings');
    Route::post('/products/cancel-page-settings','ProductsController@update_cancel_page_settings');

    Route::get('/products/order-report','ProductsController@order_report')->name('admin.products.order.report');
    Route::get('/products/tax-settings','ProductsController@tax_settings')->name('admin.products.tax.settings');
    Route::post('/products/tax-settings','ProductsController@update_tax_settings');

    //products category
    Route::get('/products/category','ProductCategoryController@all_product_category')->name('admin.products.category.all');
    Route::post('/products/category/new','ProductCategoryController@store_product_category')->name('admin.products.category.new');
    Route::post('/products/category/update','ProductCategoryController@update_product_category')->name('admin.products.category.update');
    Route::post('/products/category/delete/{id}','ProductCategoryController@delete_product_category')->name('admin.products.category.delete');
    Route::post('/products/category/lang','ProductCategoryController@category_by_language_slug')->name('admin.products.category.by.lang');
    Route::post('/products/category/bulk-action','ProductCategoryController@bulk_action')->name('admin.products.category.bulk.action');
    //coupon
    Route::get('/products/coupon','ProductCouponController@all_coupon')->name('admin.products.coupon.all');
    Route::post('/products/coupon/new','ProductCouponController@store_coupon')->name('admin.products.coupon.new');
    Route::post('/products/coupon/update','ProductCouponController@update_coupon')->name('admin.products.coupon.update');
    Route::post('/products/coupon/delete/{id}','ProductCouponController@delete_coupon')->name('admin.products.coupon.delete');
    Route::post('/products/coupon/bulk-action','ProductCouponController@bulk_action')->name('admin.products.coupon.bulk.action');
    //shipping
    Route::get('/products/shipping','ProductShippingController@all_shipping')->name('admin.products.shipping.all');
    Route::post('/products/shipping/new','ProductShippingController@store_all_shipping')->name('admin.products.shipping.new');
    Route::post('/products/shipping/update','ProductShippingController@update_shipping')->name('admin.products.shipping.update');
    Route::post('/products/shipping/delete/{id}','ProductShippingController@delete_shipping')->name('admin.products.shipping.delete');
    Route::post('/products/shipping/default/{id}','ProductShippingController@default_shipping')->name('admin.products.shipping.default');
    Route::post('/products/shipping/bulk-action','ProductShippingController@bulk_action')->name('admin.products.shipping.bulk.action');

    //pending order reminder
    Route::post('/products/order-reminder','ProductsController@order_reminder_mail')->name('admin.product.order.reminder.mail');
});


//home variant
Route::prefix('admin-home')->middleware(['admin_permission:home_variant'])->group(function (){
    //home page variant select
    Route::get('/home-variant',"AdminDashboardController@home_variant")->name('admin.home.variant');
    Route::post('/home-variant',"AdminDashboardController@update_home_variant");
});

//languages
Route::prefix('admin-home')->middleware(['admin_permission:languages'])->group(function (){
    //language
    Route::get('/languages','LanguageController@index')->name('admin.languages');
    Route::get('/languages/words/edit/{id}','LanguageController@edit_words')->name('admin.languages.words.edit');
    Route::post('/languages/words/update/{id}','LanguageController@update_words')->name('admin.languages.words.update');
    Route::post('/languages/new','LanguageController@store')->name('admin.languages.new');
    Route::post('/languages/update','LanguageController@update')->name('admin.languages.update');
    Route::post('/languages/delete/{id}','LanguageController@delete')->name('admin.languages.delete');
    Route::post('/languages/default/{id}','LanguageController@make_default')->name('admin.languages.default');
    Route::post('/languages/clone','LanguageController@clone_languages')->name('admin.languages.clone');
    Route::post('/languages/add-new-string','LanguageController@add_new_string')->name('admin.languages.add.string');
});

//menu manage
Route::prefix('admin-home')->middleware(['admin_permission:menus_manage'])->group(function (){
    //menu manage
    Route::get('/menu','MenuController@index')->name('admin.menu');
    Route::post('/new-menu','MenuController@store_new_menu')->name('admin.menu.new');
    Route::get('/menu-edit/{id}','MenuController@edit_menu')->name('admin.menu.edit');
    Route::post('/menu-update/{id}','MenuController@update_menu')->name('admin.menu.update');
    Route::post('/menu-delete/{id}','MenuController@delete_menu')->name('admin.menu.delete');
    Route::post('/menu-default/{id}','MenuController@set_default_menu')->name('admin.menu.default');
    Route::post('/mega-menu','MenuController@mega_menu_item_select_markup')->name('admin.mega.menu.item.select.markup');
});

//navbar settings
Route::prefix('admin-home')->middleware(['admin_permission:navbar_settings'])->group(function (){
    //navbar settings
    Route::get('/navbar-settings',"AdminDashboardController@navbar_settings")->name('admin.navbar.settings');
    Route::post('/navbar-settings',"AdminDashboardController@update_navbar_settings");
});

//newsletter manage
Route::prefix('admin-home')->middleware(['admin_permission:newsletter_manage'])->group(function (){

    //newsletter
    Route::get('/newsletter-management','NewsletterController@newsletter_management')->name('admin.newsletter.management');
    Route::get('/newsletter','NewsletterController@index')->name('admin.newsletter');
    Route::post('/newsletter/delete/{id}','NewsletterController@delete')->name('admin.newsletter.delete');
    Route::post('/newsletter/single','NewsletterController@send_mail')->name('admin.newsletter.single.mail');
    Route::get('/newsletter/all','NewsletterController@send_mail_all_index')->name('admin.newsletter.mail');
    Route::post('/newsletter/all','NewsletterController@send_mail_all');
    Route::post('/newsletter/new','NewsletterController@add_new_sub')->name('admin.newsletter.new.add');
    Route::post('/newsletter/bulk-action','NewsletterController@bulk_action')->name('admin.newsletter.bulk.action');
});

//pages
Route::prefix('admin-home')->middleware(['admin_permission:pages_manage'])->group(function (){
    //pages
    Route::get('/page','PagesController@index')->name('admin.page');
    Route::get('/new-page','PagesController@new_page')->name('admin.page.new');
    Route::post('/new-page','PagesController@store_new_page');
    Route::get('/page-edit/{id}','PagesController@edit_page')->name('admin.page.edit');
    Route::post('/page-update/{id}','PagesController@update_page')->name('admin.page.update');
    Route::post('/page-delete/{id}','PagesController@delete_page')->name('admin.page.delete');
});

//price plan
Route::prefix('admin-home')->middleware(['admin_permission:price_plan'])->group(function (){
    //price plan
    Route::get('/price-plan-management','PricePlanController@price_plan_management')->name('admin.price.plan.management');
    Route::get('/price-plan','PricePlanController@index')->name('admin.price.plan');
    Route::post('/price-plan','PricePlanController@store');
    Route::post('/update-price-plan','PricePlanController@update')->name('admin.price.plan.update');
    Route::post('/delete-price-plan/{id}','PricePlanController@delete')->name('admin.price.plan.delete');
    Route::post('/price-plan/bulk-action','PricePlanController@bulk_action')->name('admin.price.plan.bulk.action');
    // price plan page
    Route::get('/price-plan-page/settings','PricePlanPageController@price_plan_page_settings')->name('admin.price.plan.page.settings');
    Route::post('/price-plan-page/settings','PricePlanPageController@update_price_plan_page_settings');
});

//services
Route::prefix('admin-home')->middleware(['admin_permission:services'])->group(function (){
    Route::get('/services-management','ServiceController@services_management')->name('admin.services.management');
    //services
    Route::get('/services','ServiceController@index')->name('admin.services');
    Route::get('/services/new','ServiceController@new')->name('admin.services.new');
    Route::post('/services/new','ServiceController@store');
    Route::post('/services-cat-by-slug','ServiceController@category_by_slug')->name('admin.service.category.by.slug');
    Route::post('/update-services','ServiceController@update')->name('admin.services.update');
    Route::post('/services/bulk-action','ServiceController@bulk_action')->name('admin.service.bulk.action');
    Route::get('/services/edit/{id}','ServiceController@edit')->name('admin.services.edit');
    Route::post('/delete-services/{id}','ServiceController@delete')->name('admin.services.delete');
    Route::post('/services/clone','ServiceController@clone')->name('admin.services.clone');

    Route::get('/services/single-page-settings','ServiceController@single_page_settings')->name('admin.services.single.page.settings');
    Route::post('/services/single-page-settings','ServiceController@update_single_page_settings');

    Route::get('/services/category','ServiceController@category_index')->name('admin.service.category');
    Route::post('/services/category','ServiceController@category_store');
    Route::post('/update-services-category','ServiceController@category_update')->name('admin.service.category.update');
    Route::post('/delete-services-category/{id}','ServiceController@category_delete')->name('admin.service.category.delete');
    Route::post('/services-category/bulk-action','ServiceController@category_bulk_action')->name('admin.service.category.bulk.action');
});
//team member
Route::prefix('admin-home')->middleware(['admin_permission:team_members'])->group(function (){
    //team member
    Route::get('/team-member','TeamMemberController@index')->name('admin.team.member');
    Route::post('/team-member','TeamMemberController@store');
    Route::post('/update-team-member','TeamMemberController@update')->name('admin.team.member.update');
    Route::post('/delete-team-member/{id}','TeamMemberController@delete')->name('admin.team.member.delete');
    Route::post('/team-member/bulk-action','TeamMemberController@bulk_action')->name('admin.team.member.bulk.action');
});

//testimonial
Route::prefix('admin-home')->middleware(['admin_permission:testimonial'])->group(function (){
    //testimonial
    Route::get('/testimonial','TestimonialController@index')->name('admin.testimonial');
    Route::post('/testimonial','TestimonialController@store');
    Route::post('/update-testimonial','TestimonialController@update')->name('admin.testimonial.update');
    Route::post('/delete-testimonial/{id}','TestimonialController@delete')->name('admin.testimonial.delete');
    Route::post('/testimonial/bulk-action','TestimonialController@bulk_action')->name('admin.testimonial.bulk.action');
});

//top bar settings
Route::prefix('admin-home')->middleware(['admin_permission:top_bar_settings'])->group(function (){
    //topbar
    Route::get('/topbar','TopBarController@index')->name('admin.topbar');
    Route::post('/topbar/new-support-info','TopBarController@new_support_info')->name('admin.new.support.info');
    Route::post('/topbar/update-support-info','TopBarController@update_support_info')->name('admin.update.support.info');
    Route::post('/topbar/delete-support-info/{id}','TopBarController@delete_support_info')->name('admin.delete.support.info');
    Route::post('/topbar/new-social-item','TopBarController@new_social_item')->name('admin.new.social.item');
    Route::post('/topbar/update-social-item','TopBarController@update_social_item')->name('admin.update.social.item');
    Route::post('/topbar/delete-social-item/{id}','TopBarController@delete_social_item')->name('admin.delete.social.item');
    Route::post('/topbar/top-menu','TopBarController@update_top_menu')->name('admin.top.right.menu');
    Route::post('/topbar/top-button','TopBarController@update_top_button')->name('admin.top.button');
    Route::post('/topbar/top-menu-by-slug','TopBarController@top_menu')->name('admin.topbar.menu.by.slug');
});

//works
Route::prefix('admin-home')->middleware(['admin_permission:works'])->group(function (){
    Route::get('/works-management','WorksController@works_management')->name('admin.works.management');
    //works
    Route::get('/works','WorksController@index')->name('admin.work');
    Route::get('/works/new','WorksController@new_work')->name('admin.work.new');
    Route::post('/works/new','WorksController@store');
    Route::get('/works/edit/{id}','WorksController@edit')->name('admin.work.edit');
    Route::post('/works/clone','WorksController@clone')->name('admin.work.clone');
    Route::post('/works/update','WorksController@update')->name('admin.work.update');
    Route::post('/works/delete/{id}','WorksController@delete')->name('admin.work.delete');
    Route::post('/works-cat-by-slug','WorksController@category_by_slug')->name('admin.work.category.by.slug');
    Route::post('/works/bulk-action','WorksController@bulk_action')->name('admin.work.bulk.action');
    Route::post('/works/category/bulk-action','WorksController@category_bulk_action')->name('admin.work.category.bulk.action');

    Route::get('/works/category','WorksController@category_index')->name('admin.work.category');
    Route::post('/works/category','WorksController@category_store');
    Route::post('/update-works-category','WorksController@category_update')->name('admin.work.category.update');
    Route::post('/delete-works-category/{id}','WorksController@category_delete')->name('admin.work.category.delete');
    //work page
    Route::get('/works/work-page-settings','WorkPageController@work_page_settings')->name('admin.work.page.settings');
    Route::post('/works/work-page-settings','WorkPageController@update_work_page_settings');

    Route::get('/works/single-page-settings','WorkPageController@work_single_page_settings')->name('admin.work.single.page.settings');
    Route::post('/works/single-page-settings','WorkPageController@update_work_single_page_settings');
});

//gigs manage
Route::prefix('admin-home')->middleware(['admin_permission:gigs_manage'])->group(function (){

    Route::get('/gigs-management','GigsController@gigs_management')->name('admin.gigs.management');
    //gigs page
    Route::get('/gigs/all','GigsController@index')->name('admin.gigs.all');
    Route::get('/gigs/new','GigsController@new')->name('admin.gigs.new');
    Route::post('/gigs/new','GigsController@store');
    Route::get('gigs/edit/{id}','GigsController@edit')->name('admin.gigs.edit');
    Route::post('gigs/update','GigsController@update')->name('admin.gigs.update');
    Route::post('gigs/delete/{id}','GigsController@delete')->name('admin.gigs.delete');
    Route::post('gigs/bulk-action','GigsController@bulk_action')->name('admin.gigs.bulk.action');
    Route::post('gigs/clone','GigsController@clone')->name('admin.gigs.clone');

    //gigs category
    Route::get('/gigs/category','GigsCategoryController@index')->name('admin.gigs.category');
    Route::post('/gigs/category','GigsCategoryController@store');
    Route::post('/gigs/category/update','GigsCategoryController@update')->name('admin.gigs.category.update');
    Route::post('/gigs/category/delete/{id}','GigsCategoryController@delete')->name('admin.gigs.category.delete');
    Route::post('/gigs/category/bulk-action','GigsCategoryController@bulk_action')->name('admin.gigs.category.bulk.action');
    Route::post('/gigs/category/lang','GigsCategoryController@get_cat_by_lang')->name('admin.gigs.category.lang.cat');

    //gig page settings
    Route::get('/gigs/single-page','GigsController@gig_single_page_index')->name('admin.gigs.single.page.settings');
    Route::post('/gigs/single-page','GigsController@update_gig_single_page_index');
    Route::get('/gigs/page','GigsController@gig_page_index')->name('admin.gigs.page.settings');
    Route::post('/gigs/page','GigsController@update_gig_page_index');
    //
    Route::get('/gigs/success-page','GigsController@gig_order_success_page_index')->name('admin.gigs.success.page.settings');
    Route::post('/gigs/success-page','GigsController@update_gig_order_success_page_index');
    Route::get('/gigs/cancel-page','GigsController@gig_order_cancel_page_index')->name('admin.gigs.cancel.page.settings');
    Route::post('/gigs/cancel-page','GigsController@update_gig_order_cancel_page_index');

    //gig order
    Route::get('/gigs/orders','GigOrderManageController@index')->name('admin.gigs.orders');
    Route::get('/gigs/orders-message/{id}','GigOrderManageController@gig_message')->name('admin.gigs.orders.message');
    Route::post('/gigs/orders-message','GigOrderManageController@store_gig_message')->name('admin.gigs.orders.message.store');
    Route::post('/gigs/orders/delete/{id}','GigOrderManageController@delete_gig_order')->name('admin.gigs.orders.delete');
    Route::post('/gigs/payment-approve/{id}','GigOrderManageController@payment_approve')->name('admin.gig.payment.approve');
    Route::post('/gigs/order-status-change','GigOrderManageController@order_status_change')->name('admin.gig.order.status.change');
    Route::post('/gigs/order-status-change','GigOrderManageController@order_status_change')->name('admin.gig.order.status.change');
    Route::post('/gigs/order-message','GigOrderManageController@order_mail')->name('admin.gig.order.mail');
    Route::post('/gigs/order-reminder','GigOrderManageController@order_reminder_mail')->name('admin.gig.order.reminder.mail');
    Route::post('/gigs/order/bulk-action','GigOrderManageController@bulk_action')->name('admin.gig.order.bulk.action');
    Route::post('/gig-order-cancel','UserDashboardController@gig_order_cancel')->name('frontend.gig.order.cancel');

});


//image gallery page manage
Route::prefix('admin-home')->middleware(['admin_permission:gallery_manage'])->group(function (){

    //image gallery page
    Route::get('/gallery-management','ImageGalleryController@gallery_management')->name('admin.gallery.management');
    Route::get('/gallery/all','ImageGalleryController@index')->name('admin.gallery.all');
    Route::post('/gallery/new','ImageGalleryController@store')->name('admin.gallery.new');
    Route::post('gallery/update','ImageGalleryController@update')->name('admin.gallery.update');
    Route::post('gallery/delete/{id}','ImageGalleryController@delete')->name('admin.gallery.delete');
    Route::post('gallery/bulk-action','ImageGalleryController@bulk_action')->name('admin.gallery.bulk.action');

    //image gallery category
    Route::get('/gallery/category','ImageGalleryCategoryController@index')->name('admin.gallery.category');
    Route::post('/gallery/category','ImageGalleryCategoryController@store');
    Route::post('/gallery/category/update','ImageGalleryCategoryController@update')->name('admin.gallery.category.update');
    Route::post('/gallery/category/delete/{id}','ImageGalleryCategoryController@delete')->name('admin.gallery.category.delete');
    Route::post('/gallery/category/bulk-action','ImageGalleryCategoryController@bulk_action')->name('admin.gallery.category.bulk.action');
    Route::post('/gallery/category/lang','ImageGalleryCategoryController@get_cat_by_lang')->name('admin.gallery.category.lang.cat');
});

Route::prefix('admin-home')->middleware(['admin_permission:site_maintenance_mode'])->group(function (){
    // maintains page
    Route::get('/maintains-page/settings','MaintainsPageController@maintains_page_settings')->name('admin.maintains.page.settings');
    Route::post('/maintains-page/settings','MaintainsPageController@update_maintains_page_settings');
});
Route::prefix('admin-home')->group(function (){

    Route::get('/', 'AdminDashboardController@adminIndex')->name('admin.home');
    //admin settings
    Route::get('/settings','AdminDashboardController@admin_settings')->name('admin.profile.settings');
    Route::get('/profile-update','AdminDashboardController@admin_profile')->name('admin.profile.update');
    Route::post('/profile-update','AdminDashboardController@admin_profile_update');
    Route::get('/password-change','AdminDashboardController@admin_password')->name('admin.password.change');
    Route::post('/password-change','AdminDashboardController@admin_password_chagne');
    Route::post('/set-static-option','AdminDashboardController@admin_set_static_option');
    Route::post('/get-static-option','AdminDashboardController@admin_get_static_option');
    Route::post('/update-static-option','AdminDashboardController@admin_update_static_option');
});
