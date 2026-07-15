<?php

namespace App\Http\Controllers;

use App\ImageGallery;
use App\ImageGalleryCategory;
use App\Language;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_languages = Language::all();
        $all_gallery_images = ImageGallery::all()->groupBy('lang');
        $all_category = ImageGalleryCategory::where(['lang' => get_user_lang(),'status' => 'publish'])->get();

        return view('backend.image-gallery.image-gallery')->with([
            'all_languages' => $all_languages,
            'all_gallery_images' => $all_gallery_images,
            'all_category' => $all_category
        ]);
    }

    public function gallery_management(){
        $all_languages = Language::all();
        $all_gallery_images = ImageGallery::all()->groupBy('lang');
        $all_category = ImageGalleryCategory::where(['lang' => get_user_lang(),'status' => 'publish'])->get();
        $all_categories_list = ImageGalleryCategory::all()->groupBy('lang');

        return view('backend.image-gallery.gallery-management')->with([
            'all_languages' => $all_languages,
            'all_gallery_images' => $all_gallery_images,
            'all_category' => $all_category,
            'all_categories_list' => $all_categories_list
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'image' => 'required|string',
            'title' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'required|string',
            'lang' => 'required|string',
        ]);
        ImageGallery::create([
            'image' => $request->image,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);
        return redirect()->back()->with(['msg' => __('New Image Added...'),'type' => 'success']);
    }
    public function update(Request $request){
        $this->validate($request,[
            'image' => 'required|string',
            'title' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'required|string',
            'lang' => 'required|string',
        ]);
        ImageGallery::find($request->id)->update([
            'image' => $request->image,
            'title' => $request->title,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'lang' => $request->lang,
        ]);
        return redirect()->back()->with(['msg' => __('Image Updated...'),'type' => 'success']);
    }
    public function delete(Request $request,$id){
        ImageGallery::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Image Delete...'),'type' => 'danger']);
    }

    public function bulk_action(Request $request){
        $all = ImageGallery::find($request->ids);
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

}
