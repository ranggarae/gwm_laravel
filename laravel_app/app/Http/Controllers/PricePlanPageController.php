<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class PricePlanPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function price_plan_page_settings(){
        $all_languages = Language::all();
        return view('backend.pages.price-plan-page.price-plan-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_price_plan_page_settings(Request $request){
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'price_plan_page_'.$lang->slug.'_section_description' => 'nullable|string',
                'price_plan_page_'.$lang->slug.'_section_title' => 'nullable|string',
            ]);
            $section_title =  'price_plan_page_'.$lang->slug.'_section_title';
            $section_description =  'price_plan_page_'.$lang->slug.'_section_description';

            update_static_option($section_title,$request->$section_title);
            update_static_option($section_description,$request->$section_description);
        }

        update_static_option('price_plan_page_items',$request->price_plan_page_items);
        return redirect()->back()->with(['msg' => 'Price Plan Page Updated...','type' => 'success']);
    }
}
