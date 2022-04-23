<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quotation;
use Validator;

class QuotationController extends Controller
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
        return Quotation::all();
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
            'quot_no' => 'required|string|between:2,100',
            'quot_date' => 'required',
            'customer_name' => 'required|string|between:2,100',
            'mobile' => 'required|string|between:2,100',
            'fax' => 'required|string|between:2,100',
            'contact_person' => 'required|string|between:2,100',
            'country' => 'required|string|between:2,100',
            'payment_method' => 'required|string|between:2,100',
            'notes' => 'required|string|between:2,100',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $quotation = Quotation::create(array_merge(
            $validator->validated(),
            ['quot_no' => $request->quot_no]
        ));
        return response()->json([
            'message' => 'Quotations created successfully',
            'quotation' => $quotation
        ], 201);
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
        $validate = Validator::make($request->all(), [
            'quot_no' => 'required|string|between:2,100',
            'quot_date' => 'required',
            'customer_name' => 'required|string|between:2,100',
            'mobile' => 'required|string|between:2,100',
            'fax' => 'required|string|between:2,100',
            'contact_person' => 'required|string|between:2,100',
            'country' => 'required|string|between:2,100',
            'payment_method' => 'required|string|between:2,100',
            'notes' => 'required|string|between:2,100',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors()->toJson(), 400);
        }
        $quotations = Quotation::update(array_merge($validate->validated(),['quot_name'=>'required']));
        return response()->json([
            'message' =>"Quotations updated successfully...",
            'quotatio' =>$quotations,
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
