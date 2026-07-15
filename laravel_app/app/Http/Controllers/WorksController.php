<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Language;
use App\Works;
use App\WorksCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class WorksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_works = Works::all()->groupBy('lang');
        return view('backend.pages.works.index')->with([
            'all_works' => $all_works
        ]);
    }

    public function works_management()
    {
        $all_works = Works::all()->groupBy('lang');
        $all_category = WorksCategory::all()->groupBy('lang');
        $all_languages = Language::all();
        $work_category_flat = WorksCategory::where(['status' => 'publish', 'lang' => get_default_language()])->get();

        return view('backend.pages.works.works-management')->with([
            'all_works' => $all_works,
            'all_category' => $all_category,
            'all_languages' => $all_languages,
            'works_category' => $work_category_flat
        ]);
    }

    public function edit(Request  $request,$id){
        $work_item = Works::find($id);
        $work_category = WorksCategory::where(['status'=> 'publish','lang' => get_default_language()])->get();
        $all_language = Language::all();
        return view('backend.pages.works.work-edit')->with([
            'works_category' => $work_category,
            'all_language' => $all_language,
            'work_item' => $work_item
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'start_date' => 'nullable|string|max:191',
            'end_date' => 'nullable|string|max:191',
            'lang' => 'nullable|string|max:191',
            'slug' => 'nullable|string|max:191',
            'clients' => 'nullable|string',
            'description' => 'required|string',
            'categories_id' => 'required',
            'image' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'meta_tags' => 'nullable|string|max:191',
            'status' => 'required|string|max:191',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Works::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }

        Works::create([
            'title' => $request->title,
            'slug' => $blog_slug,
            'gallery' => $request->gallery,
            'meta_description' => $request->meta_description,
            'meta_tags' => $request->meta_tags,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'lang' => $request->lang,
            'clients' => $request->clients,
            'description' => $request->description,
            'image' => $request->image,
            'status' => $request->status,
            'categories_id' => serialize($request->categories_id),
        ]);

        return redirect()->back()->with(['msg' => __('New work Added...'), 'type' => 'success']);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'start_date' => 'nullable|string|max:191',
            'end_date' => 'nullable|string|max:191',
            'lang' => 'nullable|string|max:191',
            'slug' => 'nullable|string|max:191',
            'clients' => 'nullable|string',
            'description' => 'required|string',
            'categories_id' => 'required',
            'image' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'meta_tags' => 'nullable|string|max:191',
            'status' => 'required|string|max:191',
        ]);

        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);

        Works::find($request->id)->update(
            [
                'title' => $request->title,
                'slug' => $blog_slug,
                'gallery' => $request->gallery,
                'meta_description' => $request->meta_description,
                'meta_tags' => $request->meta_tags,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'lang' => $request->lang,
                'clients' => $request->clients,
                'description' => $request->description,
                'image' => $request->image,
                'status' => $request->status,
                'categories_id' => serialize($request->categories_id),
            ]
        );
        return redirect()->back()->with(['msg' => __('Works Item Updated...'), 'type' => 'success']);
    }

    public function clone(Request $request){
        $work_item = Works::find($request->item_id);

        $blog_slug = $work_item->slug;

        $check_slug = Works::where('slug',$work_item->slug)->get();
        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }
        Works::find($work_item->id)->update(
            [
                'title' => $work_item->title,
                'slug' => $blog_slug,
                'gallery' => $work_item->gallery,
                'meta_description' => $work_item->meta_description,
                'meta_tags' => $work_item->meta_tags,
                'start_date' => $work_item->start_date,
                'end_date' => $work_item->end_date,
                'lang' => $work_item->lang,
                'clients' => $work_item->clients,
                'description' => $work_item->description,
                'image' => $work_item->image,
                'status' => 'draft',
                'categories_id' => serialize($work_item->categories_id),
            ]
        );

        return redirect()->back()->with(['msg' => __('Clone Success...'), 'type' => 'danger']);
    }
    public function delete($id)
    {
        Works::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Delete Success...'), 'type' => 'danger']);
    }

    public function new_work(){
        $work_category = WorksCategory::where(['status'=> 'publish','lang' => get_default_language()])->get();
        $all_language = Language::all();
        return view('backend.pages.works.work-new')->with([
            'works_category' => $work_category,
            'all_language' => $all_language,
        ]);
    }
    public function category_index()
    {
        $all_category = WorksCategory::all()->groupBy('lang');
        return view('backend.pages.works.category')->with(['all_category' => $all_category]);
    }

    public function category_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Category Added...',
            'type' => 'success'
        ]);
    }

    public function category_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => __('Category Update Success...'),
            'type' => 'success'
        ]);
    }

    public function category_delete(Request $request, $id)
    {
        if (Works::where('categories_id', $id)->first()) {
            return redirect()->back()->with([
                'msg' => __('You Can Not Delete This Category, It Already Associated With A Works ...'),
                'type' => 'danger'
            ]);
        }
        WorksCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Category Delete Success...'),
            'type' => 'danger'
        ]);
    }

    public function category_by_slug(Request $request){
        $all_category = WorksCategory::where('lang',$request->lang)->get();
        return response()->json($all_category);
    }

    public function bulk_action(Request $request){
        $all = Works::find($request->ids);
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

    public function category_bulk_action(Request $request){
        $all = WorksCategory::find($request->ids);
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


