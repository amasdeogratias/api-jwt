<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use Validator;

class ReceiptController extends Controller
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
        return Receipt::all();
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
            'ReceiptNumber' => 'required',
            'ReceiptDate' => 'required',
            'ReceiptTime' => 'required',
            'PartyName' => 'required',
            'BillNumber' => 'required',
            'BillAmount' => 'required',
            'DayRate' => 'required',
            'AmountPaidInFC' => 'required',
            'AmountPaidInDollar' => 'required',
            'TotalAmount' => 'required',
            'UserID' => 'required',
            'CompanyName' => 'required',
            'CmpGuid' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->erros()->toJson(), 400);
        }

        $receipt = Receipt::create(array_merge(
            $validator->validated(), ['ReceiptNumber'=>'required']
        ));
        return response()->json([
            'message' =>'Receipt created successfully...',
            'ReceiptDetails' => $receipt
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
            'ReceiptNumber' => 'required',
            'ReceiptDate' => 'required',
            'ReceiptTime' => 'required',
            'PartyName' => 'required',
            'BillNumber' => 'required',
            'BillAmount' => 'required',
            'DayRate' => 'required',
            'AmountPaidInFC' => 'required',
            'AmountPaidInDollar' => 'required',
            'TotalAmount' => 'required',
            'UserID' => 'required',
            'CompanyName' => 'required',
            'CmpGuid' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->erros()->toJson(), 400);
        }

        $receipt = Receipt::find($id);
        $receipt -> create(array_merge(
            $validator->validated(), ['ReceiptNumber'=>'required']
        ));
        return response()->json([
            'message' =>'Receipt created successfully...',
            'ReceiptDetails' => $receipt
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
