<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class JobHomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function header_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.job-home.header')->with(['all_languages' => $all_languages]);
    }

    public function header_update(Request  $request){
        $this->validate($request,[
            'home_page_10_header_right_image' => 'nullable|string'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $all_fields = [
                'home_page_10_'.$lang->slug.'_header_title',
                'home_page_10_'.$lang->slug.'_header_description',
                'home_page_10_'.$lang->slug.'_header_search_placeholder',
                'home_page_10_'.$lang->slug.'_search_form_status'
            ];

            foreach ($all_fields as $field){
                update_static_option($field, $request->$field);
            }
        }

        update_static_option('home_page_10_header_right_image',$request->home_page_10_header_right_image);

        return redirect()->back()->with(['msg' => __('Settings Saved Successfully'),'type' => 'success']);
    }

    public function featured_job_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.job-home.featured-job')->with(['all_languages' => $all_languages]);
    }
    public function featured_job_update(Request  $request){
        $this->validate($request,[
            'home_page_10_featured_job_area_items' => 'nullable|string'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $all_fields = [
                'home_page_10_'.$lang->slug.'_featured_job_area_title',
                'home_page_10_'.$lang->slug.'_featured_job_area_description',
                'home_page_10_'.$lang->slug.'_featured_job_button_title',
            ];

            foreach ($all_fields as $field){
                update_static_option($field, $request->$field);
            }
        }

        update_static_option('home_page_10_featured_job_area_items',$request->home_page_10_featured_job_area_items);

        return redirect()->back()->with(['msg' => __('Settings Saved Successfully'),'type' => 'success']);
    }
    public function millions_job_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.job-home.millions-job')->with(['all_languages' => $all_languages]);
    }

    public function millions_job_update(Request  $request){
        $this->validate($request,[
            'home_page_10_million_job_area_image' => 'nullable|string'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $all_fields = [
                'home_page_10_'.$lang->slug.'_million_job_area_title',
                'home_page_10_'.$lang->slug.'_million_job_area_description',
            ];

            foreach ($all_fields as $field){
                update_static_option($field, $request->$field);
            }
        }

        update_static_option('home_page_10_million_job_area_image',$request->home_page_10_million_job_area_image);

        return redirect()->back()->with(['msg' => __('Settings Saved Successfully'),'type' => 'success']);
    }
    public function latest_job_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.job-home.latest-job')->with(['all_languages' => $all_languages]);
    }

    public function latest_job_update(Request  $request){
        $this->validate($request,[
            'home_page_10_million_job_area_image' => 'nullable|string'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $all_fields = [
                'home_page_10_'.$lang->slug.'_latest_job_area_title',
                'home_page_10_'.$lang->slug.'_latest_job_area_description',
                'home_page_10_'.$lang->slug.'_latest_job_button_title',
            ];

            foreach ($all_fields as $field){
                update_static_option($field, $request->$field);
            }
        }

        update_static_option('home_page_10_latest_job_area_items',$request->home_page_10_latest_job_area_items);

        return redirect()->back()->with(['msg' => __('Settings Saved Successfully'),'type' => 'success']);
    }

    public function testimonial_index(){
        $all_languages = Language::all();
        return view('backend.pages.home.job-home.testimonial')->with(['all_languages' => $all_languages]);
    }

    public function testimonial_update(Request  $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $all_fields = [
                'home_page_10_'.$lang->slug.'_testimonial_area_title',
            ];

            foreach ($all_fields as $field){
                update_static_option($field, $request->$field);
            }
        }
        return redirect()->back()->with(['msg' => __('Settings Saved Successfully'),'type' => 'success']);
    }
}
