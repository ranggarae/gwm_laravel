<?php

namespace App\Http\Controllers;

use App\Importantlink;
use App\Language;
use App\Menu;
use App\UsefulLink;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function about_widget(){
        $all_language = Language::all();
        return view('backend.pages.footer.about')->with(['all_languages' => $all_language]);
    }
    public function update_about_widget(Request $request){
        $this->validate($request,[
            'about_widget_logo' => 'nullable|string|max:191',
            'about_widget_social_icon_one' => 'string|max:191',
            'about_widget_social_icon_two' => 'string|max:191',
            'about_widget_social_icon_three' => 'string|max:191',
            'about_widget_social_icon_four' => 'string|max:191',
            'about_widget_social_icon_one_url' => 'string|max:191',
            'about_widget_social_icon_two_url' => 'string|max:191',
            'about_widget_social_icon_three_url' => 'string|max:191',
            'about_widget_social_icon_four_url' => 'string|max:191',
        ]);
        update_static_option('about_widget_social_icon_one',$request->about_widget_social_icon_one);
        update_static_option('about_widget_social_icon_two',$request->about_widget_social_icon_two);
        update_static_option('about_widget_social_icon_three',$request->about_widget_social_icon_three);
        update_static_option('about_widget_social_icon_four',$request->about_widget_social_icon_four);
        update_static_option('about_widget_social_icon_one_url',$request->about_widget_social_icon_one_url);
        update_static_option('about_widget_social_icon_two_url',$request->about_widget_social_icon_two_url);
        update_static_option('about_widget_social_icon_three_url',$request->about_widget_social_icon_three_url);
        update_static_option('about_widget_social_icon_four_url',$request->about_widget_social_icon_four_url);

        update_static_option('about_widget_logo',$request->about_widget_logo);

        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request,[
                'about_widget_'.$lang->slug.'_description' => 'nullable',
            ]);
            $field = 'about_widget_'.$lang->slug.'_description';

            update_static_option('about_widget_'.$lang->slug.'_description',$request->$field);
        }


        return redirect()->back()->with([
            'msg' => 'About Widget Update Success...',
            'type' => 'success'
        ]);
    }

    public function useful_links_widget(){
        $all_menu = Menu::where('lang','en')->get();
        $all_language = Language::all();
        return view('backend.pages.footer.useful-link')->with([
            'all_menu' => $all_menu,
            'all_languages' => $all_language,
        ]);
    }

    public function recent_post_widget(){
        $all_language = Language::all();
        return view('backend.pages.footer.recent-post')->with(['all_languages' => $all_language]);
    }
    public function update_recent_post_widget(Request $request){

        $this->validate($request,[
            'recent_post_widget_item' => 'required'
        ]);

        update_static_option('recent_post_widget_item',$request->recent_post_widget_item);

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'recent_post_'.$lang->slug.'_widget_title' => 'required',
            ]);
            $filed = 'recent_post_'.$lang->slug.'_widget_title';
            update_static_option('recent_post_'.$lang->slug.'_widget_title',$request->$filed);
        }

        return redirect()->back()->with([
            'msg' => 'Recent Post Widget Update Success...',
            'type' => 'success'
        ]);
    }

    public function update_widget_useful_links(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'useful_link_'.$lang->slug.'_widget_title' => 'nullable',
                'useful_link_'.$lang->slug.'_widget_menu_id' => 'nullable',
            ]);
            $filed = 'useful_link_'.$lang->slug.'_widget_title';
            $filed_two = 'useful_link_'.$lang->slug.'_widget_menu_id';
            update_static_option('useful_link_'.$lang->slug.'_widget_title',$request->$filed);
            update_static_option('useful_link_'.$lang->slug.'_widget_menu_id',$request->$filed_two);
        }

        return redirect()->back()->with([
            'msg' => 'Useful Widget Settings Success...',
            'type' => 'success'
        ]);
    }
    public function update_widget_important_links(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'important_link_'.$lang->slug.'_widget_title' => 'nullable',
                'important_link_'.$lang->slug.'_widget_menu_id' => 'nullable',
            ]);
            $filed = 'important_link_'.$lang->slug.'_widget_title';
            $filed_two = 'important_link_'.$lang->slug.'_widget_menu_id';
            update_static_option('important_link_'.$lang->slug.'_widget_title',$request->$filed);
            update_static_option('important_link_'.$lang->slug.'_widget_menu_id',$request->$filed_two);
        }

        return redirect()->back()->with([
            'msg' => 'Important Widget Settings Success...',
            'type' => 'success'
        ]);
    }


    public function important_links_widget(){
        $all_menu = Menu::where('lang' , 'en')->get();
        $all_language = Language::all();
        return view('backend.pages.footer.important-links')->with([
            'all_menu' => $all_menu,
            'all_languages' => $all_language,
        ]);
    }

    public function general_widget(){
        return view('backend.pages.footer.general');
    }
    public function update_general_widget(Request $request){
        $this->validate($request,[
            'footer_background_image' => 'mimes:jpg,jpeg,png|max:10064',
        ]);

        if ($request->hasFile('footer_background_image')){
            $image = $request->footer_background_image;
            $image_extenstion = $image->getClientOriginalExtension();
            $image_name = 'footer-background-image-'.rand(999,999999).'.'.$image_extenstion;
            if (check_image_extension($image)){
                $image->move('assets/uploads/',$image_name);
                update_static_option('footer_background_image',$image_name);
            }
        }

        return redirect()->back()->with([
            'msg' => 'General Settings Update Success...',
            'type' => 'success'
        ]);
    }

    public function useful_links_widget_menu_by_slug(Request $request){
        $all_menu = Menu::where('lang',$request->lang)->get();
        return response()->json($all_menu);
    }
    public function important_links_widget_menu_by_slug(Request $request){
        $all_menu = Menu::where('lang',$request->lang)->get();
        return response()->json($all_menu);
    }
}
