<?php

namespace App\Http\Controllers;

use App\HeaderSlider;
use App\Language;
use Illuminate\Http\Request;

class HeaderSliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){

        $all_header_slider = HeaderSlider::all()->groupBy('lang');
        $all_language = Language::all();
        return view('backend.pages.home.header')->with(['all_header_slider' => $all_header_slider,'all_languages' => $all_language]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'btn_01_text' => 'nullable|string|max:191',
            'btn_01_url' => 'nullable|string|max:191',
            'btn_01_status' => 'nullable|string|max:191',
            'description' => 'required|string',
            'image' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191'
        ]);

        HeaderSlider::create([
            'title' => $request->title,
            'btn_01_text' => $request->btn_01_text,
            'btn_01_url' => $request->btn_01_url,
            'btn_01_status' => $request->btn_01_status,
            'description' => $request->description,
            'image' => $request->image,
            'lang' => $request->lang
        ]);

        return redirect()->back()->with(['msg' => __('New Header Slider Added...'),'type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'nullable|string|max:191',
            'btn_01_text' => 'nullable|string|max:191',
            'btn_01_url' => 'nullable|string|max:191',
            'btn_01_status' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191'
        ]);

        HeaderSlider::find($request->id)->update([
            'title' => $request->title,
            'btn_01_text' => $request->btn_01_text,
            'btn_01_url' => $request->btn_01_url,
            'btn_01_status' => $request->btn_01_status,
            'description' => $request->description,
            'image' => $request->image,
            'lang' => $request->lang
        ]);

        return redirect()->back()->with(['msg' => __('Header Slider Updated...'),'type' => 'success']);
    }

    public function delete($id){

        HeaderSlider::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Delete Success...'),'type' => 'danger']);
    }
}
