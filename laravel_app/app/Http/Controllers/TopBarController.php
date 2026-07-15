<?php

namespace App\Http\Controllers;

use App\Language;
use App\Menu;
use App\SocialIcons;
use App\SupportInfo;
use Illuminate\Http\Request;

class TopBarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_social_icons = SocialIcons::all();
        $all_support_info = SupportInfo::all()->groupBy('lang');
        $all_language = Language::all();
        $all_menu = Menu::where('lang','en')->get();
        return view('backend.pages.top-bar')->with([
            'all_social_icons' => $all_social_icons,
            'all_support_info' => $all_support_info,
            'all_languages' => $all_language,
            'all_menu' => $all_menu,
        ]);
    }
    public function new_support_info(Request $request){
        $this->validate($request,[
            'details' => 'required|string',
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'icon' => 'required|string|max:191'
        ]);

        SupportInfo::create($request->all());

        return redirect()->back()->with([
            'msg' => __('New Support Info Item Added..'),
            'type' => 'success'
        ]);
    }
    public function update_support_info(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'details' => 'required|string',
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'icon' => 'required|string|max:191'
        ]);

        SupportInfo::find($request->id)->update([
            'details' => $request->details,
            'lang' => $request->lang,
            'title' => $request->title,
            'icon' => $request->icon,
        ]);
        return redirect()->back()->with([
            'msg' => __('Support Info Item Updated..'),
            'type' => 'success'
        ]);
    }
    public function delete_support_info(Request $request,$id){

        SupportInfo::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Support Info Item Deleted..'),
            'type' => 'danger'
        ]);
    }

    public function new_social_item(Request $request){
        $this->validate($request,[
           'icon' => 'required|string',
           'url' => 'required|string',
        ]);

        SocialIcons::create($request->all());

        return redirect()->back()->with([
            'msg' => __('New Social Item Added...'),
            'type' => 'success'
        ]);
    }
    public function update_social_item(Request $request){
        $this->validate($request,[
           'icon' => 'required|string',
           'url' => 'required|string',
        ]);

        SocialIcons::find($request->id)->update([
            'icon' => $request->icon,
            'url' => $request->url,
        ]);

        return redirect()->back()->with([
            'msg' => __('Social Item Updated...'),
            'type' => 'success'
        ]);
    }
    public function delete_social_item(Request $request,$id){
        SocialIcons::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Social Item Deleted...'),
            'type' => 'danger'
        ]);
    }

    public function update_top_menu(Request $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'top_bar_'.$lang->slug.'_right_menu' => 'nullable|string|max:191'
            ]);
            $filed = 'top_bar_'.$lang->slug.'_right_menu';
            update_static_option('top_bar_'.$lang->slug.'_right_menu',$request->$filed);
        }

        return redirect()->back()->with(['msg' => __('Settings Updated...'),'type' => 'success']);
    }
    public function update_top_button(Request $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
                'top_bar_'.$lang->slug.'_button_text' => 'nullable|string|max:191'
            ]);
            $filed = 'top_bar_'.$lang->slug.'_button_text';
            update_static_option('top_bar_'.$lang->slug.'_button_text',$request->$filed);
        }

        update_static_option('top_bar_get_quote_btn_status',$request->top_bar_get_quote_btn_status);

        return redirect()->back()->with(['msg' => __('Settings Updated...'),'type' => 'success']);
    }

    public function top_menu(Request $request){
        $all_menus = Menu::where('lang',$request->lang)->get();
        return response()->json($all_menus);
    }
}
