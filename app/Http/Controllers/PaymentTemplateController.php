<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\PaymentTemplate;
class PaymentTemplateController extends Controller
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
        $data = PaymentTemplate::orderBy('title','ASC')->get();
        return view('payment-templates.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-templates.create');
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
            'payment_type' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        $input['bg_image'] = 'template.jpg';
        if ($files = $request->file('bg_image')) {
            // Define upload path
            $destinationPath = public_path('/storage/template/'); // upload path
         // Upload Orginal Image
            $bannerImage = 'template_'.date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $bannerImage);
            $input['bg_image'] = $bannerImage;
        }
        $data = PaymentTemplate::create($input);

        return redirect()->route('payment-templates.index')
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
        $data = PaymentTemplate::find($id);
        return view('payment-templates.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PaymentTemplate::find($id);
        return view('payment-templates.edit',compact('data'));
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
            'payment_type' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
        ]);

        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        if ($files = $request->file('bg_image')) {
            // Define upload path
            $destinationPath = public_path('/storage/template/'); // upload path
         // Upload Orginal Image
            $bannerImage = 'template_'.date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $bannerImage);
            $input['bg_image'] = $bannerImage;
        }
        $data = PaymentTemplate::find($id);
        $data->update($input);

        return redirect()->route('payment-templates.index')
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
        PaymentTemplate::find($id)->delete();
        return redirect()->route('payment-templates.index')
                        ->with('success','Deleted successfully');
    }

    public function changeStatus(Request $request)
    {
        $data = PaymentTemplate::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status changed successfully.']);
    }

}
