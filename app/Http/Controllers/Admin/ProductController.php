<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' =>200,
            'data'=>$products
        ],200);
     

    } //End method

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'       =>'required',
            'price'       =>'required|numeric',
            'category_id' =>'required|integer',
            'sku'         =>'required|unique:products,sku',
            'status'      =>'required',
            'is_featured' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors(),
            ],400);
        }

        //insert product
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->qty = $request->qty;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->is_featured = $request->is_featured;
        $product->barcode = $request->barcode;
        $product->save();

       
            return response()->json([
                'status'=>200,
                'message'=>'Product has been Inserted Successfully',
            ],200);
        

    } //End method

    public function show($id)
    {

    } //End method

    public function update($id, Request $request)
    {

    } //End method

    public function destroy($id)
    {

    } //End method
}
