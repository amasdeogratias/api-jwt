<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Validator;

class CustomerController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index','store', 'tallyCustomer', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'CUSTOMERNAME' => 'required|string|between:2,100',
                'CUSTOMERCODE' => 'required|string|between:2,100',
                'CONTACTPERSONNAME' => 'required',
                'MOBILENO' => 'required',
                'EMAILID' => 'required|string|email|max:100',
                'ADDRESS' => 'required',
                'CITY' => 'required',
                'COUNTRY' => 'required',
                'CUSTOMERGROUP' => 'required',
                'COMPANYNAME' => 'required',

            ]);
            if ($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }


                $customer = Customer::create(array_merge(
                    $validator->validated(), $request->all()
                ));
        }catch (\Exception $exception){
            return response()->json([
                'message' => 'Customer Already exists, create new one'
            ]);
        }
        return response()->json([
            'message' =>'Customer Details added successfully',
            'CustomerDetails' => $customer
        ]);
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
        //
    }

    /**
     * Automatically get customers form the tally server
     * to my local database
     */
    public function tallyCustomer(){
        $response = Http::get('http://192.168.30.126:8080/api/TallyCustomers');
        $result = json_decode($response->body(), true);
        $results = (array) $result;
        $output = json_decode($results[0], true);


        //loop through the output
        foreach($output['CUSOMTERDETAILS'] as $key => $values){
            $customerDetails[] = array(
                'CUSTOMERNAME' => $values['CUSTOMERNAME'],
                'CUSTOMERCODE' => $values['CUSTOMERCODE'],
                'CONTACTPERSONNAME' => $values['CONTACTPERSONNAME'],
                'MOBILENO' => $values['MOBILENO'],
                'EMAILID' => $values['EMAILID'],
                'ADDRESS' => $values['ADDRESS'],
                'CITY' => $values['CITY'],
                'COUNTRY' => $values['COUNTRY'],
                'CUSTOMERGROUP' => $values['CUSTOMERGROUP'],
                'COMPANYNAME' => $values['COMPANYNAME'],
            );
            $output_data = $customerDetails;
        }

        //make validation
        try
        {
            $validata = Validator::make($output_data, [
                'CUSOMTERDETAILS.*.CUSTOMERNAME' => 'required|unique:customers',
                'CUSOMTERDETAILS.*.CUSTOMERCODE' => 'required|unique:customers',
                'CUSOMTERDETAILS.*.CONTACTPERSONNAME' => 'required',
                'CUSOMTERDETAILS.*.MOBILENO' => 'required',
                'CUSOMTERDETAILS.*.EMAILID' => 'required',
                'CUSOMTERDETAILS.*.ADDRESS' => 'required',
                'CUSOMTERDETAILS.*.CITY' => 'required',
                'CUSOMTERDETAILS.*.COUNTRY' => 'required',
                'CUSOMTERDETAILS.*.CUSTOMERGROUP' => 'required',
                'CUSOMTERDETAILS.*.COMPANYNAME' => 'required',
            ]);
            //check if validator passes
            if($validata->fails()){
                return response()->json($validata->errors()->toJson(), 400);
            }

            //handle exception on submission

                    foreach($output_data as $key => $val){
                        $customer = Customer::create(array_merge(
                            $validata->validated(),
                            [
                                'CUSTOMERNAME' => $val['CUSTOMERNAME'],
                                'CUSTOMERCODE' => $val['CUSTOMERCODE'],
                                'CONTACTPERSONNAME' => $val['CONTACTPERSONNAME'],
                                'MOBILENO' => $val['MOBILENO'],
                                'EMAILID' => $val['EMAILID'],
                                'ADDRESS' => $val['ADDRESS'],
                                'CITY' => $val['CITY'],
                                'COUNTRY' => $val['COUNTRY'],
                                'CUSTOMERGROUP' => $val['CUSTOMERGROUP'],
                                'COMPANYNAME' => $val['COMPANYNAME'],
                            ]
                        ));
                    }
        }catch(\Exception $exception){
            return response(array(
                "code"=> 409,
                "error"=>"Customer record exists, please create different customer"));
        }

    return response()->json([
        'message' => 'Successfully synchronized...'

    ], 201);




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
        $validator = Validator::make($request->all(), [
            'CustomerName' => 'required|string|between:2,100',
            'CustomerCode' => 'required|string|between:2,100',
            'ContactPersonName' => 'required',
            'MobileNo' => 'required',
            'EmailId' => 'required|string|email|max:100|unique:customers',
            'Address' => 'required',
            'City' => 'required',
            'Country' => 'required',
            'CustomerGroup' => 'required',

        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $customer = Customer::find($id);
        $customer -> create(array_merge(
            $validator->validated(), $request->all()
        ));
        return response()->json([
            'message' =>'Customer Details added successfully',
            'CustomerDetails' => $customer
        ]);
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
