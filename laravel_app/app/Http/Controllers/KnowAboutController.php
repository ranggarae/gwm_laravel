<?php

namespace App\Http\Controllers;

use App\KeyFeatures;
use App\KnowAbout;
use App\Language;
use Illuminate\Http\Request;

class KnowAboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'link' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'description' => 'required|string',
            'image' => 'nullable|string|max:191'
        ]);
        KnowAbout::create($request->all());

        return redirect()->back()->with(['msg' => 'New Know About Item Added...','type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'link' => 'required|string|max:191',
            'description' => 'required|string',
            'image' => 'nullable|string|max:191'
        ]);
        KnowAbout::find($request->id)->update($request->all());

        return redirect()->back()->with(['msg' => 'Know About Item Updated...','type' => 'success']);
    }

    public function delete($id){

       KnowAbout::find($id)->delete();

        return redirect()->back()->with(['msg' => 'Delete Success...','type' => 'danger']);
    }

}
