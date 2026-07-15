<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function contact_page_form_area(){
        $all_language = Language::all();
        $all_contact_info = \App\ContactInfoItem::all()->groupBy('lang');
        return view('backend.pages.contact-page.contact-management')->with([
            'all_languages' => $all_language,
            'all_contact_info' => $all_contact_info
        ]);
    }
    public function contact_page_update_form_area(Request $request){

        $this->validate($request,[
            'contact_page_form_email' => 'required|email'
        ]);
        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'contact_page_'.$lang->slug.'_form_section_title' => 'nullable|string',
                'contact_page_'.$lang->slug.'_form_section_description' => 'nullable|string'
            ]);
            $field = 'contact_page_'.$lang->slug.'_form_section_title';
            $field_two = 'contact_page_'.$lang->slug.'_form_section_description';

            update_static_option('contact_page_'.$lang->slug.'_form_section_title',$request->$field);
            update_static_option('contact_page_'.$lang->slug.'_form_section_description',$request->$field_two);
        }
        update_static_option('contact_page_form_email',$request->contact_page_form_email);

        return redirect()->back()->with(['msg' => __('Settings Updated..'),'type' => 'success']);
    }
    public function contact_page_map_area(){
        return view('backend.pages.contact-page.google-map-section');
    }
    public function contact_page_update_map_area(Request $request){
        $this->validate($request,[
            'contact_page_map_section_address' => 'required|string',
        ]);
        update_static_option('contact_page_map_section_address',$request->contact_page_map_section_address);

        return redirect()->back()->with(['msg' => __('Settings Updated..'),'type' => 'success']);
    }

    public function contact_page_section_manage(){
        return view('backend.pages.contact-page.section-manage');
    }
    public function contact_page_update_section_manage(Request $request){
        $this->validate($request,[
            'contact_page_form_section_status' => 'nullable|string',
            'contact_page_contact_info_section_status' => 'nullable|string',
            'contact_page_google_map_section_status' => 'nullable|string',
        ]);
        $all_fields = [
            'contact_page_form_section_status',
            'contact_page_contact_info_section_status',
            'contact_page_google_map_section_status'
        ];

        foreach ($all_fields as $field){
            update_static_option($field,$request->$field);
        }

        return redirect()->back()->with(['msg' => __('Settings Updated...'), 'type' => 'success']);
    }
}
