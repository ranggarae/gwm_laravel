<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Gig;
use App\GigsCategory;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GigsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function new()
    {
        $all_languages = Language::all();
        $gigs_category = GigsCategory::where(['status' => 'publish', 'lang' => get_default_language()])->get();
        return view('backend.gigs.new-gig')->with(['all_languages' => $all_languages, 'gigs_category' => $gigs_category]);
    }
    public function index(){
        $all_gigs = Gig::all()->groupBy('lang');
        return view('backend.gigs.all-gigs')->with([
            'all_gigs' => $all_gigs,
        ]);
    }

    public function gigs_management(Request $request){
        $all_gigs = Gig::all()->groupBy('lang');
        $all_languages = Language::all();
        $all_category = GigsCategory::all()->groupBy('lang');
        $gigs_category_flat = GigsCategory::where(['status' => 'publish', 'lang' => get_default_language()])->get();

        // Orders
        $query = \App\GigOrder::query();
        $order_status = !empty($request->order_status) ? $request->order_status : '';
        $payment_status = !empty($request->payment_status) ? $request->payment_status : '';
        if (!empty($order_status)){
            $query->where('order_status',$order_status);
        }
        if (!empty($payment_status)){
            $query->where('payment_status',$payment_status);
        }
        $all_orders = $query->get();

        return view('backend.gigs.gigs-management')->with([
            'all_gigs' => $all_gigs,
            'all_languages' => $all_languages,
            'all_category' => $all_category,
            'gigs_category_flat' => $gigs_category_flat,
            'all_orders' => $all_orders,
            'order_status' => $order_status,
            'payment_status' => $payment_status,
        ]);
    }
    public function edit($id){
        $all_languages = Language::all();
        $gig = Gig::find($id);
        $gigs_category = GigsCategory::where(['status' => 'publish', 'lang' => $gig->lang])->get();
        return view('backend.gigs.edit-gig')->with(['all_languages' => $all_languages, 'gigs_category' => $gigs_category,'gig' => $gig]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'delivery_time' => 'required|array',
            'delivery_time.*' => 'required|numeric',
            'category_id' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'gallery' => 'required|string',
            'image' => 'required|string',
            'lang' => 'required|string',
            'meta_description' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'faqs_description' => 'nullable|array',
            'faqs_description.*' => 'nullable|string',
            'faqs_title' => 'nullable|array',
            'faqs_title.*' => 'nullable|string',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'plan_description' => 'required|array',
            'plan_description.*' => 'required|string',
            'plan_price' => 'required|array',
            'plan_price.*' => 'required|string',
            'plan_title' => 'required|array',
            'plan_title.*' => 'required|string',
            'revisions' => 'required|array',
            'revisions.*' => 'required|numeric',
        ]);

        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Gig::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }


        Gig::create([
            'title' => $request->title,
            'slug' => $blog_slug,
            'delivery_time' => serialize($request->delivery_time),
            'revisions' => serialize($request->revisions),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
            'gallery' => $request->gallery,
            'image' => $request->image,
            'lang' =>  $request->lang,
            'meta_description' => $request->meta_description,
            'meta_tags' => $request->meta_tags,
            'faqs_description' => serialize($request->faqs_description),
            'faqs_title' => serialize($request->faqs_title),
            'features' => serialize($request->features),
            'plan_description' => serialize($request->plan_description),
            'plan_price' => serialize($request->plan_price),
            'plan_title' => serialize($request->plan_title),
        ]);

        return redirect()->back()->with([
            'msg' => __('New Gig Created...'),
            'type' => 'success'
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'category_id' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'gallery' => 'required|string',
            'image' => 'required|string',
            'lang' => 'required|string',
            'meta_description' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'faqs_description' => 'nullable|array',
            'faqs_description.*' => 'nullable|string',
            'delivery_time' => 'required|array',
            'delivery_time.*' => 'required|numeric',
            'faqs_title' => 'nullable|array',
            'faqs_title.*' => 'nullable|string',
            'revisions' => 'required|array',
            'revisions.*' => 'required|numeric',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'plan_description' => 'required|array',
            'plan_description.*' => 'required|string',
            'plan_price' => 'required|array',
            'plan_price.*' => 'required|string',
            'plan_title' => 'required|array',
            'plan_title.*' => 'required|string',
        ]);

        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
       

        Gig::find($request->item_id)->update([
            'title' => $request->title,
            'slug' => $blog_slug,
            'delivery_time' => serialize($request->delivery_time),
            'revisions' => serialize($request->revisions),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
            'gallery' => $request->gallery,
            'image' => $request->image,
            'lang' =>  $request->lang,
            'meta_description' => $request->meta_description,
            'meta_tags' => $request->meta_tags,
            'faqs_description' => serialize($request->faqs_description),
            'faqs_title' => serialize($request->faqs_title),
            'features' => serialize($request->features),
            'plan_description' => serialize($request->plan_description),
            'plan_price' => serialize($request->plan_price),
            'plan_title' => serialize($request->plan_title),
        ]);

        return redirect()->back()->with([
            'msg' => __('Gig Updated...'),
            'type' => 'success'
        ]);
    }

    public function clone(Request $request)
    {
        $gig = Gig::find($request->item_id);
        $blog_slug = !empty($gig->slug) ? Str::slug($gig->slug) : Str::slug($gig->title);
        $check_slug = Gig::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }

        Gig::create([
            'title' => $gig->title,
            'slug' => $blog_slug,
            'delivery_time' => $gig->delivery_time,
            'revisions' => $gig->revisions,
            'category_id' => $gig->category_id,
            'description' => $gig->description,
            'status' => 'draft',
            'gallery' => $gig->gallery,
            'image' => $gig->image,
            'lang' =>  $gig->lang,
            'meta_description' => $gig->meta_description,
            'meta_tags' => $gig->meta_tags,
            'faqs_description' => $gig->faqs_description,
            'faqs_title' => $gig->faqs_title,
            'features' => $gig->features,
            'plan_description' => $gig->plan_description,
            'plan_price' => $gig->plan_price,
            'plan_title' => $gig->plan_title
        ]);

        return redirect()->back()->with([
            'msg' => __('Gig Clone Success...'),
            'type' => 'success'
        ]);
    }

    public function bulk_action(Request $request){
        $all = Gig::find($request->ids);
        foreach($all as $item){
            if ($request->type == 'delete'){
                $item->delete();
            }else{
                $item->status = $request->type;
                $item->save();
            }
        }
        return response()->json(['status' => 'ok']);
    }
    public function get_cat_by_lang(Request $request){
        $all_category = GigsCategory::where('lang',$request->lang)->get();
        return response()->json($all_category);
    }

    public function gig_single_page_index(){
        $all_languages = Language::all();
        return view('backend.gigs.gig-single-page-settings')->with(['all_languages' => $all_languages]);
    }
    
    public function update_gig_single_page_index(Request  $request){
        $all_languages = Language::all();
        

        foreach ($all_languages as $lang) {
            $this->validate($request,[
                'gig_single_'.$lang->slug.'_order_button_title' => 'nullable|string',
                'gig_single_'.$lang->slug.'_quote_title' => 'nullable|string',
                'gig_single_'.$lang->slug.'_quote_button_title' => 'nullable|string',
            ]);

            $fields = [
                'gig_single_'.$lang->slug.'_order_button_title' ,
                'gig_single_'.$lang->slug.'_quote_title' ,
                'gig_single_'.$lang->slug.'_quote_button_title' ,
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }
        
        return redirect()->back()->with(['msg' => __('Settings updated'),'type' => 'success']);
    }

    public function gig_page_index(){
        return view('backend.gigs.gig-page-settings');
    }

    public function update_gig_page_index(Request  $request){
        $this->validate($request,[
            'gig_page_items' => 'required',
            'gig_page_notify_email' => 'required',
        ]);
        update_static_option('gig_page_items',$request->gig_page_items);
        update_static_option('gig_page_notify_email',$request->gig_page_notify_email);

        return redirect()->back()->with(['msg' => __('Settings updated'),'type' => 'success']);
    }

    public function gig_order_success_page_index(){
        $all_languages = Language::all();
        return view('backend.gigs.gig-success-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_gig_order_success_page_index(Request  $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang) {
            $this->validate($request,[
                'gig_order_success_page_'.$lang->slug.'_title' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_name_title' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_order_date_text' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_order_delivery_date_text' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_total_revisions_text' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_payment_gateway_text' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_payment_status_text' => 'nullable|string',
                'gig_order_success_page_'.$lang->slug.'_gig_ordered_plan_text' => 'nullable|string',
            ]);

            $fields = [
                'gig_order_success_page_'.$lang->slug.'_title',
                'gig_order_success_page_'.$lang->slug.'_gig_name_title',
                'gig_order_success_page_'.$lang->slug.'_gig_order_date_text',
                'gig_order_success_page_'.$lang->slug.'_gig_order_delivery_date_text',
                'gig_order_success_page_'.$lang->slug.'_gig_total_revisions_text',
                'gig_order_success_page_'.$lang->slug.'_gig_payment_gateway_text',
                'gig_order_success_page_'.$lang->slug.'_gig_payment_status_text',
                'gig_order_success_page_'.$lang->slug.'_gig_ordered_plan_text'
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings updated'),'type' => 'success']);
    }

    public function gig_order_cancel_page_index(){
        $all_languages = Language::all();
        return view('backend.gigs.gig-cancel-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_gig_order_cancel_page_index(Request  $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang) {
            $this->validate($request,[
                'gig_order_cancel_page_'.$lang->slug.'_title' => 'nullable|string',
                'gig_order_cancel_page_'.$lang->slug.'_description' => 'nullable|string',
            ]);

            $fields = [
                'gig_order_cancel_page_'.$lang->slug.'_title',
                'gig_order_cancel_page_'.$lang->slug.'_description',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings updated'),'type' => 'success']);
    }

    public function delete($id,Request $request){
        Gig::where('id',$id)->delete();
        return redirect()->back()->with(['msg' => __('Delete Success'),'type' => 'danger']);
    }
}
