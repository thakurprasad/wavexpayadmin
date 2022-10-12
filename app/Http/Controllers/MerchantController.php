<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Merchant;
use App\Models\MerchantKey;
use App\Models\MerchantUser;
class MerchantController extends Controller
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
        $data = Merchant::orderBy('merchant_name','ASC')->get();
        return view('merchants.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchants.create');
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
            'merchant_name' => 'required|max:200',
            'access_salt' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
        ]);
        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        $input['merchant_logo'] = 'default_logo.png';
        if ($files = $request->file('merchant_logo')) {
            // Define upload path
            $destinationPath = public_path('/storage/logo/'); // upload path
            // Upload Orginal Image
            $uploadedImage = 'logo_'.date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $uploadedImage);
            $input['merchant_logo'] = $uploadedImage;
        }
        $data = Merchant::create($input);

        return redirect()->route('merchants.index')
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
        $data = Merchant::find($id);
        return view('merchants.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Merchant::select('merchants.*','merchant_users.*')->join('merchant_users', 'merchant_users.merchant_id', '=', 'merchants.id')->where('merchants.id',$id)->get();
        $data = $data[0];
        //print_r($data);exit;
        return view('merchants.edit',compact('data'));
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
            'merchant_name' => 'required|max:200',
            'access_salt' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
        ]);

        $input = $request->all();


        $merchant_input = array();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        if ($request->hasFile('merchant_logo')){
            $file= $request->file('merchant_logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $image_path = public_path().'/uploads/logo/';
            $file->move($image_path, $filename);
            $merchant_input['merchant_logo'] = $filename;
        }
        $merchant_input['merchant_name'] = $input['merchant_name'];
        $merchant_input['contact_name'] = $input['contact_name'];
        $merchant_input['contact_phone'] = $input['contact_phone'];
        $merchant_input['merchant_payment_method'] = $input['merchant_payment_method'];
        $merchant_input['status'] = $input['status'];
        Merchant::where('id',$id)->update($merchant_input);


        $merchant_users_input = array();
        $merchant_users_input['beneficiary_name'] = $input['beneficiary_name'];
        $merchant_users_input['ifsc_code'] = $input['ifsc_code'];
        $merchant_users_input['account_number'] = $input['account_number'];
        $merchant_users_input['business_type'] = $input['business_type'];
        $merchant_users_input['business_category'] = $input['business_category'];
        $merchant_users_input['business_description'] = $input['business_description'];
        $merchant_users_input['pan_holder_name'] = $input['pan_holder_name'];
        $merchant_users_input['billing_label'] = $input['billing_label'];
        $merchant_users_input['billing_city'] = $input['billing_city'];
        $merchant_users_input['billing_address'] = $input['billing_address'];
        $merchant_users_input['billing_pincode'] = $input['billing_pincode'];
        $merchant_users_input['billing_state'] = $input['billing_state'];
        $merchant_users_input['address_proof'] = $input['address_proof'];
        $merchant_users_input['aadhar_front_image_status'] = $input['aadhar_front_image_status'];
        $merchant_users_input['aadhar_back_image_status'] = $input['aadhar_back_image_status'];
        if(isset($input['aadhar_front_image_reject_reason']))
        {
            $merchant_users_input['aadhar_front_image_reject_reason'] = $input['aadhar_front_image_reject_reason'];
        }
        if(isset($input['aadhar_back_image_reject_reason']))
        {
            $merchant_users_input['aadhar_back_image_reject_reason'] = $input['aadhar_back_image_reject_reason'];
        }


        if ($request->hasFile('aadhar_front')){
            $file2 = $request->file('aadhar_front');
            $filename2 = date('YmdHi').$file2->getClientOriginalName();
            $image_path2 = public_path().'/uploads/aadharimage/';
            $file2->move($image_path2, $filename2);
            $merchant_users_input['aadhar_front_image'] = $filename2;
        }
        if ($request->hasFile('aadhar_back')){
            $file3 = $request->file('aadhar_back');
            $filename3 = date('YmdHi').$file3->getClientOriginalName();
            $image_path3 = public_path().'/uploads/aadharimage/';
            $file3->move($image_path3, $filename3);
            $merchant_users_input['aadhar_back_image'] = $filename3;
        }
        MerchantUser::where('merchant_id',$id)->update($merchant_users_input);


        return redirect()->route('merchants.index')
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
        Merchant::find($id)->delete();
        return redirect()->route('merchants.index')
                        ->with('success','Deleted successfully');
    }

    public function changeStatus(Request $request)
    {
        $data = Merchant::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status changed successfully.']);
    }

    public function changePartnerStatus(Request $request)
    {
        $data = Merchant::find($request->id);
        $data->is_partner = $request->status;
        $data->save();

        return response()->json(['success'=>'Partner Status changed successfully.']);
    }

    public function merchantRewards(Request $request)
    {
        $data = Merchant::where('is_partner','yes')->orderBy('merchant_name','ASC')->get();
        return view('merchants.partner',compact('data'));
    }

    public function changeRewardValue(Request $request)
    {
        $data = Merchant::find($request->id);
        $data->reward_value = $request->reward;
        $data->save();
        return response()->json(['success'=>'Reward Value Updated successfully.']);
    }
}
