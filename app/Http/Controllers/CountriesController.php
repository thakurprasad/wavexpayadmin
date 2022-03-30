<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Country;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    function __construct()
    {
        // $this->middleware('permission:setting-list');
        // $this->middleware('permission:setting-create', ['only' => ['create','store']]);
        // $this->middleware('permission:setting-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:setting-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::orderBy('position_order','ASC')->orderBy('country_name','ASC')->get();
        return view('countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
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
            'country_name' => 'required|max:200',
            'country_code2' => 'required|unique:countries,country_code2|max:2|min:2',
            'country_code3' => 'required|unique:countries,country_code3|max:3|min:3',
            'position_order' => 'numeric',
        ]);
        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';
        $country = Country::create($input);

        return redirect()->route('countries.index')
                        ->with('success','Country created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);
        return view('countries.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        return view('countries.edit',compact('country'));
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
            'country_name' => 'required|max:200',
            'country_code2' => 'required|max:2|min:2|unique:countries,country_code2,'.$id,
            'country_code3' => 'required|max:3|min:3|unique:countries,country_code3,'.$id,
            'position_order' => 'numeric',
        ]);

        $input = $request->all();
        $input['status']= (isset($input['status']) && $input['status']=='on')?'Active':'Inactive';

        $country = Country::find($id);
        $country->update($input);

        return redirect()->route('countries.index')
                        ->with('success','Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::find($id)->delete();
        return redirect()->route('countries.index')
                        ->with('success','Country deleted successfully');
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $country = Country::find($request->id);
        $country->status = $request->status;
        $country->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

}
