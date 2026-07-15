<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\Language;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;


class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_blog = Blog::all()->groupBy('lang');
        $all_category = BlogCategory::all()->groupBy('lang');
        $all_language = Language::all();
        
        return view('backend.pages.blog.blog-management')->with([
            'all_blog' => $all_blog,
            'all_category' => $all_category,
            'all_languages' => $all_language,
        ]);
    }
    public function new_blog(){
        $all_category = BlogCategory::where('lang',get_default_language())->get();
        $all_language = Language::all();
        return view('backend.pages.blog.new')->with([
            'all_category' => $all_category,
            'all_languages' => $all_language,
        ]);
    }
    public function store_new_blog(Request $request){
        $this->validate($request,[
           'category' => 'required',
           'blog_content' => 'required',
           'tags' => 'required',
           'excerpt' => 'required',
           'title' => 'required',
           'author' => 'required',
           'status' => 'required',
           'lang' => 'required',
           'slug' => 'nullable|string',
           'meta_tags' => 'nullable|string',
           'meta_description' => 'nullable|string',
           'image' => 'nullable|string|max:191',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Blog::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }
        Blog::create([
            'blog_categories_id' => $request->category,
            'content' => $request->blog_content,
            'tags' => $request->tags,
            'title' => $request->title,
            'slug' => $blog_slug ,
            'excerpt' => $request->excerpt,
            'lang' => $request->lang,
            'image' => $request->image,
            'meta_tags' => $request->meta_tags,
            'status' => $request->status,
            'meta_description' => $request->meta_description,
            'author' => $request->author,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->back()->with([
            'msg' => __('New Blog Post Added...'),
            'type' => 'success'
        ]);
    }
    public function edit_blog($id){
        $blog_post = Blog::find($id);
        $all_category = BlogCategory::where('lang',$blog_post->lang)->get();
        $all_language = Language::all();
        return view('backend.pages.blog.edit')->with([
            'all_category' => $all_category,
            'blog_post' => $blog_post,
            'all_languages' => $all_language,
        ]);
    }
    public function update_blog(Request $request,$id){
        $this->validate($request,[
            'category' => 'required',
            'blog_content' => 'required',
            'tags' => 'required',
            'excerpt' => 'required',
            'title' => 'required',
            'author' => 'required',
            'status' => 'required',
            'lang' => 'required',
            'slug' => 'nullable|string',
            'meta_tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|string|max:191',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        
        Blog::where('id',$id)->update([
            'blog_categories_id' => $request->category,
            'content' => $request->blog_content,
            'tags' => $request->tags,
            'title' => $request->title,
            'slug' => $blog_slug ,
            'excerpt' => $request->excerpt,
            'lang' => $request->lang,
            'image' => $request->image,
            'meta_tags' => $request->meta_tags,
            'status' => $request->status,
            'meta_description' => $request->meta_description,
            'author' => $request->author,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with([
            'msg' => __('Blog Post updated...'),
            'type' => 'success'
        ]);

    }
    public function delete_blog(Request $request,$id){
        Blog::find($id)->delete();

        return redirect()->back()->with([
            'msg' => __('Blog Post Delete Success...'),
            'type' => 'danger'
        ]);
    }
    public function clone_blog(Request $request)
    {
        $blog_details = Blog::find($request->item_id);
        $blog_slug = !empty($blog_details->slug) ? Str::slug($blog_details->slug) : Str::slug($blog_details->title);
        $check_slug = Blog::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }
        Blog::create([
            'blog_categories_id' => $blog_details->blog_categories_id,
            'slug' => $blog_slug,
            'content' => $blog_details->content,
            'tags' => $blog_details->tags,
            'title' => $blog_details->title,
            'status' => 'draft',
            'meta_tags' => $blog_details->meta_tags,
            'meta_description' => $blog_details->meta_description,
            'excerpt' => $blog_details->excerpt,
            'lang' => $blog_details->lang,
            'image' => $blog_details->image,
            'user_id' => Auth::user()->id,
            'author' => $blog_details->author,
        ]);

        return redirect()->back()->with([
            'msg' => __('Blog Post cloned success...'),
            'type' => 'success'
        ]);
    }
    public function category(){
        $all_category = BlogCategory::all()->groupBy('lang');
        $all_language = Language::all();
        return view('backend.pages.blog.category')->with([
            'all_category' => $all_category,
            'all_languages' => $all_language
        ]);
    }
    public function new_category(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191|unique:blog_categories',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        BlogCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => __('New Category Added...'),
            'type' => 'success'
        ]);
    }

    public function update_category(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        BlogCategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => __('Category Update Success...'),
            'type' => 'success'
        ]);
    }

    public function delete_category(Request $request,$id){
        if (Blog::where('blog_categories_id',$id)->first()){
            return redirect()->back()->with([
                'msg' => __('You Can Not Delete This Category, It Already Associated With A Post...'),
                'type' => 'danger'
            ]);
        }
        BlogCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Category Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function Language_by_slug(Request $request){
        $all_category = BlogCategory::where('lang',$request->lang)->get();

        return response()->json($all_category);
    }

    public function bulk_action(Request $request){
        $all = Blog::find($request->ids);
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
        $all = BlogCategory::find($request->ids);
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
