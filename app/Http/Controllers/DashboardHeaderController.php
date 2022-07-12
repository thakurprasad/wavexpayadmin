<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Page;
use App\Models\DashBoardHeader;
class DashboardHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        /* $this->middleware('permission:setting-list');
         $this->middleware('permission:setting-create', ['only' => ['create','store']]);
         $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:setting-delete', ['only' => ['destroy']]);*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = DashboardHeader::orderBy('title','ASC')->get();
        return view('dashboardheader.index',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DashboardHeader::find($id);
        return view('dashboardheader.edit',compact('data'));
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
            'title' => 'required|max:150',
            'description' => 'required',
        ]);

        $input = $request->all();
        
        $data = DashboardHeader::find($id);
        $data->update($input);

        return redirect()->route('dashboardheader.index')
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
        DashboardHeader::find($id)->delete();
        return redirect()->route('pages.index')
                        ->with('success','Deleted successfully');
    }
}
