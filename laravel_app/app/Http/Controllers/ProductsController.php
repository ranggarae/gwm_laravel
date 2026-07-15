<?php

namespace App\Http\Controllers;

use App\Language;
use App\Mail\GigOrderReminder;
use App\ProductCategory;
use App\ProductCoupon;
use App\ProductOrder;
use App\Mail\OrderReply;
use App\ProductRatings;
use App\Products;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function products_management(){
        $all_products = Products::all()->groupBy('lang');
        $all_languages = Language::all();
        $all_categories = ProductCategory::all()->groupBy('lang');
        $all_order_logs = ProductOrder::orderBy('id','desc')->get();
        $all_ratings = ProductRatings::orderBy('id','desc')->get();
        $all_coupons = ProductCoupon::orderBy('id','desc')->get();

        return view('backend.products.products-management')->with([
            'all_products' => $all_products,
            'all_languages' => $all_languages,
            'all_categories' => $all_categories,
            'all_order_logs' => $all_order_logs,
            'all_ratings' => $all_ratings,
            'all_coupons' => $all_coupons
        ]);
    }

    public function all_product()
    {
        $all_products = Products::all()->groupBy('lang');
        return view('backend.products.all-products')->with(['all_products' => $all_products]);
    }

    public function new_product()
    {
        $all_languages = Language::all();
        $all_category = ProductCategory::where(['status' => 'publish', 'lang' => get_default_language()])->get();
        return view('backend.products.new-product')->with(['all_languages' => $all_languages, 'all_categories' => $all_category]);
    }

    public function store_product(Request $request)
    {
        $this->validate($request, [
            'attributes_title' => 'nullable|array',
            'attributes_description' => 'nullable|array',
            'lang' => 'required|string',
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'category_id' => 'required|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable',
            'regular_price' => 'nullable|string|max:191',
            'sale_price' => 'nullable|string|max:191',
            'sku' => 'nullable|string|max:191',
            'stock_status' => 'nullable|string|max:191',
            'is_downloadable' => 'nullable|string|max:191',
            'meta_tags' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'image' => 'nullable|string|max:191',
            'gallery' => 'nullable|string|max:191',
            'status' => 'nullable|string|max:191',
            'badge' => 'nullable|string|max:191',
            'tax_percentage' => 'nullable|string|max:191',
            'downloadable_file' => 'nullable|mimes:zip|max:10650',
        ]);
        $id = Products::create([
            'attributes_title' => serialize($request->attributes_title),
            'attributes_description' => serialize($request->attributes_description),
            'lang' => $request->lang,
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku,
            'stock_status' =>  $request->stock_status,
            'is_downloadable' =>  $request->is_downloadable,
            'meta_tags' =>  $request->meta_tags,
            'meta_description' => $request->meta_description,
            'image' => $request->image,
            'gallery' => $request->gallery,
            'status' => $request->status,
            'tax_percentage' => $request->tax_percentage,
            'badge' => $request->badge
        ])->id;

        if ($request->hasFile('downloadable_file')){
            $file_extenstion = $request->downloadable_file->getClientOriginalExtension();
            if ($file_extenstion == 'zip'){
                $file_name_with_ext = $request->downloadable_file->getClientOriginalName();
                $file_name = pathinfo($file_name_with_ext, PATHINFO_FILENAME);
                $file_name = strtolower(Str::slug($file_name));

                $file_db = $file_name . time() . '.' . $file_extenstion;

                $request->downloadable_file->move('assets/uploads/downloadable/', $file_db);
                Products::where('id',$id)->update(['downloadable_file' => $file_db]);
            }
        }

        return redirect()->back()->with(['msg' => __('New Product Added Success'),'type' => 'success']);
    }

    public function edit_product($id){
        $product = Products::find($id);
        $all_languages = Language::all();
        $all_category = ProductCategory::where(['status' => 'publish', 'lang' => $product->lang])->get();
        return view('backend.products.edit-product')->with(['all_languages' => $all_languages, 'all_categories' => $all_category,'product' => $product]);
    }

    public function clone_product(Request $request){
        $product = Products::find($request->item_id);
        Products::create([
            'attributes_title' => $product->attributes_title,
            'attributes_description' => $product->attributes_description,
            'lang' => $product->lang,
            'title' => $product->title,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'short_description' => $product->short_description,
            'regular_price' => $product->regular_price,
            'sale_price' => $product->sale_price,
            'sku' => $product->sku,
            'stock_status' =>  $product->stock_status,
            'is_downloadable' =>  $product->is_downloadable,
            'meta_tags' =>  $product->meta_tags,
            'meta_description' => $product->meta_description,
            'image' => $product->image,
            'gallery' => $product->gallery,
            'badge' => $product->badge,
            'tax_percentage' => $product->tax_percentage,
            'status' => 'draft'
        ]);

        return redirect()->back()->with(['msg' => __('Product Clone Success'),'type' => 'success']);
    }

    public function delete_product(Request $request,$id){
        $product_details = Products::find($id);
        if (file_exists('assets/uploads/downloadable/'.$product_details->downloadable_file)){
            @unlink('assets/uploads/downloadable/'.$product_details->downloadable_file);
        }
        $product_details->delete();
        return redirect()->back()->with(['msg' => __('Product Deleted...'),'type' => 'danger']);
    }

    public function update_product(Request $request){
        $this->validate($request,[
            'attributes_title' => 'nullable|array',
            'attributes_description' => 'nullable|array',
            'lang' => 'required|string',
            'title' => 'required|string',
            'slug' => 'nullable|string',
            'category_id' => 'required|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable',
            'regular_price' => 'nullable|string|max:191',
            'sale_price' => 'nullable|string|max:191',
            'sku' => 'nullable|string|max:191',
            'stock_status' => 'nullable|string|max:191',
            'is_downloadable' => 'nullable|string|max:191',
            'meta_tags' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'image' => 'nullable|string|max:191',
            'gallery' => 'nullable|string|max:191',
            'status' => 'nullable|string|max:191',
            'badge' => 'nullable|string|max:191',
            'downloadable_file' => 'nullable|mimes:zip|max:10650',
            'tax_percentage' => 'nullable|string|max:10650',
        ]);
        Products::where('id',$request->product_id)->update([
            'attributes_title' => serialize($request->attributes_title),
            'attributes_description' => serialize($request->attributes_description),
            'lang' => $request->lang,
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'sku' => $request->sku,
            'tax_percentage' =>  $request->tax_percentage,
            'stock_status' =>  $request->stock_status,
            'is_downloadable' =>  $request->is_downloadable,
            'meta_tags' =>  $request->meta_tags,
            'meta_description' => $request->meta_description,
            'image' => $request->image,
            'gallery' => $request->gallery,
            'status' => $request->status,
            'badge' => $request->badge
        ]);
        $product_details = Products::find($request->product_id);
        if ($request->hasFile('downloadable_file')){
            $file_extenstion = $request->downloadable_file->getClientOriginalExtension();
            if ($file_extenstion == 'zip'){
                $file_name_with_ext = $request->downloadable_file->getClientOriginalName();
                $file_name = pathinfo($file_name_with_ext, PATHINFO_FILENAME);
                $file_name = strtolower(Str::slug($file_name));

                $file_db = $file_name . time() . '.' . $file_extenstion;

                $request->downloadable_file->move('assets/uploads/downloadable/', $file_db);
                if (file_exists('assets/uploads/downloadable/'.$product_details->downloadable_file)){
                    @unlink('assets/uploads/downloadable/'.$product_details->downloadable_file);
                }
                Products::where('id',$request->product_id)->update(['downloadable_file' => $file_db]);
            }
        }

        return redirect()->back()->with(['msg' => __('Product Update Success...'),'type' => 'success']);
    }

    public function download_file(Request $request,$id){
        $product_details = Products::find($id);
        if (file_exists('assets/uploads/downloadable/'.$product_details->downloadable_file)){
            $temp_file = asset('assets/uploads/downloadable/'.$product_details->downloadable_file);
            $file = new Filesystem();

            $file->copy($temp_file, 'assets/uploads/downloadable/'.Str::slug($product_details->title).'.zip');
            return response()->download('assets/uploads/downloadable/'.Str::slug($product_details->title).'.zip')->deleteFileAfterSend(true);
        }
        return redirect()->route('admin.home');
    }

    public function page_settings(){
        $all_languages = Language::all();
        return view('backend.products.product-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request){
        $this->validate($request,[
            'product_post_items' => 'nullable|string|max:191'
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'product_add_to_cart_button_'.$lang->slug.'_text' => 'nullable|string|max:191',
                'product_category_'.$lang->slug.'_text' => 'nullable|string|max:191',
                'product_rating_filter_'.$lang->slug.'_text' => 'nullable|string|max:191',
                'product_price_filter_'.$lang->slug.'_text' => 'nullable|string|max:191',
            ]);
            $fields =[
                'product_add_to_cart_button_'.$lang->slug.'_text',
                'product_category_'.$lang->slug.'_text',
                'product_price_filter_'.$lang->slug.'_text',
                'product_rating_filter_'.$lang->slug.'_text',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('product_post_items',$request->product_post_items);

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'),'type' => 'success']);
    }
    public function single_page_settings(){
        $all_languages = Language::all();
        return view('backend.products.product-single-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_single_page_settings(Request $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'product_single_'.$lang->slug.'_add_to_cart_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_category_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_sku_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_description_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_attributes_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_related_product_text' => 'nullable|string|max:191',
                'product_single_'.$lang->slug.'_ratings_text' => 'nullable|string|max:191',
            ]);
            $fields = [
                'product_single_'.$lang->slug.'_add_to_cart_text' ,
                'product_single_'.$lang->slug.'_category_text' ,
                'product_single_'.$lang->slug.'_sku_text',
                'product_single_'.$lang->slug.'_description_text',
                'product_single_'.$lang->slug.'_attributes_text' ,
                'product_single_'.$lang->slug.'_related_product_text',
                'product_single_'.$lang->slug.'_ratings_text',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'),'type' => 'success']);
    }

    public function cancel_page_settings(){
        $all_languages = Language::all();
        return view('backend.products.product-cancel-page-settings')->with(['all_languages' => $all_languages]);
    }
    public function update_cancel_page_settings(Request $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'product_cancel_page_'.$lang->slug.'_title' => 'nullable|string|max:191',
                'product_cancel_page_'.$lang->slug.'_description' => 'nullable|string|max:191',
            ]);
            $fields = [
                'product_cancel_page_'.$lang->slug.'_title' ,
                'product_cancel_page_'.$lang->slug.'_description' ,
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'),'type' => 'success']);
    }

    public function success_page_settings(){
        $all_languages = Language::all();
        return view('backend.products.product-success-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_success_page_settings(Request $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'product_success_page_'.$lang->slug.'_title' => 'nullable|string|max:191',
                'product_success_page_'.$lang->slug.'_description' => 'nullable|string|max:191',
            ]);
            $fields = [
                'product_success_page_'.$lang->slug.'_title' ,
                'product_success_page_'.$lang->slug.'_description' ,
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'),'type' => 'success']);
    }

    public function product_order_logs(){
        $all_orders = ProductOrder::all();
        return view('backend.products.product-orders-all')->with(['all_orders' => $all_orders]);
    }

    public function product_order_payment_approve(Request $request,$id){
        ProductOrder::find($id)->update(['payment_status' => 'complete']);
        
        return redirect()->back()->with(['msg' => __('Payment Status Updated..'),'type' => 'success']);
    }

    public function product_order_delete(Request $request,$id){
        ProductOrder::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Order Log Deleted..'),'type' => 'danger']);
    }

    public function product_order_status_change(Request $request){
        $this->validate($request,[
            'order_status' => 'nullable|string|max:191'
        ]);
        
        $product_order = ProductOrder::find($request->order_id);
        $product_order->status = $request->order_status;
        $product_order->save();

        $mail_data['title'] = __('Product Order Status Change');
        $mail_data['subject'] = __('Product Order Status Change');
        $mail_data['name'] = $product_order->billing_name;
        $mail_data['message'] = '<p>' . __('Hello') . '</p><p>' . __('Your product order #' . $product_order->id . ' status change to ') . ucwords(str_replace('_', ' ', $product_order->status)) . '</p>';
        Mail::to($product_order->billing_email)->send(new OrderReply($mail_data, $mail_data['subject'], $mail_data['title']));

        return redirect()->back()->with(['msg' => __('Product Order Status Update..'),'type' => 'success']);
    }

    public function generate_invoice(Request $request){
        $order_details = ProductOrder::find($request->order_id);
        $pdf = PDF::loadView('backend.products.pdf.order', ['order_details' => $order_details]);
        return $pdf->download('product-order-invoice.pdf');
    }

    public function product_ratings(){
        $all_ratings = ProductRatings::all();

        return view('backend.products.product-ratings-all')->with(['all_ratings' => $all_ratings]);
    }

    public function product_ratings_delete(Request $request, $id){
        ProductRatings::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Product Review Deleted..'),'type' => 'danger']);
    }

    public function bulk_action(Request $request){
        $all = Products::find($request->ids);
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
    public function product_order_bulk_action(Request $request){
        $all = ProductOrder::find($request->ids);
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
    public function product_ratings_bulk_action(Request $request){
        $all = ProductRatings::find($request->ids);
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

    public function order_report(Request  $request)
    {
        $order_data = '';
        $query = ProductOrder::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->payment_status)){
            $query->where(['payment_status' => $request->payment_status ]);
        }
        if (!empty($request->order_status)){
            $query->where(['status' => $request->order_status ]);
        }
        $error_msg = __('select start & end date to generate event payment report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.products.product-order-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
            'error_msg' => $error_msg
        ]);
    }

    public function tax_settings(){
        return view('backend.products.product-tax-settings');
    }

    public function update_tax_settings(Request  $request){
        $this->validate($request,[
            'product_tax' => 'nullable|string',
            'product_tax_type' => 'required|string',
            'product_tax_percentage' => 'required|string',
        ]);
        $all_fields = [
            'product_tax',
            'product_tax_percentage',
            'product_tax_type',
        ];
        foreach ($all_fields as $all_field) {
            update_static_option($all_field,$request->$all_field);
        }
        return redirect()->back()->with(['msg' => __('Settings Updates'),'type' => 'success']);
    }

    public function order_reminder_mail(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required'
        ]);

        $gig_order_details = ProductOrder::find($request->order_id);

        Mail::to($gig_order_details->billing_email)->send(new GigOrderReminder($gig_order_details, __('You have a pending order in' . ' ' . get_static_option('site_' . get_default_language() . '_title')),'product'));

        return redirect()->back()->with(['msg' => __('Reminder Mail Send Success'), 'type' => 'success']);
    }
}
