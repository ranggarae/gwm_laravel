<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class KnowledgeHomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function header_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.knowledge-home.header')->with(['all_languages' => $all_languages]);
    }

    public function header_update(Request  $request){
        $this->validate($request,[
            'home_page_05_header_background_image',
            'home_page_05_header_bottom_image',
        ]);

        update_static_option('home_page_05_header_background_image',$request->home_page_05_header_background_image);
        update_static_option('home_page_05_header_bottom_image',$request->home_page_05_header_bottom_image);

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[

            ]);
            $all_fields = [
                'home_page_05_'.$lang->slug.'_header_search_placeholder',
                'home_page_05_'.$lang->slug.'_search_form_status',
                'home_page_05_'.$lang->slug.'_header_description',
                'home_page_05_'.$lang->slug.'_header_title',
            ];

            foreach ($all_fields as $fiel){
                update_static_option($fiel,$request->$fiel);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'), 'type' => 'success']);
    }

    public function highlight_box_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.knowledge-home.highlight-box')->with(['all_languages' => $all_languages]);
    }

    public function highlight_box_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_05_highlight_box_icon' => 'required|array',
                'home_page_05_highlight_box_icon.*' => 'required|string',
                'home_page_05_'.$lang->slug.'_highlight_box_title' => 'required|array',
                'home_page_05_'.$lang->slug.'_highlight_box_title.*' => 'required|string',
                'home_page_05_'.$lang->slug.'_highlight_box_description' => 'required|array',
                'home_page_05_'.$lang->slug.'_highlight_box_description.*' => 'required|string',
            ]);
            $all_fields = [
                'home_page_05_highlight_box_icon',
                'home_page_05_'.$lang->slug.'_highlight_box_title',
                'home_page_05_'.$lang->slug.'_highlight_box_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,serialize($request->$field));
            }
        }

        return redirect()->back()->with(['msg' => __('Highlight Box Update Success'),'type' => 'success']);
    }

    public function popular_article_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.knowledge-home.popular-article')->with(['all_languages' => $all_languages]);
    }

    public function popular_article_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_05_'.$lang->slug.'_popular_article_title' => 'nullable|string',
                'home_page_05_'.$lang->slug.'_popular_article_description' => 'nullable|string',
            ]);

            $all_fields = [
                'home_page_05_'.$lang->slug.'_popular_article_title',
                'home_page_05_'.$lang->slug.'_popular_article_description'
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update'),'type' => 'success']);
    }

    public function faq_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.knowledge-home.faq-area')->with(['all_languages' => $all_languages]);
    }

    public function faq_area_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_05_'.$lang->slug.'_faq_area_title' => 'nullable|string',
                'home_page_05_'.$lang->slug.'_faq_area_description' => 'nullable|string',
            ]);

            $all_fields = [
                'home_page_05_'.$lang->slug.'_faq_area_title',
                'home_page_05_'.$lang->slug.'_faq_area_description'
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update'),'type' => 'success']);
    }

    public function cta_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.knowledge-home.cta-area')->with(['all_languages' => $all_languages]);
    }

    public function cta_area_update(Request  $request){

        $this->validate($request,[
            'home_page_05_cta_area_btn_url' => 'required|string',
            'home_page_05_cta_area_background_image' => 'required|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_05_'.$lang->slug.'_cta_area_title' => 'nullable|string',
                'home_page_05_'.$lang->slug.'_cta_area_description' => 'nullable|string',
                'home_page_05_'.$lang->slug.'_cta_area_btn_text' => 'nullable|string',
            ]);

            $all_fields = [
                'home_page_05_'.$lang->slug.'_cta_area_title',
                'home_page_05_'.$lang->slug.'_cta_area_description',
                'home_page_05_'.$lang->slug.'_cta_area_btn_text',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }
        update_static_option('home_page_05_cta_area_btn_url',$request->home_page_05_cta_area_btn_url);
        update_static_option('home_page_05_cta_area_background_image',$request->home_page_05_cta_area_background_image);

        return redirect()->back()->with(['msg' => __('Settings Update'),'type' => 'success']);
    }

}
