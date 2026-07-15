<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class QuotePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_language = Language::all();
        return view('backend.pages.quote-page.form-section')->with(['all_languages' => $all_language]);
    }

    public function udpate(Request $request){
        $this->validate($request,[
            'quote_page_form_mail' => 'nullable|string',
        ]);
        $all_language = Language::all();

        foreach ($all_language as $lang){

            $this->validate($request,[
                'quote_page_'.$lang->slug.'_form_title' => 'nullable|string',
                'quote_page_'.$lang->slug.'_page_title' => 'nullable|string'
            ]);

            $_form_title = 'quote_page_'.$lang->slug.'_form_title';
            $_page_title = 'quote_page_'.$lang->slug.'_page_title';

            update_static_option('quote_page_'.$lang->slug.'_form_title',$request->$_form_title);
            update_static_option('quote_page_'.$lang->slug.'_page_title',$request->$_page_title);
        }

        update_static_option('quote_page_form_mail',$request->quote_page_form_mail);

        return redirect()->back()->with(['msg' => 'Settings Updated....','type' => 'success']);
    }
}
