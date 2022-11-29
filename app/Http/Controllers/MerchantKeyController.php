<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Merchant;
use App\Models\MerchantKey;
use App\Models\MerchantUser;
class MerchantKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
         $this->middleware('permission:merchant-list');
         $this->middleware('permission:merchant-create', ['only' => ['create','store']]);
         $this->middleware('permission:merchant-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:merchant-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = MerchantKey::select('merchant_keys.*','merchant_name')
                ->leftJoin('merchants','merchants.id','merchant_keys.merchant_id')
                ->orderBy('merchant_name','ASC')->get();
        return view('merchant-keys.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants = Merchant::orderBy('merchant_name','ASC')->get();
        $api_titles = array('Razorpay'=>'Razorpay');
        return view('merchant-keys.create',compact('merchants','api_titles'));
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
            'merchant_id' => 'required',
            'api_title' => 'required',
            'api_key' => 'required',
        ]);

        $data = MerchantKey::updateOrCreate(
            ['api_key' => $request->api_key],
            ['merchant_id' => $request->merchant_id, 'api_title' => $request->api_title]
        );

        return redirect()->route('merchant-keys.index')
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
        $data = MerchantKey::find($id);

        return view('merchant-keys.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MerchantKey::select('merchant_keys.*','merchant_name')
                    ->leftJoin('merchants','merchants.id','merchant_keys.merchant_id')
                    ->find($id);
        $merchants = Merchant::orderBy('merchant_name','ASC')->get();
        return view('merchant-keys.edit',compact('data'));
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
            'api_key' => 'required',
        ]);

        $input = $request->all();

        $data = MerchantKey::find($id);
        $data->update($input);

        return redirect()->route('merchant-keys.index')
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
        MerchantKey::find($id)->delete();
        return redirect()->route('merchant-keys.index')
                        ->with('success','Deleted successfully');
    }
}
