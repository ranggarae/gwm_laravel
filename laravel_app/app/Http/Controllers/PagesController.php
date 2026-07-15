<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_page = Page::all()->groupBy('lang');
        $all_language = Language::all();
        return view('backend.pages.page.pages-management')->with([
            'all_page' => $all_page,
            'all_languages' => $all_language,
        ]);
    }
    public function new_page(){
        $all_language = Language::all();
        return view('backend.pages.page.new')->with(['all_languages' => $all_language]);
    }
    public function store_new_page(Request $request){
        $this->validate($request,[
            'content' => 'nullable',
            'meta_tags' => 'nullable',
            'meta_description' => 'nullable',
            'lang' => 'nullable',
            'title' => 'required',
            'status' => 'required|string|max:191',
            'slug' => 'nullable|string',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Page::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }

        Page::create([
            'lang' => $request->lang,
            'slug' => $blog_slug,
            'status' => $request->status,
            'content' => $request->page_content,
            'title' => $request->title,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->back()->with([
            'msg' => __('New Page Created...'),
            'type' => 'success'
        ]);
    }
    public function edit_page($id){
        $page_post = Page::find($id);
        $all_language = Language::all();
        return view('backend.pages.page.edit')->with([
            'page_post' => $page_post,
            'all_languages' => $all_language
        ]);
    }
    public function update_page(Request $request,$id){
        $this->validate($request,[
            'content' => 'nullable',
            'meta_tags' => 'nullable',
            'meta_description' => 'nullable',
            'lang' => 'nullable',
            'title' => 'required',
            'status' => 'required|string|max:191',
            'slug' => 'nullable|string',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Page::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }

        Page::where('id',$id)->update([
            'lang' => $request->lang,
            'slug' => $blog_slug,
            'status' => $request->status,
            'content' => $request->page_content,
            'title' => $request->title,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
        ]);


        return redirect()->back()->with([
            'msg' =>__( 'Page updated...'),
            'type' => 'success'
        ]);
    }
    public function delete_page(Request $request,$id){
        Page::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Page Delete Success...'),
            'type' => 'danger'
        ]);
    }
}
