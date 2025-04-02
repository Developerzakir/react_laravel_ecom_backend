<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','DESC')
        ->with('product_images')
        ->get();
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


           //save the product image

           if(!empty($request->gallery)){
            foreach($request->gallery as $key => $tempImageId){
                $tempImage  = TempImage::find($tempImageId);

                //Large Thumbnail
                $extArray = explode('.',$tempImage->name);
                $ext = end($extArray);
                $imageName = $product->id.'-'.time().'.'.$ext;

                $manager = new ImageManager(Driver::class);
                $img     = $manager->read(public_path('uploads/temp/'.$tempImage->name));
                // $img->scaleDown(1200);
                $img = $img->scale(width: 1200);
                $img->save(public_path('uploads/products/large/'.$imageName));

                //Small Thumbnail
                $manager = new ImageManager(Driver::class);
                $img     = $manager->read(public_path('uploads/temp/'.$tempImage->name));
                // $img->coverDown(400,460);
                $img = $img->cover(400, 460);
                $img->save(public_path('uploads/products/small/'.$imageName));

                //ProductImage
                $productImage = new ProductImage();
                $productImage->image = $imageName;
                $productImage->product_id = $product->id;
                $productImage->save();


                if($key == 0){
                    $product->image = $imageName;
                    $product->save();
                }

            }
          }


       
            return response()->json([
                'status'=>200,
                'message'=>'Product has been Inserted Successfully',
            ],200);
        

    } //End method

    public function show($id)
    {
        $product = Product::with('product_images')->find($id);

        if($product == null){
            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found',
            ],404);
        }

        return response()->json([
            'status'=>200,
            'data'=>$product,
        ],200);

    } //End method

    public function update($id, Request $request)
    {
        $product = Product::find($id);

        if($product == null){
            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found',
            ],404);
        }

        $validator = Validator::make($request->all(),[
            'title'       =>'required',
            'price'       =>'required|numeric',
            'category_id' =>'required|integer',
            'sku'         =>'required|unique:products,sku,'.$id.',id',
            'status'      =>'required',
            'is_featured' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors(),
            ],400);
        }

        //update product
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
                'message'=>'Product has been Updated Successfully',
            ],200);

    } //End method

    public function destroy($id)
    {
        $product = Product::find($id);

        if($product == null){
            return response()->json([
                'status'=>404,
                'message'=>'Product Not Found',
            ],404);
        }

        $product->delete();

        return response()->json([
            'status'=>200,
           'message'=>'Product Deleted',
        ],200);

    } //End method
}
