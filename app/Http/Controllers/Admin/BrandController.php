<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('created_at','DESC')->get();
        return response()->json([
            'status' =>200,
            'data' =>$brands
        ]);
        
    } //End method

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status'=>200,
            'message'=>'Brand Added Successfully',
            'data'=>$brand
        ],200);

    } //End method

    public function show($id)
    {
        $brand = Brand::find($id);

        if($brand == null){
            return response()->json([
                'status' =>404,
                'message' =>'Brand Not Found',
                'data' =>[]
            ],404);
        }

        return response()->json([
            'status' =>200,
            'data'   => $brand
        ]);
    } //End method

    public function update($id, Request $request)
    {

        $brand = Brand::find($id);

        if($brand == null){
            return response()->json([
                'status' =>404,
                'message' =>'Brand Not Found',
                'data' =>[]
            ],404);
        }


        $validator = Validator::make($request->all(),[
            'name' =>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors()
            ],400);
        }

        
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status'=>200,
            'message'=>'Brand Updated Successfully',
            'data'=>$brand
        ],200);

    } //End method

    public function destroy($id)
    {
        $brand = Brand::find($id);

        if($brand == null){
            return response()->json([
                'status' =>404,
                'message' =>'Brand Not Found',
                'data' =>[]
            ],404);
        }

        $brand->delete();

        return response()->json([
            'status'=>200,
            'message'=>'Brand Deleted Successfully'
        ],200);

    } //End method
}
