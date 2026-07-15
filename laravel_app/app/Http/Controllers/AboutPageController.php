<?php

namespace App\Http\Controllers;

use App\KnowAbout;
use App\Language;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function about_page_about_section(){
        $all_language = Language::all();
        $all_know_about_items = KnowAbout::all()->groupBy('lang');
        return view('backend.pages.about.about-management')->with([
            'all_languages' => $all_language,
            'all_know_about_items' => $all_know_about_items
        ]);
    }
    public function about_page_update_about_section(Request $request){

        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request ,[
                'about_page_'.$lang->slug.'_about_section_title' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_description' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_right_image' => 'nullable|string'
            ]);

            $image_filed = 'about_page_'.$lang->slug.'_about_section_right_image';
            update_static_option('about_page_'.$lang->slug.'_about_section_right_image', $request->$image_filed);

            $_about_section_title = 'about_page_'.$lang->slug.'_about_section_title';
            $_about_section_description = 'about_page_'.$lang->slug.'_about_section_description';

            update_static_option('about_page_'.$lang->slug.'_about_section_title',$request->$_about_section_title);
            update_static_option('about_page_'.$lang->slug.'_about_section_description',$request->$_about_section_description);
        }


        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
    public function about_page_know_about_section(){
        $all_language = Language::all();
        $all_know_about_items = KnowAbout::all()->groupBy('lang');
        return view('backend.pages.about.know-section')->with(['all_languages' => $all_language,'all_know_about_items' => $all_know_about_items]);
    }
    public function about_page_update_know_about_section(Request $request){
        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request ,[
                'about_page_'.$lang->slug.'_know_about_section_title' => 'nullable|string',
                'about_page_'.$lang->slug.'_know_about_section_description' => 'nullable|string',
            ]);
            $filed = 'about_page_'.$lang->slug.'_know_about_section_title';
            $filed_two = 'about_page_'.$lang->slug.'_know_about_section_description';

            update_static_option('about_page_'.$lang->slug.'_know_about_section_title',$request->$filed);
            update_static_option('about_page_'.$lang->slug.'_know_about_section_description',$request->$filed_two);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }

    public function about_page_section_manage(){
        return view('backend.pages.about.section-manage');
    }

    public function about_page_update_section_manage(Request $request){

        $this->validate($request,[
            'about_page_about_us_section_status' => 'nullable|string',
            'about_page_know_about_section_status' => 'nullable|string',
            'about_page_call_to_action_section_status' => 'nullable|string',
            'about_page_latest_news_section_status' => 'nullable|string',
            'about_page_brand_logo_section_status' => 'nullable|string',
            'about_page_team_member_section_status' => 'nullable|string',
            'about_page_testimonial_section_status' => 'nullable|string',
        ]);

        update_static_option('about_page_testimonial_section_status',$request->about_page_testimonial_section_status);
        update_static_option('about_page_about_us_section_status',$request->about_page_about_us_section_status);
        update_static_option('about_page_know_about_section_status',$request->about_page_know_about_section_status);
        update_static_option('about_page_call_to_action_section_status',$request->about_page_call_to_action_section_status);
        update_static_option('about_page_latest_news_section_status',$request->about_page_latest_news_section_status);
        update_static_option('about_page_brand_logo_section_status',$request->about_page_brand_logo_section_status);
        update_static_option('about_page_team_member_section_status',$request->about_page_team_member_section_status);

        return redirect()->back()->with([
            'msg' => 'Settings Updated...',
            'type' => 'success'
        ]);

    }

}
