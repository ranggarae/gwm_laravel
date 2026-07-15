<?php

namespace App\Http\Controllers;

use App\Language;
use App\Products;
use Illuminate\Http\Request;

class ProductHomePageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function header_slider_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.product-home.header-area')->with(['all_languages' => $all_languages]);
    }

    public function header_slider_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_08_header_bg_image' => 'required|array',
                'home_08_header_bg_image.*' => 'required|string',
                'home_page_08_header_slider_button_url' => 'required|array',
                'home_page_08_header_slider_button_url.*' => 'required|string',
                'home_page_08_'.$lang->slug.'_header_slider_button_text' => 'required|array',
                'home_page_08_'.$lang->slug.'_header_slider_button_text.*' => 'required|string',
                'home_page_08_'.$lang->slug.'_header_slider_description' => 'required|array',
                'home_page_08_'.$lang->slug.'_header_slider_description.*' => 'required|string',
                'home_page_08_'.$lang->slug.'_header_slider_title' => 'required|array',
                'home_page_08_'.$lang->slug.'_header_slider_title.*' => 'required|string',
            ]);
            $all_fields = [
                'home_page_08_header_slider_button_url',
                'home_08_header_bg_image',
                'home_page_08_'.$lang->slug.'_header_slider_button_text',
                'home_page_08_'.$lang->slug.'_header_slider_description',
                'home_page_08_'.$lang->slug.'_header_slider_title',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,serialize($request->$field));
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }

    public function featured_product_index(){
        $all_languages = Language::all();
        $all_products = Products::where(['status' => 'publish','lang' => get_default_language()])->get();
        return view('backend.pages.home.product-home.feature-product')->with(['all_languages' => $all_languages,'all_products' => $all_products]);
    }
    public function get_product_by_lang(Request $request){
        //have to write code for it
        $all_products = Products::where(['lang' => $request->lang,'status' => 'publish'])->get();
        return response()->json($all_products);
    }

    public function featured_product_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_08_'.$lang->slug.'_popular_article_title' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_popular_article_description' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_featured_product_id' => 'nullable',
            ]);
            $all_fields = [
                'home_page_08_'.$lang->slug.'_popular_article_title',
                'home_page_08_'.$lang->slug.'_popular_article_description',
                'home_page_08_'.$lang->slug.'_featured_product_id',
            ];
            foreach ($all_fields as $field){
                if($field == 'home_page_08_'.$lang->slug.'_featured_product_id'){
                    update_static_option($field,serialize($request->$field));
                }else{
                update_static_option($field,$request->$field);
                }
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update..'),'type' => 'success']);
    }

    //decorate_area_index
    public function decorate_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.product-home.decorate-area')->with(['all_languages' => $all_languages]);
    }

    public function decorate_area_update(Request  $request){

        $this->validate($request,[
            'home_page_08_decorate_area_right_image' => 'nullable|string'
        ]);
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_08_'.$lang->slug.'_decorate_area_title' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_decorate_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_08_'.$lang->slug.'_decorate_area_title',
                'home_page_08_'.$lang->slug.'_decorate_area_description',
            ];
            foreach ($all_fields as $field){
                    update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_08_decorate_area_right_image',$request->home_page_08_decorate_area_right_image);

        return redirect()->back()->with(['msg' => __('Settings Update..'),'type' => 'success']);
    }

    //latest_product_area_index
    public function latest_product_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.product-home.latest-product-area')->with(['all_languages' => $all_languages]);
    }
    public function latest_product_area_update(Request  $request){

        $this->validate($request,[
            'home_page_08_latest_product_area_items' => 'nullable|string'
        ]);
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_08_'.$lang->slug.'_latest_product_area_title' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_latest_product_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_08_'.$lang->slug.'_latest_product_area_title',
                'home_page_08_'.$lang->slug.'_latest_product_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_08_latest_product_area_items',$request->home_page_08_latest_product_area_items);

        return redirect()->back()->with(['msg' => __('Settings Update..'),'type' => 'success']);
    }

    //testimonial_index
    public function testimonial_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.product-home.testimonial-area')->with(['all_languages' => $all_languages]);
    }

    public function testimonial_update(Request  $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_08_'.$lang->slug.'_testimonial_area_title' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_testimonial_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_08_'.$lang->slug.'_testimonial_area_title',
                'home_page_08_'.$lang->slug.'_testimonial_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update..'),'type' => 'success']);
    }

    //cta_index
    public function cta_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.product-home.cta-area')->with(['all_languages' => $all_languages]);
    }
    public function cta_update(Request  $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_08_'.$lang->slug.'_cta_area_title' => 'nullable|string',
                'home_page_08_'.$lang->slug.'_cta_area_placeholder_text' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_08_'.$lang->slug.'_cta_area_title',
                'home_page_08_'.$lang->slug.'_cta_area_placeholder_text',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update..'),'type' => 'success']);
    }
}
