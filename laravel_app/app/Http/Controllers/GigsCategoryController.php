<?php

namespace App\Http\Controllers;

use App\GigsCategory;
use App\Language;
use Illuminate\Http\Request;

class GigsCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_category = GigsCategory::all()->groupBy('lang');
        return view('backend.gigs.gigs-category')->with(['all_category' => $all_category]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'icon_type' => 'required|string|max:191',
            'icon' => 'nullable|string|max:191',
            'img_icon' => 'nullable|string|max:191',
        ]);

        GigsCategory::create([
            'name' => $request->name,
            'lang' => $request->lang,
            'status' => $request->status,
            'icon_type' => $request->icon_type,
            'icon' => $request->icon,
            'img_icon' => $request->img_icon,
        ]);

        return redirect()->back()->with([
            'msg' => __('New Category Added...'),
            'type' => 'success'
        ]);
    }

    public function update(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'icon_type' => 'required|string|max:191',
            'icon' => 'nullable|string|max:191',
            'img_icon' => 'nullable|string|max:191',
        ]);

        GigsCategory::find($request->id)->update([
            'name' => $request->name,
            'lang' => $request->lang,
            'status' => $request->status,
            'icon_type' => $request->icon_type,
            'icon' => $request->icon,
            'img_icon' => $request->img_icon,
        ]);

        return redirect()->back()->with([
            'msg' => __('Category Update Success...'),
            'type' => 'success'
        ]);
    }

    public function delete(Request $request,$id){
//        if (GigsCategory::where('categories_id',$id)->first()){
//            return redirect()->back()->with([
//                'msg' => __('You Can Not Delete This Category, It Already Associated With A Gigs...'),
//                'type' => 'danger'
//            ]);
//        }
        GigsCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __( 'Category Delete Success...'),
            'type' => 'danger'
        ]);
    }

    public function get_cat_by_lang(Request $request){
        $service_category = GigsCategory::where(['status' => 'publish','lang' => $request->lang])->get();
        return response()->json($service_category);
    }

    public function bulk_action(Request $request){

        $all = GigsCategory::find($request->ids);
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


