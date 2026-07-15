<?php
namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class ServiceHomePageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function header_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.service-home.header-area')->with(['all_languages' => $all_languages]);
    }

    public function header_update(Request  $request){

        $this->validate($request,[
            'home_page_06_header_background_image' => 'nullable|string',
            'home_page_06_header_right_image' => 'nullable|string',
        ]);

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
               'home_page_06_'.$lang->slug.'_header_area_title',
               'home_page_06_'.$lang->slug.'_header_area_description',
            ]);

            $all_fields = [
                'home_page_06_'.$lang->slug.'_header_area_title',
                'home_page_06_'.$lang->slug.'_header_area_description',
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_06_header_background_image',$request->home_page_06_header_background_image);
        update_static_option('home_page_06_header_right_image',$request->home_page_06_header_right_image);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //video_index
    public function video_index(){
        return view('backend.pages.home.service-home.video-area');
    }

    public function video_update(Request  $request){

        $this->validate($request,[
            'home_page_06_video_area_background_image' => 'nullable|string',
            'home_page_06_video_area_video_url' => 'nullable|string',
        ]);


        update_static_option('home_page_06_video_area_background_image',$request->home_page_06_video_area_background_image);
        update_static_option('home_page_06_video_area_video_url',$request->home_page_06_video_area_video_url);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //our_service_index
    public function our_service_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.service-home.our-service-area')->with(['all_languages' => $all_languages]);
    }

    public function our_service_update(Request  $request){

        $this->validate($request,[
            'home_page_06_our_service_area_items' => 'nullable|string',
        ]);

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_06_'.$lang->slug.'_our_service_area_title',
                'home_page_06_'.$lang->slug.'_our_service_area_description',
                'home_page_06_'.$lang->slug.'_our_service_area_button_text',
            ]);

            $all_fields = [
                'home_page_06_'.$lang->slug.'_our_service_area_title',
                'home_page_06_'.$lang->slug.'_our_service_area_description',
                'home_page_06_'.$lang->slug.'_our_service_area_button_text',
            ];

            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_page_06_our_service_area_items',$request->home_page_06_our_service_area_items);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //counterup
    public function counterup_index(){
        return view('backend.pages.home.service-home.counterup');
    }

    public function counterup_update(Request  $request){
        $this->validate($request,[
            'home_06_counterup_bg_image' => 'nullable|string',
        ]);
        update_static_option('home_06_counterup_bg_image',$request->home_06_counterup_bg_image);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //work_process_index
    public function work_process_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.service-home.work-process')->with(['all_languages' => $all_languages]);
    }

    public function work_process_update(Request  $request){
        $this->validate($request,[
            'home_page_06_work_process_number' => 'required|array',
            'home_page_06_work_process_number.*' => 'required|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_06_'.$lang->slug.'_work_process_title' => 'required|array',
                'home_page_06_'.$lang->slug.'_work_process_title.*' => 'required|string',
                'home_page_06_'.$lang->slug.'_work_process_area_title' => 'nullable|string',
                'home_page_06_'.$lang->slug.'_work_process_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_06_'.$lang->slug.'_work_process_title',
                'home_page_06_'.$lang->slug.'_work_process_area_title',
                'home_page_06_'.$lang->slug.'_work_process_area_description',
            ];
            foreach ($all_fields as $field){
                if ($field == 'home_page_06_'.$lang->slug.'_work_process_title'){
                    update_static_option($field,serialize($request->$field));
                }else{
                    update_static_option($field,$request->$field);
                }
            }
        }

        update_static_option('home_page_06_work_process_number',serialize($request->home_page_06_work_process_number));

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    //news_area_index
    public function news_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.service-home.news-area')->with(['all_languages' => $all_languages]);
    }

    public function news_area_update(Request  $request){
        $this->validate($request,[
            'home_06_news_area_background_image' => 'required|string',
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_06_'.$lang->slug.'_news_area_read_more_text' => 'nullable|string',
                'home_page_06_'.$lang->slug.'_news_area_title' => 'nullable|string',
                'home_page_06_'.$lang->slug.'_news_area_description' => 'nullable|string',
            ]);
            $all_fields = [
                'home_page_06_'.$lang->slug.'_news_area_read_more_text',
                'home_page_06_'.$lang->slug.'_news_area_title',
                'home_page_06_'.$lang->slug.'_news_area_description',
            ];
            foreach ($all_fields as $field){
               update_static_option($field,$request->$field);
            }
        }

        update_static_option('home_06_news_area_background_image',$request->home_06_news_area_background_image);

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

    public function testimonial_area_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.service-home.testimonial')->with(['all_languages' => $all_languages]);
    }

    public function testimonial_area_update(Request  $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'home_page_06_'.$lang->slug.'_testimonial_area_title' => 'nullable|string'
            ]);
            $all_fields = [
                'home_page_06_'.$lang->slug.'_testimonial_area_title'
            ];
            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => __('Settings Updated'),'type' => 'success']);
    }

}
