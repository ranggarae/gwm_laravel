<?php

namespace App\Http\Controllers;

use App\Events;
use App\Language;
use Illuminate\Http\Request;

class EventHomePageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function featured_event_area_index(){
        $all_languages = Language::all();
        $all_events = Events::where(['lang' => get_default_language(),'status' => 'publish'])->get();
        return view('backend.pages.home.event-home.featured-event')->with(['all_languages' => $all_languages,'all_events' => $all_events]);
    }

    public function featured_event_area_update(Request  $request){
        $this->validate($request,[
            'home_page_07_featured_event' => 'required|string'
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_07_'.$lang->slug.'_featured_area_button_title'
            ]);

            $fields =  'home_page_07_'.$lang->slug.'_featured_area_button_title';
            update_static_option($fields,$request->$fields);
        }

        update_static_option('home_page_07_featured_event',$request->home_page_07_featured_event);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    public function attend_event_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.event-attend')->with(['all_languages' => $all_languages]);
    }

    public function attend_event_area_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_07_icon_box_icon' => 'required|array',
                'home_page_07_icon_box_icon.*' => 'required|string',
                'home_page_07_'.$lang->slug.'_icon_box_title' => 'required|array',
                'home_page_07_'.$lang->slug.'_icon_box_title.*' => 'required|string',
                'home_page_07_'.$lang->slug.'_icon_box_description' => 'required|array',
                'home_page_07_'.$lang->slug.'_icon_box_description.*' => 'required|string',
            ]);
            $all_normal_fields = [
                'home_page_07_'.$lang->slug.'_attend_event_area_title',
                'home_page_07_'.$lang->slug.'_attend_event_area_subtitle',
            ];
            foreach ($all_normal_fields as $field){
                update_static_option($field,$request->$field);
            }

            $all_fields = [
                'home_page_07_icon_box_icon',
                'home_page_07_'.$lang->slug.'_icon_box_title',
                'home_page_07_'.$lang->slug.'_icon_box_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,serialize($request->$field));
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }

    public function event_speaker_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.event-speaker')->with(['all_languages' => $all_languages]);
    }

    public function event_speaker_area_update(Request  $request){
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_07_'.$lang->slug.'_event_speaker_area_subtitle',
                'home_page_07_'.$lang->slug.'_event_speaker_area_title',
            ]);

            $fields = [
              'home_page_07_'.$lang->slug.'_event_speaker_area_subtitle',
              'home_page_07_'.$lang->slug.'_event_speaker_area_title',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    public function counterup_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.counterup-area')->with(['all_languages' => $all_languages]);
    }

    public function counterup_area_update(Request  $request){
        $this->validate($request,[
            'home_07_counterup_bg_image' => 'required|string'
        ]);
        update_static_option('home_07_counterup_bg_image',$request->home_07_counterup_bg_image);
        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //upcoming_event_area_index
    public function upcoming_event_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.upcoming-event-area')->with(['all_languages' => $all_languages]);
    }

    public function upcoming_event_area_update(Request  $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_07_'.$lang->slug.'_upcoming_event_area_subtitle',
                'home_page_07_'.$lang->slug.'_upcoming_event_area_title',
            ]);

            $fields = [
                'home_page_07_'.$lang->slug.'_upcoming_event_area_subtitle',
                'home_page_07_'.$lang->slug.'_upcoming_event_area_title',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    public function our_sponsors_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.our-sponsors-area')->with(['all_languages' => $all_languages]);
    }

    public function our_sponsors_area_update(Request  $request){
        $this->validate($request,[
           'home_page_07_our_sponsors_button_link' => 'nullable'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_07_'.$lang->slug.'_our_sponsors_area_subtitle',
                'home_page_07_'.$lang->slug.'_our_sponsors_area_title',
                'home_page_07_'.$lang->slug.'_our_sponsors_button_text',
            ]);

            $fields = [
                'home_page_07_'.$lang->slug.'_our_sponsors_area_subtitle',
                'home_page_07_'.$lang->slug.'_our_sponsors_area_title',
                'home_page_07_'.$lang->slug.'_our_sponsors_button_text',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }
        update_static_option('home_page_07_our_sponsors_button_link',$request->home_page_07_our_sponsors_button_link);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    public function latest_blog_area_index(){

        $all_languages = Language::all();
        return view('backend.pages.home.event-home.latest-blog-area')->with(['all_languages' => $all_languages]);
    }

    public function latest_blog_area_update(Request  $request){

        $all_languages = Language::all();

        foreach ($all_languages as $lang){

            $this->validate($request,[
                'home_page_07_'.$lang->slug.'_latest_news_area_subtitle',
                'home_page_07_'.$lang->slug.'_latest_news_area_title',
                'home_page_07_'.$lang->slug.'_news_blog_area_readmore_text',
            ]);

            $fields = [
                'home_page_07_'.$lang->slug.'_latest_news_area_subtitle',
                'home_page_07_'.$lang->slug.'_latest_news_area_title',
                'home_page_07_'.$lang->slug.'_news_blog_area_readmore_text',
            ];

            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }

        }

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }
}
