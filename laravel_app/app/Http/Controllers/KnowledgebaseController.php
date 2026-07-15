<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Knowledgebase;
use App\KnowledgebaseTopic;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KnowledgebaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_knowledgebases(){
        $all_articles = Knowledgebase::all()->groupBy('lang');
        return view('backend.knowledgebase.all-knowledgebase')->with(['all_article' => $all_articles]);
    }

    public function knowledgebase_management(Request $request){
        $all_articles = Knowledgebase::all()->groupBy('lang');
        $all_languages = Language::all();
        $all_category = KnowledgebaseTopic::all()->groupBy('lang');
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => get_default_language()])->get();

        return view('backend.knowledgebase.knowledgebase-management')->with([
            'all_article' => $all_articles,
            'all_languages' => $all_languages,
            'all_category' => $all_category,
            'all_topics' => $all_topics
        ]);
    }

    public function new_knowledgebase(){
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => get_default_language()])->get();

        return view('backend.knowledgebase.new-knowledgebase')->with(['all_languages' => $all_languages,'all_topics' => $all_topics]);
    }

    public function store_knowledgebases(Request $request){
        $this->validate($request,[
           'title' => 'required|string',
           'kncontent' => 'required|string',
           'topic_id' => 'required|string|max:191',
           'status' => 'required|string|max:191',
           'slug' => 'nullable|string',
           'meta_description' => 'nullable|string',
           'meta_tags' => 'nullable|string',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Knowledgebase::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }
        Knowledgebase::create([
            'title' => $request->title,
            'content' => $request->kncontent,
            'topic_id' => $request->topic_id,
            'status' => $request->status,
            'slug' => $blog_slug,
            'lang' => $request->lang,
            'meta_description' => $request->meta_description,
            'meta_tags' => $request->meta_tags,
        ]);
        return redirect()->back()->with(['msg' => __('New Article Added Success...'),'type' => 'success']);
    }

    public function edit_knowledgebases($id){
        $articles = Knowledgebase::find($id);
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => $articles->lang])->get();

        return view('backend.knowledgebase.edit-knowledgebase')->with(['articles' => $articles,'all_languages' => $all_languages,'all_topics' => $all_topics]);
    }
    public function update_knowledgebases(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'kncontent' => 'required|string',
            'topic_id' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'slug' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_tags' => 'nullable|string',
        ]);
        $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
    
        Knowledgebase::find($request->article_id)->update([
            'title' => $request->title,
            'content' => $request->kncontent,
            'topic_id' => $request->topic_id,
            'status' => $request->status,
            'slug' => $blog_slug,
            'lang' => $request->lang,
            'meta_description' => $request->meta_description,
            'meta_tags' => $request->meta_tags,
        ]);

        return redirect()->back()->with(['msg' => __('Article Update Success...'),'type' => 'success']);
    }

    public function clone_knowledgebases(Request  $request){

        $article = Knowledgebase::find($request->item_id);
        $blog_slug = !empty($article->slug) ? Str::slug($article->slug) : Str::slug($article->title);
        $check_slug = Knowledgebase::where('slug',$blog_slug)->get();

        if (count($check_slug) > 0){
            $blog_slug .= count($check_slug) + 1;
        }

        Knowledgebase::create([
            'title' => $article->title,
            'content' => $article->content,
            'topic_id' => $article->topic_id,
            'status' => 'draft',
            'slug' => $blog_slug,
            'lang' => $article->lang,
            'meta_description' => $article->meta_description,
            'meta_tags' => $article->meta_tags,
        ]);

        return redirect()->back()->with(['msg' => __('Article Clone Success...'),'type' => 'success']);
    }

    public function page_settings(){
        $all_languages = Language::all();
        $all_topics = KnowledgebaseTopic::where(['status' =>'publish','lang' => get_default_language()])->get();
        return view('backend.knowledgebase.knowledgebase-page-settings')->with(['all_languages' => $all_languages,'all_topics' => $all_topics]);
    }

    public function update_page_settings(Request $request){
        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_knowledgebase_category_' . $lang->slug . '_title' => 'nullable',
                'site_knowledgebase_popular_widget_' . $lang->slug . '_title' => 'nullable',
                'site_knowledgebase_article_topic_' . $lang->slug . '_title' => 'nullable',
            ]);
            $knowledgebase_category = 'site_knowledgebase_category_' . $lang->slug . '_title';
            $knowledgebase_popular = 'site_knowledgebase_popular_widget_' . $lang->slug . '_title';
            $knowledgebase_article = 'site_knowledgebase_article_topic_' . $lang->slug . '_title';

            update_static_option($knowledgebase_category, $request->$knowledgebase_category);
            update_static_option($knowledgebase_popular, $request->$knowledgebase_popular);
            update_static_option($knowledgebase_article, $request->$knowledgebase_article);
        }

        update_static_option('site_knoeledgebase_post_items',$request->site_knoeledgebase_post_items);

        return redirect()->back()->with(['msg' => __('Knowledgebase Page Settings Update Success...'),'type' => 'success']);
    }

    public function bulk_action(Request $request){
        $all = Knowledgebase::find($request->ids);
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

    public function delete_knowledgebases(Request $request,$id){
        Knowledgebase::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Article Delete Success'),'type' => 'danger']);
    }

}
