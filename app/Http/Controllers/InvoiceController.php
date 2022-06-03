<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use Validator;

class InvoiceController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['createInvoice']]);
    }

    /**
     * Create new invoice
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createInvoice(Request $request)
    {
        $data = file_get_contents("php://input");
        $data_array = json_decode($data, true);

        foreach($data_array['CustomerInfo'] as $key => $values) {
            foreach($values['InvoiceDetails'] as $key => $value) {
                foreach($value['InvoiceItems'] as $k1 => $val1) {
                    $InvoiceData[] = array(
                        'InvoiceNo' => $value['InvoiceNo'],
                        'InvoiceDate' => $value['InvoiceDate'],
                        'CustomerName' => $values['CustomerName'],
                        'CustomerCode' => $values['CustomerCode'],
                        'ItemName' => $val1['ItemName'],
                        'ItemPrice' => $val1['ItemPrice'],
                        'ItemQty' => $val1['ItemQty'],
                        'TotalAmount' => $val1['TotalAmount'],
                    );
                }
                $output = $InvoiceData;
            }
        }
        //handle exception
        try {
            //validate data
            $validator = Validator::make($request->all(), [
                'CustomerInfo.*.InvoiceDetails.*.InvoiceNo' => 'required|unique:invoices',
                'CustomerInfo.*.InvoiceDetails.*.InvoiceDate' => 'required',
                'CustomerInfo.*.CustomerName' => 'required',
                'CustomerInfo.*.CustomerCode' => 'required',
                'CustomerInfo.*.InvoiceDetails.*.InvoiceItems.*.ItemName' => 'required',
                'CustomerInfo.*.InvoiceDetails.*.InvoiceItems.*.ItemPrice' => 'required',
                'CustomerInfo.*.InvoiceDetails.*.InvoiceItems.*.ItemQty' => 'required',
                'CustomerInfo.*.InvoiceDetails.*.InvoiceItems.*.TotalAmount' => 'required',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            foreach($output as $key => $vl) {
                $invoice = Invoice:: create(array_merge($validator->validated(), [
                    'InvoiceNo' => $vl['InvoiceNo'],
                    'InvoiceDate' => $vl['InvoiceDate'],
                    'CustomerName' => $vl['CustomerName'],
                    'CustomerCode' => $vl['CustomerCode'],
                    'ItemName' => $vl['ItemName'],
                    'ItemPrice' => $vl['ItemPrice'],
                    'ItemQty' => $vl['ItemQty'],
                    'TotalAmount' => $vl['TotalAmount'],
                ]));
            }
        }catch(Exception $exception){
            return response(array(
                "code"=> 409,
                "error"=>"Invoice entry exits, create new invoice"));
        }
        return response()->json([
            'message' => 'Successfully synchronized...'

        ], 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
