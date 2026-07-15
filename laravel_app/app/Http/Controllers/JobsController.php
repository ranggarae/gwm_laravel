<?php

namespace App\Http\Controllers;

use App\JobApplicant;
use App\Jobs;
use App\JobsCategory;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function all_jobs(){
        $all_jobs = Jobs::all()->groupBy('lang');
        return view('backend.jobs.all-jobs')->with(['all_jobs' => $all_jobs]);
    }

    public function jobs_management(Request $request){
        $all_jobs = Jobs::all()->groupBy('lang');
        $all_languages = Language::all();
        $all_category = JobsCategory::all()->groupBy('lang');
        $all_category_flat = JobsCategory::where(['status' => 'publish','lang' => get_default_language()])->get();
        $all_applicant = JobApplicant::all();
        
        // Report logic
        $order_data = '';
        $jobs = Jobs::where(['status' => 'publish','lang' => get_default_language()])->get();
        $query = JobApplicant::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->job_id)){
            $query->where(['jobs_id' => $request->job_id ]);
        }
        $error_msg = __('select start & end date to generate applicant report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.jobs.jobs-management')->with([
            'all_jobs' => $all_jobs,
            'all_languages' => $all_languages,
            'all_category' => $all_category,
            'all_category_flat' => $all_category_flat,
            'all_applicant' => $all_applicant,
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'job_id' => $request->job_id,
            'jobs' => $jobs,
            'error_msg' => $error_msg
        ]);
    }

    public function edit_job($id){

        $job_post = Jobs::find($id);
        $all_category = JobsCategory::where(['status' => 'publish','lang' => $job_post->lang])->get();
        $all_language = Language::all();

        return view('backend.jobs.edit-job')->with([
            'all_languages' => $all_language,
            'all_category' => $all_category,
            'job_post' => $job_post
        ]);
    }

    public function new_job(){
        $all_category = JobsCategory::where(['status' => 'publish','lang' => get_default_language()])->get();
        $all_language = Language::all();
        return view('backend.jobs.new-job')->with(['all_languages' => $all_language,'all_category' => $all_category]);
    }

    public function store_job(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'position' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'vacancy' => 'required|string|max:191',
            'job_responsibility' => 'required|string',
            'employment_status' => 'required|string',
            'education_requirement' => 'nullable|string',
            'job_context' => 'nullable|string',
            'experience_requirement' => 'nullable|string',
            'additional_requirement' => 'nullable|string',
            'job_location' => 'required|string',
            'salary' => 'required|string',
            'lang' => 'required|string|max:191',
            'other_benefits' => 'nullable|string',
            'email' => 'nullable|string|max:191',
            'slug' => 'nullable|string|max:191',
            'status' => 'nullable|string|max:191',
            'deadline' => 'required|string|max:191',
            'is_featured' => 'nullable|string|max:191',
            'company_logo' => 'nullable|string|max:191',
        ]);
        $job_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Jobs::where('slug',$job_slug)->get();

        if (count($check_slug) > 0){
            $job_slug .= count($check_slug) + 1;
        }
        Jobs::create([
            'title' => $request->title,
            'position' => $request->position,
            'company_name' => $request->company_name,
            'category_id' => $request->category_id,
            'vacancy' => $request->vacancy,
            'job_responsibility' => $request->job_responsibility,
            'employment_status' => $request->employment_status,
            'education_requirement' => $request->education_requirement,
            'job_context' => $request->job_context,
            'experience_requirement' => $request->experience_requirement,
            'additional_requirement' => $request->additional_requirement,
            'job_location' => $request->job_location,
            'salary' => $request->salary,
            'lang' => $request->lang,
            'other_benefits' => $request->other_benefits,
            'slug' => $job_slug,
            'status' => $request->status,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
            'deadline' => $request->deadline,
            'is_featured' => $request->is_featured,
            'company_logo' => $request->company_logo,
        ]);

        return redirect()->back()->with(['msg' => __('New Job Post Added'),'type' => 'success']);
    }

    public function update_job(Request $request){
        $this->validate($request,[
            'title' => 'required|string',
            'position' => 'required|string|max:191',
            'company_name' => 'required|string|max:191',
            'category_id' => 'required|string|max:191',
            'vacancy' => 'required|string|max:191',
            'job_responsibility' => 'required|string',
            'employment_status' => 'required|string',
            'education_requirement' => 'nullable|string',
            'job_context' => 'nullable|string',
            'experience_requirement' => 'nullable|string',
            'additional_requirement' => 'nullable|string',
            'job_location' => 'required|string',
            'salary' => 'required|string',
            'lang' => 'required|string|max:191',
            'other_benefits' => 'nullable|string',
            'email' => 'nullable|string|max:191',
            'slug' => 'nullable|string|max:191',
            'status' => 'nullable|string|max:191',
            'is_featured' => 'nullable|string|max:191',
            'company_logo' => 'nullable|string|max:191',
            'deadline' => 'required|string|max:191',
        ]);
        $job_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $check_slug = Jobs::where('slug',$job_slug)->get();

        if (count($check_slug) > 0){
            $job_slug .= count($check_slug) + 1;
        }
        Jobs::find($request->job_id)->update([
            'title' => $request->title,
            'position' => $request->position,
            'company_name' => $request->company_name,
            'category_id' => $request->category_id,
            'vacancy' => $request->vacancy,
            'job_responsibility' => $request->job_responsibility,
            'employment_status' => $request->employment_status,
            'education_requirement' => $request->education_requirement,
            'job_context' => $request->job_context,
            'experience_requirement' => $request->experience_requirement,
            'additional_requirement' => $request->additional_requirement,
            'job_location' => $request->job_location,
            'salary' => $request->salary,
            'lang' => $request->lang,
            'other_benefits' => $request->other_benefits,
            'slug' => $job_slug,
            'status' => $request->status,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
            'deadline' => $request->deadline,
            'is_featured' => $request->is_featured,
            'company_logo' => $request->company_logo,
        ]);

        return redirect()->back()->with(['msg' => __('Job Post Update Success...'),'type' => 'success']);
    }
    public function clone(Request $request){

        $job_post = Jobs::find($request->item_id);
        $job_slug = $job_post->slug.'1';

        Jobs::create([
            'title' => $job_post->title,
            'position' => $job_post->position,
            'company_name' => $job_post->company_name,
            'category_id' => $job_post->category_id,
            'vacancy' => $job_post->vacancy,
            'job_responsibility' => $job_post->job_responsibility,
            'employment_status' => $job_post->employment_status,
            'education_requirement' => $job_post->education_requirement,
            'job_context' => $job_post->job_context,
            'experience_requirement' => $job_post->experience_requirement,
            'additional_requirement' => $job_post->additional_requirement,
            'job_location' => $job_post->job_location,
            'salary' => $job_post->salary,
            'lang' => $job_post->lang,
            'other_benefits' => $job_post->other_benefits,
            'slug' => $job_slug,
            'status' => 'draft',
            'meta_tags' => $job_post->meta_tags,
            'meta_description' => $job_post->meta_description,
            'deadline' => $job_post->deadline,
            'is_featured' => $job_post->is_featured,
            'company_logo' => $job_post->company_logo,
        ]);

        return redirect()->back()->with(['msg' => __('Job Clone Success...'),'type' => 'success']);
    }

    public function delete_job(Request $request,$id){
        Jobs::find($id)->delete();

        return redirect()->back()->with(['msg' => __('Job Post Deleted Success'),'type' => 'danger']);
    }
    public function page_settings(){
        $all_languages = Language::all();
        return view('backend.jobs.job-page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request){
        $this->validate($request,[
           'site_job_post_items' => 'required|string|max:191'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request,[
               'site_jobs_category_'.$lang->slug.'_title'  => 'nullable|string'
            ]);
            $all_fields = [
                'site_jobs_category_'.$lang->slug.'_title',
            ];
            foreach ($all_fields as $file){
                update_static_option($file,$request->$file);
            }
        }
        update_static_option('site_job_post_items',$request->site_job_post_items);
        update_static_option('job_applicant_mail',$request->job_applicant_mail);

        return redirect()->back()->with(['msg' => __('Job Page Settings Success...'),'type' => 'success']);
    }

    public function bulk_action(Request $request){
        $all = Jobs::find($request->ids);
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
    public function job_applicant_bulk_delete(Request $request){
        $all = JobApplicant::find($request->ids);
        foreach($all as $item){
           $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function all_jobs_applicant(){
        $all_applicant = JobApplicant::all();
        return view('backend.jobs.all-applicant')->with(['all_applicant' => $all_applicant]);
    }

    public function delete_job_applicant(Request $request,$id){
        $job_details = JobApplicant::find($id);
        $all_attachment = unserialize($job_details->attachment);
        foreach($all_attachment as $name => $path){
            if(file_exists($path)){
                @unlink($path);
            }
        }
        JobApplicant::find($id)->delete();
        return redirect()->back()->with(['msg' => __('Job Application Delete Success...'),'type' => 'danger']);
    }

    public function job_applicant_report(Request  $request){
        $order_data = '';
        $jobs = Jobs::where(['status' => 'publish','lang' => get_default_language()])->get();
        $query = JobApplicant::query();
        if (!empty($request->start_date)){
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if (!empty($request->end_date)){
            $query->whereDate('created_at','<=',$request->end_date);
        }
        if (!empty($request->job_id)){
            $query->where(['jobs_id' => $request->job_id ]);
        }
        $error_msg = __('select start & end date to generate applicant report');
        if (!empty($request->start_date) && !empty($request->end_date)){
            $query->orderBy('id','DESC');
            $order_data =  $query->paginate($request->items);
            $error_msg = '';
        }

        return view('backend.jobs.applicant-report')->with([
            'order_data' => $order_data,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'items' => $request->items,
            'job_id' => $request->job_id,
            'jobs' => $jobs,
            'error_msg' => $error_msg
        ]);
    }

}
