<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Validator;

class ItemController extends Controller
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
        return Item::all();
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
            'ItemName' => 'required|string|between:2,100',
            'ItemCode' => 'required|string|between:2,100',
            'ItemMasterId' => 'required',
            'ItemUnit' => 'required',
            'ItemQty' => 'required',
            'ItemAltUOM' => 'required',
            'ItemFirstUOMMapping' => 'required',
            'ItemAltUOMMapping' => 'required',
            'ItemRate' => 'required',
            'ItemOpeningBalance' => 'required',
            'ItemGroup' => 'required|string|between:2, 100',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $item = Item::create(array_merge(
            $validator->validated(), $request->all()
        ));
        return response()->json([
            'message' =>'Item Details added successfully',
            'itemDetails' => $item
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
            'ItemName' => 'required|string|between:2,100',
            'ItemCode' => 'required|string|between:2,100',
            'ItemMasterId' => 'required',
            'ItemUnit' => 'required',
            'ItemQty' => 'required',
            'ItemAltUOM' => 'required',
            'ItemFirstUOMMapping' => 'required',
            'ItemAltUOMMapping' => 'required',
            'ItemRate' => 'required',
            'ItemOpeningBalance' => 'required',
            'ItemGroup' => 'required|string|between:2, 100',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $item = Item:: find($id);
        $item -> create(array_merge(
            $validator->validated(), $request->all()
        ));
        return response()->json([
            'message' =>'Item Details added successfully',
            'itemDetails' => $item
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
