<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Merchant;
use App\Models\MerchantKey;
use App\Models\MerchantUser;
use App\Models\WavexpayApiKey;
use App\Models\MerchantAddress;
use Helpers;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
         /*$this->middleware('permission:merchant-list');
         $this->middleware('permission:merchant-create', ['only' => ['create','store']]);
         $this->middleware('permission:merchant-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:merchant-delete', ['only' => ['destroy']]);*/
    }

    public function profile($merchant_id){
        try{
            
            $profile = Merchant::select('*')
            ->with([
                'MerchantApiKeys', 
                'MerchantUsers', 
                'MerchantAddresses',                 
                'PaymentLinks',
                'Invoices',
                'Payments', 
                'Items'
            ])
            ->where('id', $merchant_id)->first();
            if($profile){
                return view('merchants.profile', ['data'=>$profile]);
            }else{
                 return redirect()->back()->withErrors(['error'=> 'Invalid merchant_id']);     
            }
            

        }catch(Exception $ex){
            return redirect()->back()->withErrors(['error'=>$ex->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $all_api_keys = WavexpayApiKey::all();
        $data = Merchant::with(['MerchantUsers'])->orderBy('merchant_name','ASC')->get();
        return view('merchants.index',compact('data','all_api_keys'));
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
        $data = Merchant::select(
    'merchants.*',
    'merchant_id',
    'name',
    'display_name',
    'email',
    'email_verified_at',
    'password',
    'remember_token',
    'beneficiary_name',
    'ifsc_code',
    'account_number',
    'business_type',
    'business_category',
    'business_description',
    'accept_payment_by',
    'accept_web_permission',
    'payment_web_url',
    'accept_app_permission',
    'pan_holder_name',
    'billing_label',
    'billing_address',
    'billing_pincode',
    'billing_city',
    'billing_state',
    'aadhar_no',
    'link_status',
    'gst_no',
    'razorpay_gst_no',
    'address_proof',
    'aadhar_front_image',
    'aadhar_back_image',
    'aadhar_front_image_status',
    'aadhar_back_image_status',
    'aadhar_front_image_reject_reason',
    'aadhar_back_image_reject_reason',
        )->join('merchant_users', 'merchant_users.merchant_id', '=', 'merchants.id')->where('merchants.id',$id)->first();
        //$data = $data[0];
        //print_r($data);exit;
       // return WavexpayApiKey::get_api_key_categories_arr();
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
        //return $id;
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
        $merchant_input['wavexpay_api_key_id'] = $input['wavexpay_api_key_id'];
        $merchant_input['status'] = $input['status'];
        #return $merchant_input;
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

    public function getmerchantbykey(Request $request){
        try{
            $key_id = $request->key_id;
            $merchants = Merchant::select('id','merchant_name')->where('wavexpay_api_key_id',$key_id)->get();
            /*$html='<option value="">Select Merchant</option>
            <option value="all">All</option>';
            if(count($merchants)>0){
                foreach($merchants as $merchant){
                    $html.='<option value="'.$merchant->id.'">'.$merchant->merchant_name.'</option>';
                }
            }*/
            return $this->sendResponse($merchants,'Merchant Recieved Successfully');
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return $this->sendError($msg);
        }
        
    }

    public function searchMerchant(Request $request){
        $merchant_id = $request->merchant_id;
        $status = $request->status;
        $contact_person = $request->contact_person;
        $phone = $request->phone;


        $html = '';
        $query = Merchant::select("*")->with(['MerchantUsers']);
        if($status!=''){
            $query->where('status',$status);
        }
        if($contact_person!=''){
            $query->where('contact_name','LIKE','%'.$contact_person.'%');
        }
        if($phone!=''){
            $query->where('contact_phone',$phone);
        }
        $result = $query->get();

        if(!empty($result)){
            foreach($result as $value){
                $html.='<tr>
                <td>'.$value->merchant_name.'</td>
                <td>'.$value->contact_name.'</td>
                <td>'.$value->contact_phone.'</td>
                <td class="text-center"> <input data-id="'.$value->id.'" class="toggle-class  btn-xs" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive"'; if($value->status=="Active") { $html.='checked'; } else { $html.=''; } $html.='data-size="xs"> </td>
                <td class="text-center">'.ucwords($value->merchant_payment_method).'</td>
                <td class="text-center" data-sort="'.date('d-m-Y',strtotime($value->updated_at)).'">'.date('d-m-Y',strtotime($value->updated_at)).'</td>
                <td class="text-center"> <input data-partner="'.$value->id.'" class="toggle-class partner-toggle btn-xs" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="yes" data-off="no"'; if($value->is_partner=="yes") { $html.='checked'; } else { $html.=''; } $html.='data-size="xs"> </td>
                <td class="text-center">
                    <a class="btn btn-primary btn-sm" href="'.route('merchants.edit',$value->id).'"  title="Edit"><i class="fas fa-edit"></i></a>
                </td>
            </tr>';
            }
        }
        return response()->json(array('html'=>$html));
    }
}
