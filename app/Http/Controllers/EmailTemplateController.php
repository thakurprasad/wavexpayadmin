<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\EmailTemplate;
class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
         $this->middleware('permission:setting-list');
         $this->middleware('permission:setting-create', ['only' => ['create','store']]);
         $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = EmailTemplate::orderBy('title','ASC')->get();
        return view('email-templates.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email-templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'template_code' => 'required|unique:email_templates,template_code',
            'email_subject' => 'required',
            'email_content' => 'required',
        ]);
        $input = $request->all();
        $data = EmailTemplate::create($input);

        return redirect()->route('email-templates.index')
                        ->with('success','Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = EmailTemplate::find($id);
        return view('email-templates.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = EmailTemplate::find($id);
        return view('email-templates.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:200',
            'template_code' => 'required|unique:email_templates,template_code,'.$id,
            'email_subject' => 'required',
            'email_content' => 'required',
        ]);

        $input = $request->all();
        $data = EmailTemplate::find($id);
        $data->update($input);

        return redirect()->route('email-templates.index')
                        ->with('success','Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmailTemplate::find($id)->delete();
        return redirect()->route('email-templates.index')
                        ->with('success','Deleted successfully');
    }
}
