<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\WavexpayApiKey;

class WavexpayApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data =  WavexpayApiKey::withCount(['merchants'])->get();        
        return view('wavexpay.gateway.list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForm()
    {
        return view('wavexpay.gateway.add', ['get'=>[] ]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'gateway'        => 'required',  
                'category_id'    => 'required',  
                'key_description'=> 'required',  
                'test_api_key'   => 'required',  
                'test_api_secret'=> 'required',  
                'live_api_key'   => 'required',  
                'live_api_secret'=> 'required',  
                
            ]
        );

        if ($validator->fails())
        {   
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

       try{
        $res = WavexpayApiKey::insert([
            'category_id' => $request->category_id,
            'key_description' => $request->key_description,
            'gateway' => $request->gateway, 
            'test_api_key' => $request->test_api_key,
            'test_api_secret' => $request->test_api_secret,
            'live_api_key' => $request->live_api_key,
            'live_api_secret' => $request->live_api_secret,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => \Auth::user()->id
        ]);
            
            return redirect()->back()->with(['success'=> 'Gateway Updated Successfully']);        
        }catch(Exception $ex){
            return redirect()->back()->withErrors(['error'=>$ex->getMessage(), $get=>$request]);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = WavexpayApiKey::find($id);
        return view('wavexpay.gateway.edit',['data'=>$data]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'category_id'   => 'required',  
                'gateway'        => 'required',  
                'key_description'=> 'required',  
                'test_api_key'   => 'required',  
                'test_api_secret'=> 'required',  
                'live_api_key'   => 'required',  
                'live_api_secret'=> 'required',  
                
            ]
        );

        if ($validator->fails())
        {   
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

       try{
        $res = WavexpayApiKey::where('id', $id)->update([
            'category_id' => $request->category_id,
            'key_description' => $request->key_description,
            'gateway' => $request->gateway, 
            'test_api_key' => $request->test_api_key,
            'test_api_secret' => $request->test_api_secret,
            'live_api_key' => $request->live_api_key,
            'live_api_secret' => $request->live_api_secret,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => \Auth::user()->id
        ]);
            
            return redirect()->back()->with(['success'=> 'Gateway Updated Successfully']);
        
        }catch(Exception $ex){
            return redirect()->back()->withErrors(['error'=>$ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
