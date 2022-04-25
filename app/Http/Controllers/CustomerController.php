<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Validator;

class CustomerController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index','store', 'update']]);
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

        $customer = Customer::create(array_merge(
            $validator->validated(), ['CustomerName'=>'required']
        ));
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
            $validator->validated(), ['CustomerName'=>'required']
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
