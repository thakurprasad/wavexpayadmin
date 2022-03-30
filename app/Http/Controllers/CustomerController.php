<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Exports\CustomerExport;
use Carbon\Carbon;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
         $this->middleware('permission:customer-list');
         $this->middleware('permission:customer-create', ['only' => ['create','store']]);
         $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $is_export = ($request->get('is_export'))?1:0;
        $title = ($request->get('s_title'))?$request->get('s_title'):'';
        $mobile = ($request->get('s_mobile'))?$request->get('s_mobile'):'';
        $sort = ($request->get('sort'))?$request->get('sort'):'customer_name';
        $direction = ($request->get('direction'))?$request->get('direction'):'ASC';


        $data = Customer::where(function($query) use ($request) {
                            if ($request->get('s_title'))
                                $query->where('customer_name', 'like', "%".$request->get('s_title')."%");

                            if ($request->get('s_mobile'))
                                $query->where('mobile', 'like', "%".$request->get('s_mobile')."%");

                    })
                    ->orderBy($sort,$direction)->paginate(20);

        $postvalue = array(
            's_title'=>$title,
            's_mobile'=>$mobile
        );
        if($is_export==1){
            $filter=' 1 ';
            if ($request->get('s_title'))
                $filter.=" AND customer_name LIKE '%".$request->get('s_title')."%'";
            if ($request->get('s_mobile'))
                $filter.=" AND mobile = '".$request->get('s_mobile')."'";

            return (new CustomerExport)->passq($filter)->download('Customer_export_'.date('Ymd').'.xlsx');
        }

        return view('customers.index',compact('data','postvalue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'customer_name' => 'required|max:100',
            'mobile' => 'required|max:10|min:1|unique:customers,mobile',
            'address' => 'required',
            'locality' => 'required',
        ]);
        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        $data = Customer::create($input);

        return redirect()->route('customers.index')
                        ->with('success','Data created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Customer::find($id);
        return view('customers.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::find($id);
        return view('customers.edit',compact('data'));
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
            'customer_name' => 'required|max:100',
            'mobile' => 'required|max:10|min:1|unique:customers,mobile,'.$id,
            'address' => 'required',
            'locality' => 'required',
        ]);

        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';

        $data = Customer::find($id);
        $data->update($input);

        return redirect()->route('customers.index')
                        ->with('success','Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customers.index')
                        ->with('success','Data deleted successfully');
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $data = Customer::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status changed successfully.']);
    }

    public function getcustomer(Request $request)
    {
        $searchkey = $request->searchkey;
        $data = Customer::select('customer_name','mobile','address','locality')->where('mobile','LIKE','%'.$searchkey.'%')
                ->orWhere('customer_name','LIKE', $searchkey.'%')
                ->orWhere('address','LIKE', '%'.$searchkey.'%')
                ->orWhere('locality','LIKE', '%'.$searchkey.'%')->get();
        $json = [];
        if(!empty($data)){
           foreach($data as $val) {
                $json[] = $val;
           }
        }
        echo json_encode($json);
    }

}
