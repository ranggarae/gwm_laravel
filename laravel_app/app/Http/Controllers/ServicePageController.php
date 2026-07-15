<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class ServicePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function service_page_price_plan_section(){
        $all_language = Language::all();
        return view('backend.pages.service-page.pricing-section')->with(['all_language' => $all_language]);
    }
    public function service_page_update_price_plan_section(Request $request){
        $all_language = Language::all();

        foreach ($all_language as $lang){

            $this->validate($request,[
                'service_page_'.$lang->slug.'_price_plan_section_title' => 'required|string'
            ]);

            $field = 'service_page_'.$lang->slug.'_price_plan_section_title';
            update_static_option('service_page_'.$lang->slug.'_price_plan_section_title', $request->$field);
        }

        return redirect()->back()->with(['msg' => 'Settings Update Success','type' => 'success']);
    }
    public function service_page_cta_section(){
        $all_language = Language::all();
        return view('backend.pages.service-page.cta-section')->with(['all_language' => $all_language]);
    }
    public function service_page_update_cta_section(Request $request){
        $all_language = Language::all();

        foreach ($all_language as $lang){

            $this->validate($request,[
                'service_page_'.$lang->slug.'_cta_button_text' => 'nullable|string',
                'service_page_'.$lang->slug.'_cta_description' => 'nullable|string',
                'service_page_'.$lang->slug.'_cta_title' => 'required|string',
            ]);
            $_cta_button_text = 'service_page_'.$lang->slug.'_cta_button_text';
            $_cta_description = 'service_page_'.$lang->slug.'_cta_description';
            $_cta_title = 'service_page_'.$lang->slug.'_cta_title';
            $_cta_button_status = 'service_page_'.$lang->slug.'_cta_button_status';

            update_static_option('service_page_'.$lang->slug.'_cta_button_text', $request->$_cta_button_text);
            update_static_option('service_page_'.$lang->slug.'_cta_button_status', $request->$_cta_button_status);
            update_static_option('service_page_'.$lang->slug.'_cta_description', $request->$_cta_description);
            update_static_option('service_page_'.$lang->slug.'_cta_title', $request->$_cta_title);
        }



        return redirect()->back()->with(['msg' => 'Settings Update Success','type' => 'success']);
    }
}
