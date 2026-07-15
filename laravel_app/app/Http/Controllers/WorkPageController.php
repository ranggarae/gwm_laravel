<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class WorkPageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function work_page_settings(){
        $all_languages = Language::all();
        return view('backend.pages.works.work-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_work_page_settings(Request  $request){
        $this->validate($request,[
            'work_page_items' => 'nullable|string'
        ]);

        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request,[
                'work_page_'.$lang->slug.'_all_cat_text' => 'nullable|string'
            ]);

            $fields = [
                'work_page_'.$lang->slug.'_all_cat_text'
            ];

            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        update_static_option('work_page_items',$request->work_page_items);

        return redirect()->back()->with([
            'msg' => __('Settings Updated'),
            'type' => 'success'
        ]);
    }

    public function work_single_page_settings(){
        $all_language = Language::all();
        return view('backend.pages.works.work-single-page-settings')->with(['all_languages' => $all_language]);
    }

    public function update_work_single_page_settings(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){

            $this->validate($request,[
                'work_single_page_'.$lang->slug.'_related_work_title' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_sidebar_title' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_start_date_text' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_end_date_text' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_clients_text' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_category_text' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_share_text' => 'nullable|string',
                'work_single_page_'.$lang->slug.'_gallery_title' => 'nullable|string',
            ]);
            $fields = [
                'work_single_page_'.$lang->slug.'_related_work_title',
                'work_single_page_'.$lang->slug.'_sidebar_title',
                'work_single_page_'.$lang->slug.'_start_date_text',
                'work_single_page_'.$lang->slug.'_end_date_text',
                'work_single_page_'.$lang->slug.'_clients_text',
                'work_single_page_'.$lang->slug.'_category_text',
                'work_single_page_'.$lang->slug.'_share_text',
                'work_single_page_'.$lang->slug.'_gallery_title',
            ];
            foreach ($fields as $field){
                update_static_option($field,$request->$field);
            }
        }

        return redirect()->back()->with(['msg' => 'Work Single Page Settings Update...','type' => 'success']);
    }

}
