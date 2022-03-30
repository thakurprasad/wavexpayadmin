<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Page;
class PageController extends Controller
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
        $data = Page::orderBy('page_title','ASC')->get();
        return view('pages.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
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
            'page_title' => 'required|max:150',
            'url_aliase' => 'required|unique:contents,url_aliase',
            'meta_title' => 'required',
            'meta_keywords' => 'required',
        ]);
        $input = $request->all();
        $input['banner_image'] = 'banner.jpg	';
        if ($files = $request->file('banner_image')) {
            // Define upload path
            $destinationPath = public_path('/storage/banner/'); // upload path
         // Upload Orginal Image
            $bannerImage = 'banner_'.date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $bannerImage);
            $input['banner_image'] = $bannerImage;
        }
        $data = Page::create($input);

        return redirect()->route('pages.index')
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
        $data = Page::find($id);
        return view('pages.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Page::find($id);
        return view('pages.edit',compact('data'));
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
            'page_title' => 'required|max:150',
            'url_aliase' => 'required|unique:contents,url_aliase,'.$id,
            'meta_title' => 'required',
            'meta_keywords' => 'required',
        ]);

        $input = $request->all();
        if ($files = $request->file('bg_image')) {
            // Define upload path
            $destinationPath = public_path('/storage/banner/'); // upload path
         // Upload Orginal Image
            $bannerImage = 'banner_'.date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $bannerImage);
            $input['bg_image'] = $bannerImage;
        }
        $data = Page::find($id);
        $data->update($input);

        return redirect()->route('pages.index')
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
        Page::find($id)->delete();
        return redirect()->route('pages.index')
                        ->with('success','Deleted successfully');
    }
}
