<?php

namespace App\Http\Controllers;

use App\Admin;
use App\ContactInfoItem;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\Events;
use App\EventsCategory;
use App\Faq;
use App\Feedback;
use App\Gig;
use App\GigMessage;
use App\GigOrder;
use App\GigsCategory;
use App\ImageGallery;
use App\ImageGalleryCategory;
use App\Jobs;
use App\JobsCategory;
use App\KnowAbout;
use App\Knowledgebase;
use App\KnowledgebaseTopic;
use App\Language;
use App\Mail\AdminResetEmail;
use App\Mail\CallBack;
use App\Mail\ContactMessage;
use App\Mail\PlaceOrder;
use App\Mail\RequestQuote;
use App\Menu;
use App\Newsletter;
use App\Order;
use App\Page;
use App\PaymentLogs;
use App\ProductCategory;
use App\ProductOrder;
use App\ProductRatings;
use App\Products;
use App\ProductShipping;
use App\Quote;
use App\ServiceCategory;
use App\Services;
use App\Blog;
use App\BlogCategory;
use App\Brand;
use App\HeaderSlider;
use App\KeyFeatures;
use App\PricePlan;
use App\TeamMember;
use App\User;
use App\Counterup;
use App\Testimonial;
use App\Works;
use App\WorksCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class FrontendController extends Controller
{

    public function index()
    {

        if (!empty(get_static_option('site_maintenance_mode')) && !Auth::guard('admin')->check()) {
            return view('frontend.maintain');
        }
        $header_variant = get_static_option('home_page_variant');
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_header_slider = HeaderSlider::where('lang', $lang)->get();
        $all_counterup = Counterup::where('lang', $lang)->get();
        $all_key_features = KeyFeatures::where('lang', $lang)->get();
        $all_service = Services::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_service_area_items'))->get();
        $all_testimonial = Testimonial::where('lang', $lang)->get();
        $all_price_plan = PricePlan::where(['lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_price_plan_section_items'))->get();;
        $all_team_members = TeamMember::where('lang', $lang)->orderBy('id', 'desc')->take(get_static_option('home_page_09_team_member_area_items'))->get();;
        $all_brand_logo = Brand::all();
        $all_work = Works::where('lang', $lang)->get();
        $all_work_category = WorksCategory::where(['status' => 'publish', 'lang' => $lang])->get();
        $all_blog = Blog::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(6)->get();

        $return_data = [
            'all_header_slider' => $all_header_slider,
            'all_counterup' => $all_counterup,
            'all_key_features' => $all_key_features,
            'all_service' => $all_service,
            'all_testimonial' => $all_testimonial,
            'all_blog' => $all_blog,
            'all_price_plan' => $all_price_plan,
            'all_team_members' => $all_team_members,
            'all_brand_logo' => $all_brand_logo,
            'all_work' => $all_work,
            'all_work_category' => $all_work_category,
        ];

        if ($header_variant == '03' || $header_variant == '05') {
            //home page 03
            $all_faq = Faq::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_faq_area_items'))->get();
            $return_data['all_faq'] = $all_faq;
        }

        if ($header_variant == '10') {
            //jobs homepage specials
            $jobs_category = JobsCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $jobs_featured = Jobs::where(['status' => 'publish', 'lang' => $lang, 'is_featured' => 'on'])->take(get_static_option('home_page_10_featured_job_area_items'))->get();
            $jobs_latest = Jobs::where(['status' => 'publish', 'lang' => $lang])->take(get_static_option('home_page_10_latest_job_area_items'))->get();

            $return_data['jobs_category'] = $jobs_category;
            $return_data['jobs_featured'] = $jobs_featured;
            $return_data['jobs_latest'] = $jobs_latest;
        }

        if ($header_variant == '05') {
            //knowledgeable home page specials
            $popular_article = Knowledgebase::where(['status' => 'publish', 'lang' => $lang])->get()->groupBy('topic_id');
            $return_data['popular_article'] = $popular_article;
        }


        if ($header_variant == '09') {
            //donation
            $recent_causes = Donation::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_09_recent_cause_items'))->get();
            $image_gallery = ImageGallery::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_09_our_gallery_items'))->get();
            $all_gallery_cat = [];
            foreach ($image_gallery as $image) {
                array_push($all_gallery_cat, $image->category_id);
            }
            $all_image_category = ImageGalleryCategory::find($all_gallery_cat);

            $return_data['recent_causes'] = $recent_causes;
            $return_data['image_gallery'] = $image_gallery;
            $return_data['all_image_category'] = $all_image_category;
        }

        if ($header_variant == '06') {
            //service
            $all_gig_category = GigsCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $all_gigs = Gig::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_06_our_service_area_items'))->get();

            $return_data['all_gig_category'] = $all_gig_category;
            $return_data['all_gigs'] = $all_gigs;
        }

        if ($header_variant == '07' || $header_variant == '09') {
            //event
            $all_events = Events::where(['status' => 'publish', 'lang' => $lang])->get(); // this is need for event and charity home page
            $return_data['all_events'] = $all_events;
        }
        if ($header_variant == '08') {
            //product
            $all_products_category = ProductCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $all_featured_products = Products::find(unserialize(get_static_option('home_page_08_' . $lang . '_featured_product_id')));
            $all_latest_products = Products::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_08_latest_product_area_items'))->get();
            $all_product_cat = [];
            foreach ($all_latest_products as $image) {
                array_push($all_product_cat, $image->category_id);
            }
            $all_product_filter_category = ProductCategory::find($all_product_cat);

            $return_data['all_products_category'] = $all_products_category;
            $return_data['all_featured_products'] = !empty($all_featured_products) ? $all_featured_products : [];
            $return_data['all_latest_products'] = $all_latest_products;
            $return_data['all_product_filter_category'] = $all_product_filter_category;
        }


        $gwm_variants = ['gwm-corporate', 'gwm-industrial', 'gwm-minimalist'];
        if (in_array($header_variant, $gwm_variants)) {
            return view('frontend.frontend-home-gwm')->with($return_data);
        }

        return view('frontend.frontend-home')->with($return_data);
    }

    public function home_page_change($id)
    {
        $header_variant = $id;
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_header_slider = HeaderSlider::where('lang', $lang)->get();
        $all_counterup = Counterup::where('lang', $lang)->get();
        $all_key_features = KeyFeatures::where('lang', $lang)->get();
        $all_service = Services::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_service_area_items'))->get();
        $all_testimonial = Testimonial::where('lang', $lang)->get();
        $all_price_plan = PricePlan::where(['lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_price_plan_section_items'))->get();;
        $all_team_members = TeamMember::where('lang', $lang)->orderBy('id', 'desc')->take(get_static_option('home_page_09_team_member_area_items'))->get();;
        $all_brand_logo = Brand::all();
        $all_work = Works::where('lang', $lang)->get();
        $all_work_category = WorksCategory::where(['status' => 'publish', 'lang' => $lang])->get();
        $all_blog = Blog::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(6)->get();

        $return_data = [
            'home_page' => $id,
            'all_header_slider' => $all_header_slider,
            'all_counterup' => $all_counterup,
            'all_key_features' => $all_key_features,
            'all_service' => $all_service,
            'all_testimonial' => $all_testimonial,
            'all_blog' => $all_blog,
            'all_price_plan' => $all_price_plan,
            'all_team_members' => $all_team_members,
            'all_brand_logo' => $all_brand_logo,
            'all_work' => $all_work,
            'all_work_category' => $all_work_category,
        ];

        if ($header_variant == '03' || $header_variant == '05') {
            //home page 03
            $all_faq = Faq::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->take(get_static_option('home_page_01_faq_area_items'))->get();
            $return_data['all_faq'] = $all_faq;
        }

        if ($header_variant == '10') {
            //jobs homepage specials
            $jobs_category = JobsCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $jobs_featured = Jobs::where(['status' => 'publish', 'lang' => $lang, 'is_featured' => 'on'])->take(get_static_option('home_page_10_featured_job_area_items'))->get();
            $jobs_latest = Jobs::where(['status' => 'publish', 'lang' => $lang])->take(get_static_option('home_page_10_latest_job_area_items'))->get();

            $return_data['jobs_category'] = $jobs_category;
            $return_data['jobs_featured'] = $jobs_featured;
            $return_data['jobs_latest'] = $jobs_latest;
        }

        if ($header_variant == '05') {
            //knowledgeable home page specials
            $popular_article = Knowledgebase::where(['status' => 'publish', 'lang' => $lang])->get()->groupBy('topic_id');
            $return_data['popular_article'] = $popular_article;
        }


        if ($header_variant == '09') {
            //donation
            $recent_causes = Donation::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_09_recent_cause_items'))->get();
            $image_gallery = ImageGallery::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_09_our_gallery_items'))->get();
            $all_gallery_cat = [];
            foreach ($image_gallery as $image) {
                array_push($all_gallery_cat, $image->category_id);
            }
            $all_image_category = ImageGalleryCategory::find($all_gallery_cat);

            $return_data['recent_causes'] = $recent_causes;
            $return_data['image_gallery'] = $image_gallery;
            $return_data['all_image_category'] = $all_image_category;
        }

        if ($header_variant == '06') {
            //service
            $all_gig_category = GigsCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $all_gigs = Gig::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_06_our_service_area_items'))->get();

            $return_data['all_gig_category'] = $all_gig_category;
            $return_data['all_gigs'] = $all_gigs;
        }

        if ($header_variant == '07' || $header_variant == '09') {
            //event
            $all_events = Events::where(['status' => 'publish', 'lang' => $lang])->get(); // this is need for event and charity home page
            $return_data['all_events'] = $all_events;
        }
        if ($header_variant == '08') {
            //product
            $all_products_category = ProductCategory::where(['status' => 'publish', 'lang' => $lang])->get();
            $all_featured_products = Products::find(unserialize(get_static_option('home_page_08_' . $lang . '_featured_product_id')));
            $all_latest_products = Products::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'DESC')->take(get_static_option('home_page_08_latest_product_area_items'))->get();
            $all_product_cat = [];
            foreach ($all_latest_products as $image) {
                array_push($all_product_cat, $image->category_id);
            }
            $all_product_filter_category = ProductCategory::find($all_product_cat);

            $return_data['all_products_category'] = $all_products_category;
            $return_data['all_featured_products'] = !empty($all_featured_products) ? $all_featured_products : [];
            $return_data['all_latest_products'] = $all_latest_products;
            $return_data['all_product_filter_category'] = $all_product_filter_category;
        }

        $gwm_variants = ['gwm-corporate', 'gwm-industrial', 'gwm-minimalist'];
        if (in_array($header_variant, $gwm_variants)) {
            return view('frontend.frontend-home-gwm')->with($return_data);
        }

        return view('frontend.frontend-home-demo')->with($return_data);
    }



    //gig page
    public function redirect_gig_order_page(Request $request)
    {
        $gig_details = Gig::find($request->gig_id);
        $index_id = $request->gig_select_plan_index;

        if (empty($gig_details) || is_null($index_id)) {
            return view('frontend.pages.404');;
        }

        $all_plan_title = !empty($gig_details->plan_title) ? unserialize($gig_details->plan_title) : [];
        $all_plan_price = !empty($gig_details->plan_price) ? unserialize($gig_details->plan_price) : [];
        $all_plan_features = !empty($gig_details->features) ? unserialize($gig_details->features) : [];
        $all_plan_revisions = !empty($gig_details->revisions) ? unserialize($gig_details->revisions) : [];
        $all_plan_delivery_time = !empty($gig_details->delivery_time) ? unserialize($gig_details->delivery_time) : [];
        $all_plan_description = !empty($gig_details->plan_description) ? unserialize($gig_details->plan_description) : [];

        $plan_details['title'] = $all_plan_title[$index_id];
        $plan_details['price'] = $all_plan_price[$index_id];
        $plan_details['features'] = $all_plan_features[$index_id];
        $plan_details['revisions'] = $all_plan_revisions[$index_id];
        $plan_details['delivery_time'] = $all_plan_delivery_time[$index_id];
        $plan_details['description'] = $all_plan_description[$index_id];
        return view('frontend.pages.gigs.gigs-order')->with(['gig_details' => $gig_details, 'plan_details' => $plan_details, 'index_id' => $index_id]);
    }


    public function gig_page(Request $request)
    {

        $lang = get_user_lang();
        $all_category = GigsCategory::where(['status' => 'publish', 'lang' => $lang])->get();

        $selected_category = $request->cat_id ? $request->cat_id : '';
        $search_term = $request->q ? $request->q : '';
        $selected_order = $request->orderby ? $request->orderby : 'default';

        $query = Gig::query();
        $query->where(['status' => 'publish', 'lang' => $lang]);


        if ($selected_category) {
            $query->where(['category_id' => $selected_category]);
        }

        if ($search_term) {
            $query->where('title', 'LIKE', '%' . $search_term . '%');
        }

        if ($selected_order == 'old') {
            $query->orderBy('id', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }

        $all_gigs = $query->paginate(get_static_option('gig_page_items'));

        return view('frontend.pages.gigs.gigs')->with([
            'all_gigs' => $all_gigs,
            'selected_order' => $selected_order,
            'search_term' => $search_term,
            'all_category' => $all_category,
            'selected_category' => $selected_category
        ]);
    }

    public function gig_single_page($slug)
    {

        $gig = Gig::where(['slug' => $slug])->first();
        if (empty($gig)) {
            return view('frontend.pages.404');
        }
        return view('frontend.pages.gigs.gig-single')->with([
            'gig' => $gig,
        ]);
    }

    public function category_wise_gig_page($id, $any)
    {
        $category_name = GigsCategory::find($id)->name;
        $gigs = Gig::where(['status' => 'publish', 'category_id' => $id])->orderBy('id', 'DESC')->paginate(9);

        if (empty($category_name)) {
            return view('frontend.pages.404');
        }
        return view('frontend.pages.gigs.gig-category')->with([
            'gigs' => $gigs,
            'category_name' => $category_name,
        ]);
    }

    public function gig_search_page(Request $request)
    {

        $search_term = $request->s;

        $all_gigs = Gig::where(['status' => 'publish', 'lang' => get_user_lang()])
            ->where('title', 'LIKE', '%' . $search_term . '%')
            ->paginate(get_static_option('gig_page_items'));


        return view('frontend.pages.gigs.gig-search')->with([
            'all_gigs' => $all_gigs,
            'search_term' => $search_term,
        ]);
    }

    public function gig_order_payment_success($id)
    {
        $gig_order_details = GigOrder::find($id);
        if (empty($gig_order_details)) {
            return view('frontend.pages.404');
        }

        return view('frontend.pages.gigs.gigs-success')->with(['gig_order_details' => $gig_order_details]);
    }

    public function gig_order_payment_cancel($id)
    {
        $gig_order_details = GigOrder::find($id);
        if (empty($gig_order_details)) {
            return view('frontend.pages.404');
        }

        return view('frontend.pages.gigs.gigs-cancel')->with(['gig_order_details' => $gig_order_details]);
    }

    //products
    public function products(Request $request)
    {
        $default_lang = Language::where('default', 1)->first();
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : $default_lang->slug;
        $selected_rating = $request->rating ? $request->rating : '';
        $query = Products::query();
        if ($selected_rating) {
            $product_ids = [];
            $all_products_id = ProductRatings::where('ratings', '>=', $selected_rating)->get('product_id');
            foreach ($all_products_id as $product_id) {
                array_push($product_ids, $product_id->product_id);
            }
            $query->find(array_unique($product_ids));
        }
        $query->where(['status' => 'publish', 'lang' => $lang]);
        $maximum_available_price = Products::max('sale_price');
        $all_category = ProductCategory::where(['status' => 'publish', 'lang' => $lang])->get();

        $selected_category = $request->cat_id ? $request->cat_id : '';
        $search_term = $request->q ? $request->q : '';
        $selected_order = $request->orderby ? $request->orderby : 'default';

        if ($selected_category) {
            $query->where(['category_id' => $selected_category]);
        }

        $min_price = $request->min_price ? $request->min_price : 0;
        $max_price = $request->max_price ? $request->max_price : $maximum_available_price;
        if ($min_price) {
            $query->where('sale_price', '>=', $min_price);
        }
        if ($max_price) {
            $query->where('sale_price', '<=', $max_price);
        }
        if ($search_term) {
            $query->where('title', 'LIKE', '%' . $search_term . '%');
        }
        if ($selected_order == 'old') {
            $query->orderBy('id', 'ASC');
        } elseif ($selected_order == 'high_low') {
            $query->orderBy('sale_price', 'DESC');
        } elseif ($selected_order == 'low_high') {
            $query->orderBy('sale_price', 'ASC');
        } else {
            $query->orderBy('id', 'DESC');
        }
        $all_products = $query->paginate(get_static_option('product_post_items'));

        return view('frontend.pages.products.products')->with([
            'all_products' => $all_products,
            'all_category' => $all_category,
            'search_term' => $search_term,
            'selected_rating' => $selected_rating,
            'selected_order' => $selected_order,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'selected_category' => $selected_category,
            'maximum_available_price' => $maximum_available_price
        ]);
    }

    public function product_single($slug)
    {
        $product = Products::where('slug', $slug)->first();
        if (empty($product)) {
            return view('frontend.pages.404');
        }
        $related_products = Products::where(['category_id' => $product->category_id, 'status' => 'publish'])->get()->except($product->id)->take(4);
        $average_ratings = ProductRatings::Where('product_id', $product->id)->pluck('ratings')->avg();

        return view('frontend.pages.products.product-single')->with(
            [
                'product' => $product,
                'related_products' => $related_products,
                'average_ratings' => $average_ratings
            ]);
    }

    public function products_category($id, $any)
    {
        $all_products = Products::where(['status' => 'publish', 'category_id' => $id])->orderBy('id', 'desc')->paginate(get_static_option('product_post_items'));
        $category_name = ProductCategory::find($id)->title;
        return view('frontend.pages.products.product-category')->with([
            'all_products' => $all_products,
            'category_name' => $category_name,
        ]);
    }

    public function products_cart()
    {
        $all_cart_items = get_cart_items();
        $all_shipping = ProductShipping::where(['lang' => get_default_language(), 'status' => 'publish'])->orderBy('order', 'ASC')->get();
        return view('frontend.pages.products.product-cart')->with([
            'all_cart_items' => $all_cart_items,
            'all_shipping' => $all_shipping,
        ]);
    }

    public function product_order_view($id)
    {
        $product_order_details = ProductOrder::find($id);
        if (empty($product_order_details)) {
            return redirect_404_page();
        }

        return view('frontend.pages.products.view-order')->with(['order_details' => $product_order_details]);
    }

    public function product_checkout()
    {
        return view('frontend.pages.products.product-checkout');
    }

    public function product_payment_success($id)
    {
        $order_details = ProductOrder::find($id);
        return view('frontend.pages.products.product-success')->with(['order_details' => $order_details]);
    }

    public function product_payment_cancel($id)
    {
        $order_details = ProductOrder::find($id);
        return view('frontend.pages.products.product-cancel')->with(['order_details' => $order_details]);
    }

    public function product_ratings(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'ratings' => 'required',
            'ratings_message' => 'nullable|string'
        ]);

        $existing_rating = ProductRatings::where(['product_id' => $request->product_id, 'user_id' => auth()->user()->id])->first();
        if (!empty($existing_rating)) {
            return redirect()->back()->with(['msg' => __('You have already rated this product'), 'type' => 'danger']);
        }
        ProductRatings::create([
            'ratings' => $request->ratings,
            'message' => $request->ratings_message,
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with(['msg' => __('Thanks for your rating'), 'type' => 'success']);
    }

    public function donation_payment_success($id)
    {
        $donation_logs = DonationLogs::find($id);
        return view('frontend.pages.donations.donation-success')->with(['donation_logs' => $donation_logs]);
    }

    public function donation_payment_cancel($id)
    {
        $donation_logs = DonationLogs::find($id);
        return view('frontend.pages.donations.donation-cancel')->with(['donation_logs' => $donation_logs]);
    }

    public function blog_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_recent_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->paginate(get_static_option('blog_page_item'));
        $all_category = BlogCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->get();
        return view('frontend.pages.blogs.blog')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }

    public function category_wise_blog_page($id)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_blogs = Blog::where(['blog_categories_id' => $id, 'lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->paginate(get_static_option('blog_page_item'));
        if (empty($all_blogs)) {
            return view('frontend.pages.404');
        }
        $all_recent_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_category = BlogCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->get();
        $category_name = BlogCategory::where(['id' => $id, 'status' => 'publish'])->first()->name;
        return view('frontend.pages.blogs.blog-category')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'category_name' => $category_name,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }

    public function tags_wise_blog_page($tag)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->Where('tags', 'LIKE', '%' . $tag . '%')
            ->orderBy('id', 'desc')->paginate(get_static_option('blog_page_item'));
        $all_recent_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_category = BlogCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->get();
        return view('frontend.pages.blogs.blog-tags')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'tag_name' => $tag,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }

    public function blog_search_page(Request $request)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_recent_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_category = BlogCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->get();
        $all_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->Where('title', 'LIKE', '%' . $request->search . '%')
            ->orderBy('id', 'desc')->paginate(get_static_option('blog_page_item'));

        return view('frontend.pages.blogs.blog-search')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'search_term' => $request->search,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }

    public function blog_single_page($slug)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $blog_post = Blog::where('slug', $slug)->first();
        if (empty($blog_post)) {
            return view('frontend.pages.404');
        }
        $all_recent_blogs = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->paginate(get_static_option('blog_page_recent_post_widget_item'));
        $all_category = BlogCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('id', 'desc')->get();

        $all_related_blog = Blog::where(['lang' => $lang, 'status' => 'publish'])->Where('blog_categories_id', $blog_post->blog_categories_id)->orderBy('id', 'desc')->take(6)->get();

        return view('frontend.pages.blogs.blog-single')->with([
            'blog_post' => $blog_post,
            'all_categories' => $all_category,
            'all_recent_blogs' => $all_recent_blogs,
            'all_related_blog' => $all_related_blog,
        ]);
    }


    public function dynamic_single_page($id, $any)
    {
        $page_post = Page::where('id', $id)->first();
        return view('frontend.pages.dynamic-single')->with([
            'page_post' => $page_post
        ]);
    }

    public function showAdminForgetPasswordForm()
    {
        return view('auth.admin.forget-password');
    }

    public function sendAdminForgetPasswordMail(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string:max:191'
        ]);
        $user_info = Admin::where('username', $request->username)->orWhere('email', $request->username)->first();
        if (!empty($user_info)) {
            $token_id = Str::random(30);
            $existing_token = DB::table('password_resets')->where('email', $user_info->email)->delete();
            if (empty($existing_token)) {
                DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
            }
            $message = 'Here is you password reset link, If you did not request to reset your password just ignore this mail. <a class="btn" href="' . route('admin.reset.password', ['user' => $user_info->username, 'token' => $token_id]) . '">Click Reset Password</a>';
            $data = [
                'username' => $user_info->username,
                'message' => $message
            ];
            Mail::to($user_info->email)->send(new AdminResetEmail($data));

            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Your Username or Email Is Wrong!!!'),
            'type' => 'danger'
        ]);
    }

    public function showAdminResetPasswordForm($username, $token)
    {
        return view('auth.admin.reset-password')->with([
            'username' => $username,
            'token' => $token
        ]);
    }

    public function AdminResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user_info = Admin::where('username', $request->username)->first();
        $user = Admin::findOrFail($user_info->id);
        $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
        if (!empty($token_iinfo)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('admin.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }

    public function lang_change(Request $request)
    {
        session()->put('lang', $request->lang);
        return redirect()->route('homepage');
    }

    public function services_search(Request $request)
    {

        $search_term = $request->s;

        $all_services = Services::where(['status' => 'publish', 'lang' => get_user_lang()])
            ->where('title', 'LIKE', '%' . $search_term . '%')
            ->paginate(9);


        return view('frontend.pages.service.service-search')->with([
            'all_services' => $all_services,
            'search_term' => $search_term,
        ]);
    }
    
    public function services_single_page($slug)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $service_item = Services::where('slug', $slug)->first();
        if (empty($service_item)) {
            return view('frontend.pages.404');
        }
        $service_category = ServiceCategory::where(['status' => 'publish', 'lang' => $lang])->get();
        $recent_services = Services::where(['lang' => $lang, 'status' => 'publish'])->take(5)->get();

        return view('frontend.pages.service.service-single')->with([
            'service_item' => $service_item,
            'service_category' => $service_category,
            'recent_services' => $recent_services,
        ]);
    }

    public function category_wise_services_page($id, $any)
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $category_name = ServiceCategory::find($id)->name;
        $service_item = Services::where(['categories_id' => $id, 'lang' => $lang, 'status' => 'publish'])->paginate(6);
        return view('frontend.pages.service.services')->with(['service_items' => $service_item, 'category_name' => $category_name]);
    }

    public function work_single_page($slug)
    {
        $work_item = Works::where('slug', $slug)->first();
        if (empty($work_item)) {
            return view('frontend.pages.404');
        }
        $all_works = [];
        $all_related_works = [];
        if (!empty($work_item->categories_id)) {
            foreach ($work_item->categories_id as $cat) {
                $all_by_cat = Works::where(['lang' => get_user_lang()])->where('categories_id', 'LIKE', '%' . $work_item->$cat . '%')->take(6)->get();
                for ($i = 0; $i < count($all_by_cat); $i++) {
                    array_push($all_works, $all_by_cat[$i]);
                }
            }
            array_unique($all_works);
        }

        return view('frontend.pages.works.work-single')->with(['work_item' => $work_item, 'related_works' => $all_works]);
    }

    public function about_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_counterup = Counterup::where('lang', $lang)->get();
        $all_brand_logo = Brand::all();
        $all_team_members = TeamMember::where('lang', $lang)->orderBy('id', 'desc')->take(4)->get();
        $all_blog = Blog::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(9)->get();
        $all_testimonial = Testimonial::where('lang', $lang)->get();
        $all_know_about = KnowAbout::where('lang', $lang)->get();
        $all_service = Services::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->take(4)->get();

        return view('frontend.pages.about')->with([
            'all_counterup' => $all_counterup,
            'all_brand_logo' => $all_brand_logo,
            'all_team_members' => $all_team_members,
            'all_blog' => $all_blog,
            'all_testimonial' => $all_testimonial,
            'all_service' => $all_service,
            'all_know_about' => $all_know_about,
        ]);
    }

    public function service_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_services = Services::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->paginate(12);
        $all_price_plan = PricePlan::where('lang', $lang)->get();
        return view('frontend.pages.service.service')->with(['all_services' => $all_services, 'all_price_plan' => $all_price_plan]);
    }

    public function work_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_work = Works::where(['lang' => $lang, 'status' => 'publish'])->orderBy('id', 'desc')->paginate(get_static_option('work_page_items'));
        $all_contain_cat = [];
        foreach ($all_work as $work) {
            array_push($all_contain_cat, $work->categories_id);
        }
        $all_work_category = WorksCategory::find($all_contain_cat);

        return view('frontend.pages.works.work')->with(['all_work' => $all_work, 'all_work_category' => $all_work_category]);
    }

    public function team_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_team_members = TeamMember::where('lang', $lang)->orderBy('id', 'desc')->paginate(get_static_option('team_page_team_member_section_item'));

        return view('frontend.pages.team-page')->with(['all_team_members' => $all_team_members]);
    }

    public function faq_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_faq = Faq::where('lang', $lang)->get();
        $all_brand_logo = Brand::all();
        $all_testimonial = Testimonial::where('lang', $lang)->get();
        return view('frontend.pages.faq-page')->with([
            'all_brand_logo' => $all_brand_logo,
            'all_testimonial' => $all_testimonial,
            'all_faqs' => $all_faq
        ]);
    }

    public function contact_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $all_contact_info = ContactInfoItem::where('lang', $lang)->get();
        return view('frontend.pages.contact-page')->with([
            'all_contact_info' => $all_contact_info
        ]);
    }

    public function plan_order($id)
    {
        $order_details = PricePlan::find($id);
        return view('frontend.pages.order-page')->with([
            'order_details' => $order_details
        ]);
    }

    public function request_quote()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $contact_info = ContactInfoItem::where('lang', $lang)->get();
        return view('frontend.pages.quote-page')->with(['all_contact_info' => $contact_info]);
    }

    //donation

    public function donations()
    {
        $all_donations = Donation::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('id', 'desc')->paginate(get_static_option('donor_page_post_items'));
        return view('frontend.pages.donations.donation')->with([
            'all_donations' => $all_donations
        ]);
    }

    public function donations_single($slug)
    {
        $donation = Donation::where('slug', $slug)->first();
        if (empty($donation)) {
            return view('frontend.pages.404');
        }
        $all_donations = DonationLogs::where(['status' => 'complete', 'donation_id' => $donation->id])->orderBy('id', 'desc')->paginate(5);

        return view('frontend.pages.donations.donation-single')->with([
            'all_donations' => $all_donations,
            'donation' => $donation,
        ]);
    }


    public function category_wise_works_page($id)
    {

        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $category = WorksCategory::find($id);
        $all_works = Works::where(['lang' => $lang, 'status' => 'publish'])->where('categories_id', 'LIKE', '%' . $id . '%')->paginate(12);
        $category_name = $category->name;
        $all_category = WorksCategory::where('lang', $lang)->get();
        return view('frontend.pages.works.work-category')->with(['all_work' => $all_works, 'category_name' => $category_name, 'all_work_category' => $all_category]);

    }


    public function price_plan_page()
    {
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default', 1)->first()->slug;
        $paginate_items = !empty(get_static_option('price_plan_page_items')) ? get_static_option('price_plan_page_items') : 9;
        $all_price_plan = PricePlan::where(['lang' => $lang])->orderBy('id', 'desc')->paginate($paginate_items);;

        return view('frontend.pages.price-plan')->with(['all_price_plan' => $all_price_plan]);
    }

    public function order_confirm($id)
    {
        $order_details = Order::find($id);
        return view('frontend.payment.order-confirm')->with(['order_details' => $order_details]);
    }

    public function order_payment_success($id)
    {
        $order_details = Order::find($id);
        return view('frontend.payment.payment-success')->with(['order_details' => $order_details]);
    }

    public function order_payment_cancel($id)
    {
        $order_details = Order::find($id);
        return view('frontend.payment.payment-cancel')->with(['order_details' => $order_details]);
    }

    //jobs
    public function jobs()
    {
        $all_jobs = Jobs::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('id', 'desc')->paginate(get_static_option('site_job_post_items'));
        $all_job_category = JobsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        return view('frontend.pages.jobs.jobs')->with([
            'all_jobs' => $all_jobs,
            'all_job_category' => $all_job_category,
        ]);
    }

    public function jobs_category($id, $any)
    {

        $all_jobs = Jobs::where(['status' => 'publish', 'lang' => get_user_lang(), 'category_id' => $id])->orderBy('id', 'desc')->paginate(get_static_option('site_job_post_items'));
        $all_job_category = JobsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $category_name = JobsCategory::find($id)->title;
        return view('frontend.pages.jobs.jobs-category')->with([
            'all_jobs' => $all_jobs,
            'all_job_category' => $all_job_category,
            'category_name' => $category_name,
        ]);
    }

    public function jobs_search(Request $request)
    {
        $all_jobs = Jobs::where(['status' => 'publish', 'lang' => get_user_lang()])->where('title', 'LIKE', '%' . $request->search . '%')->paginate(get_static_option('site_job_post_items'));
        $all_job_category = JobsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $search_term = $request->search;

        return view('frontend.pages.jobs.jobs-search')->with([
            'all_jobs' => $all_jobs,
            'all_job_category' => $all_job_category,
            'search_term' => $search_term,
        ]);
    }

    public function jobs_apply($id)
    {
        $job = Jobs::find($id);
        return view('frontend.pages.jobs.jobs-apply')->with([
            'job' => $job
        ]);
    }

    public function jobs_single($slug)
    {
        $job = Jobs::where('slug', $slug)->first();
        if (empty($job)) {
            return view('frontend.pages.404');
        }
        $all_job_category = JobsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        return view('frontend.pages.jobs.jobs-single')->with([
            'job' => $job,
            'all_job_category' => $all_job_category
        ]);
    }

    //events
    public function events()
    {
        $all_events = Events::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('id', 'desc')->paginate(get_static_option('site_events_post_items'));
        $all_event_category = EventsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        return view('frontend.pages.events.event')->with([
            'all_events' => $all_events,
            'all_event_category' => $all_event_category,
        ]);
    }

    public function events_category($id, $any)
    {
        $all_events = Events::where(['status' => 'publish', 'lang' => get_user_lang(), 'category_id' => $id])->orderBy('id', 'desc')->paginate(get_static_option('site_events_post_items'));
        $all_events_category = EventsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $category_name = EventsCategory::find($id)->title;

        return view('frontend.pages.events.event-category')->with([
            'all_events' => $all_events,
            'all_events_category' => $all_events_category,
            'category_name' => $category_name,
        ]);
    }

    public function events_search(Request $request)
    {
        $all_events = Events::where(['status' => 'publish', 'lang' => get_user_lang()])->where('title', 'LIKE', '%' . $request->search . '%')->paginate(get_static_option('site_events_post_items'));
        $all_events_category = EventsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $search_term = $request->search;

        return view('frontend.pages.events.event-search')->with([
            'all_events' => $all_events,
            'all_event_category' => $all_events_category,
            'search_term' => $search_term,
        ]);
    }

    public function events_single($slug)
    {
        $event = Events::where('slug', $slug)->first();
        if (empty($event)) {
            return view('frontend.pages.404');
        }
        $all_events_category = EventsCategory::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        return view('frontend.pages.events.event-single')->with([
            'event' => $event,
            'all_event_category' => $all_events_category
        ]);
    }

    //knowledgebase
    public function knowledgebase()
    {
        $all_knowledgebase = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->paginate(get_static_option('site_knowledgebase_post_items'))->groupby('topic_id');
        $all_knowledgebase_category = KnowledgebaseTopic::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $popular_articles = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('views', 'desc')->get()->take(5);
        return view('frontend.pages.knowledgebase.knowledgebase')->with([
            'all_knowledgebase' => $all_knowledgebase,
            'popular_articles' => $popular_articles,
            'all_knowledgebase_category' => $all_knowledgebase_category,
        ]);
    }

    public function knowledgebase_category($id, $any)
    {

        $all_knowledgebase = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang(), 'topic_id' => $id])->orderBy('views', 'desc')->paginate(get_static_option('site_knowledgebase_post_items'));
        $all_knowledgebase_category = KnowledgebaseTopic::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $popular_articles = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('views', 'desc')->get()->take(5);
        $category_name = KnowledgebaseTopic::find($id)->title;
        return view('frontend.pages.knowledgebase.knowledgebase-category')->with([
            'all_knowledgebase' => $all_knowledgebase,
            'all_knowledgebase_category' => $all_knowledgebase_category,
            'popular_articles' => $popular_articles,
            'category_name' => $category_name,
        ]);
    }

    public function knowledgebase_search(Request $request)
    {

        $all_knowledgebase = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->where('title', 'LIKE', '%' . $request->search . '%')->orderBy('views', 'desc')->paginate(get_static_option('site_knowledgebase_post_items'));
        $all_knowledgebase_category = KnowledgebaseTopic::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $popular_articles = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('views', 'desc')->get()->take(5);
        $search_term = $request->search;

        return view('frontend.pages.knowledgebase.knowledgebase-search')->with([
            'all_knowledgebase' => $all_knowledgebase,
            'all_knowledgebase_category' => $all_knowledgebase_category,
            'popular_articles' => $popular_articles,
            'search_term' => $search_term,
        ]);
    }

    public function knowledgebase_single($slug)
    {
        $knowledgebase = Knowledgebase::where('slug', $slug)->first();
        if (empty($knowledgebase)) {
            return view('frontend.pages.404');
        }
        $old_views = is_null($knowledgebase->views) ? 0 : $knowledgebase->views + 1;
        Knowledgebase::where('slug', $slug)->update(['views' => $old_views]);

        $all_knowledgebase_category = KnowledgebaseTopic::where(['status' => 'publish', 'lang' => get_user_lang()])->get();
        $popular_articles = Knowledgebase::where(['status' => 'publish', 'lang' => get_user_lang()])->orderBy('views', 'desc')->get()->take(5);
        return view('frontend.pages.knowledgebase.knowledgebase-single')->with([
            'knowledgebase' => $knowledgebase,
            'all_knowledgebase_category' => $all_knowledgebase_category,
            'popular_articles' => $popular_articles,
        ]);
    }

    public function donor_list()
    {
        $all_donation_log = DonationLogs::where('status', 'complete')->get();
        return view('frontend.pages.donor-list')->with(['all_donation_log' => $all_donation_log]);
    }

    public function ajax_login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {
            return response()->json([
                'msg' => __('login Success Redirecting'),
                'type' => 'danger',
                'status' => 'valid'
            ]);
        }
        return response()->json([
            'msg' => __('Username Or Password Does Not Matched !!!'),
            'type' => 'danger',
            'status' => 'invalid'
        ]);
    }

    public function event_booking($id)
    {
        $event = Events::find($id);
        return view('frontend.pages.events.event-booking')->with([
            'event' => $event
        ]);
    }

    public function booking_confirm($id)
    {
        $attendance_details = EventAttendance::find($id);
        return view('frontend.payment.booking-confirm')->with(['attendance_details' => $attendance_details]);
    }

    public function event_payment_success($id)
    {
        $attendance_details = EventAttendance::find($id);
        return view('frontend.pages.events.attendance-success')->with(['attendance_details' => $attendance_details]);
    }

    public function event_payment_cancel($id)
    {
        $attendance_details = EventAttendance::find($id);
        return view('frontend.pages.events.attendance-cancel')->with(['attendance_details' => $attendance_details]);
    }

    public function redirect_404($object)
    {
        if (empty($object)) {
            return view('frontend.pages.404');
        }
    }

    public function image_gallery_page()
    {
        $all_images = ImageGallery::where(['lang' => get_user_lang(), 'status' => 'publish'])->get();
        $all_cats = [];

        foreach ($all_images as $image) {
            $cat = $image->category_id;
            array_push($all_cats, $cat);
        }
        $all_image_categories = ImageGalleryCategory::find($all_cats);
        return view('frontend.pages.image-gallery')->with(['categories' => $all_image_categories, 'gallery_images' => $all_images]);
    }

    public function testimonials()
    {
        $all_testimonial = Testimonial::where(['lang' => get_user_lang()])->get();

        return view('frontend.pages.testimonial')->with(['all_testimonial' => $all_testimonial]);
    }

    public function feedback_page(){
        return view('frontend.pages.feedback-page');
    }
    public function clients_feedback_page(){
        $all_feedback = Feedback::all();
        return view('frontend.pages.clients-feedback')->with(['all_feedback' => $all_feedback]);
    }



    public function showUserForgetPasswordForm()
    {
        return view('frontend.user.forget-password');
    }

    public function sendUserForgetPasswordMail(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string:max:191'
        ]);
        $user_info = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if (!empty($user_info)) {
            $token_id = Str::random(30);
            $existing_token = DB::table('password_resets')->where('email', $user_info->email)->delete();
            if (empty($existing_token)) {
                DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
            }
            $message = __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') . ' <a class="btn" href="' . route('user.reset.password', ['user' => $user_info->username, 'token' => $token_id]) . '">' . __('Click Reset Password') . '</a>';
            $data = [
                'username' => $user_info->username,
                'message' => $message
            ];
            Mail::to($user_info->email)->send(new AdminResetEmail($data));

            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Your Username or Email Is Wrong!!!'),
            'type' => 'danger'
        ]);
    }

    public function showUserResetPasswordForm($username, $token)
    {
        return view('frontend.user.reset-password')->with([
            'username' => $username,
            'token' => $token
        ]);
    }

    public function UserResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user_info = User::where('username', $request->username)->first();
        $user = User::findOrFail($user_info->id);
        $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
        if (!empty($token_iinfo)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('user.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }

}//end class
