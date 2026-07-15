<?php

namespace App\Http\Controllers;

use App\ImageGalleryCategory;
use App\Language;
use Illuminate\Http\Request;

class ImageGalleryCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_languages = Language::all();
        $all_category = ImageGalleryCategory::all()->groupBy('lang');

        return view('backend.image-gallery.image-gallery-category')->with([
            'all_languages' => $all_languages,
            'all_category' => $all_category,
        ]);
    }

    public function store(Request  $request){
        $this->validate($request,[
           'title' => 'required|string|max:191',
           'status' => 'required|string|max:191',
           'lang' => 'required|string|max:191',
        ]);

        ImageGalleryCategory::create([
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);
        return redirect()->back()->with(['msg' => __('New Category Added'),'type' => 'success']);
    }

    public function update(Request  $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
        ]);

        ImageGalleryCategory::find($request->id)->update([
            'title' => $request->title,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);
        return redirect()->back()->with(['msg' => __('Category Updated'),'type' => 'success']);
    }

    public function delete(Request $request,$id){
        ImageGalleryCategory::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Category Deleted'),'type' => 'danger']);
    }
    public function bulk_action(Request $request){
        $all = ImageGalleryCategory::find($request->ids);
        foreach($all as $item){
            if ($request->type == 'delete'){
                $item->delete();
            }else{
                $item->status = $request->type;
                $item->save();
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function get_cat_by_lang(Request  $request){
        $all_category = ImageGalleryCategory::where('lang',$request->lang)->get();

        return response()->json($all_category);
    }
}
