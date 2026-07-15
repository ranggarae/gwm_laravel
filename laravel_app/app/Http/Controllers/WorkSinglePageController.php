<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class WorkSinglePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function work_single_page_settings(){
        $all_language = Language::all();
        return view('backend.pages.work-page.work-single-settings')->with(['all_languages' => $all_language]);
    }

    public function update_work_single_page_settings(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){

            $this->validate($request,[
                'work_single_page_'.$lang->slug.'_related_work_title' => 'nullable|string'
            ]);
            $_related_work_title = 'work_single_page_'.$lang->slug.'_related_work_title';
            update_static_option($_related_work_title,$request->$_related_work_title);
        }

        return redirect()->back()->with(['msg' => 'Work Single Page Settings Update...','type' => 'success']);
    }
}
