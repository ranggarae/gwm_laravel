<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class CharityHomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function icon_box_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.icon-box')->with(['all_languages' => $all_languages]);
    }

    public function icon_box_area_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_icon_box_icon' => 'required|array',
                'home_page_09_icon_box_icon.*' => 'required|string',
                'home_page_09_icon_box_button_url' => 'required|array',
                'home_page_09_icon_box_button_url.*' => 'required|string',
                'home_page_09_'.$lang->slug.'_icon_box_title' => 'required|array',
                'home_page_09_'.$lang->slug.'_icon_box_title.*' => 'required|string',
                'home_page_09_'.$lang->slug.'_icon_box_button_text' => 'required|array',
                'home_page_09_'.$lang->slug.'_icon_box_button_text.*' => 'required|string',
                'home_page_09_'.$lang->slug.'_icon_box_description' => 'required|array',
                'home_page_09_'.$lang->slug.'_icon_box_description.*' => 'required|string',
            ]);
            $all_fields = [
                'home_page_09_icon_box_icon',
                'home_page_09_icon_box_button_url',
                'home_page_09_'.$lang->slug.'_icon_box_button_text',
                'home_page_09_'.$lang->slug.'_icon_box_title',
                'home_page_09_'.$lang->slug.'_icon_box_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,serialize($request->$field));
            }
        }

        return redirect()->back()->with(['msg' => __('Icon Box Update Success'),'type' => 'success']);
    }

    public function about_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.about-area')->with(['all_languages' => $all_languages]);
    }

    public function about_area_update(Request  $request){

        $this->validate($request,[
           'home_page_09_about_area_btn_url' => 'nullable|string',
           'home_page_09_about_area_left_image' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_about_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_about_area_subtitle' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_about_area_description' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_about_area_btn_text' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_about_area_title',
                'home_page_09_'.$lang->slug.'_about_area_subtitle',
                'home_page_09_'.$lang->slug.'_about_area_description',
                'home_page_09_'.$lang->slug.'_about_area_btn_text',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_09_about_area_btn_url',$request->home_page_09_about_area_btn_url);
        update_static_option('home_page_09_about_area_left_image',$request->home_page_09_about_area_left_image);

        return redirect()->back()->with(['msg' => __('About Area Update Success'),'type' => 'success']);
    }

    public function service_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.service-area')->with(['all_languages' => $all_languages]);
    }

    public function service_area_update(Request  $request){

        $this->validate($request,[
            'home_page_09_service_area_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_service_area_read_more_text' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_service_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_service_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_service_area_title',
                'home_page_09_'.$lang->slug.'_service_area_read_more_text',
                'home_page_09_'.$lang->slug.'_service_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_01_service_area_items',$request->home_page_01_service_area_items);

        return redirect()->back()->with(['msg' => __('Service Area Update Success'),'type' => 'success']);
    }

    //recent_cause_index
    public function recent_cause_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.recent-cause')->with(['all_languages' => $all_languages]);
    }

    public function recent_cause_update(Request  $request){

        $this->validate($request,[
            'home_page_09_service_area_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_recent_cause_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_recent_cause_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_recent_cause_title',
                'home_page_09_'.$lang->slug.'_recent_cause_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_09_recent_cause_items',$request->home_page_09_recent_cause_items);

        return redirect()->back()->with(['msg' => __('Recent Cause Update Success'),'type' => 'success']);
    }

    //our_gallery_index
    public function our_gallery_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.our-gallery')->with(['all_languages' => $all_languages]);
    }

    public function our_gallery_update(Request  $request){

        $this->validate($request,[
            'home_page_09_our_gallery_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_our_gallery_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_our_gallery_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_our_gallery_title',
                'home_page_09_'.$lang->slug.'_our_gallery_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_09_our_gallery_items',$request->home_page_09_our_gallery_items);

        return redirect()->back()->with(['msg' => __('Our Gallery Update Success'),'type' => 'success']);
    }

    //
    public function event_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.event-area')->with(['all_languages' => $all_languages]);
    }

    public function event_area_update(Request  $request){

        $this->validate($request,[
            'home_page_09_event_area_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_event_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_event_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_event_area_title',
                'home_page_09_'.$lang->slug.'_event_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_09_event_area_items',$request->home_page_09_event_area_items);

        return redirect()->back()->with(['msg' => __('Event Area Update Success'),'type' => 'success']);
    }

    //counterup_area_index
    public function counterup_area_index(){
        return view('backend.pages.home.charity-home.counterup-area');
    }

    public function counterup_area_update(Request  $request){

        $this->validate($request,[
            'home_09_counterup_bg_image' => 'nullable|string',
        ]);

        update_static_option('home_09_counterup_bg_image',$request->home_09_counterup_bg_image);

        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }
    //team_member_area_index
    public function team_member_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.team-member-area')->with(['all_languages' => $all_languages]);
    }

    public function team_member_area_update(Request  $request){

        $this->validate($request,[
            'home_page_09_team_member_area_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_team_member_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_team_member_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_team_member_area_title',
                'home_page_09_'.$lang->slug.'_team_member_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_09_team_member_area_items',$request->home_page_09_team_member_area_items);

        return redirect()->back()->with(['msg' => __('Event Area Update Success'),'type' => 'success']);
    }

    //testimonial_area_index
    public function testimonial_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.testimonial-area')->with(['all_languages' => $all_languages]);
    }

    public function testimonial_area_update(Request  $request){


        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_testimonial_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_testimonial_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_testimonial_area_title',
                'home_page_09_'.$lang->slug.'_testimonial_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Event Area Update Success'),'type' => 'success']);
    }

    //news_blog_area_index
    public function news_blog_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.charity-home.news-blog-area')->with(['all_languages' => $all_languages]);
    }

    public function news_blog_area_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_09_'.$lang->slug.'_news_blog_area_title' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_news_blog_area_description' => 'nullable|string',
                'home_page_09_'.$lang->slug.'_news_blog_area_readmore_text' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_09_'.$lang->slug.'_news_blog_area_title',
                'home_page_09_'.$lang->slug.'_news_blog_area_readmore_text',
                'home_page_09_'.$lang->slug.'_news_blog_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }

}
