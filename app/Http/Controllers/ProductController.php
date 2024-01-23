<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductSlider;
use App\Helper\ResponseHelper;
use App\Models\ProductDetails;

class ProductController extends Controller
{
    function ProductByCategory(Request $request){
        $data = Product::where('category_id',$request->category_id)->with('category','brand')->get();
        return ResponseHelper::Out('success',$data,200);
    } 
    function ProductByRemark(Request $request){
        $data = Product::where('remark',$request->remark)->with('category','brand')->get();
        return ResponseHelper::Out('success',$data,200);
    }
    function ProductByBrand(Request $request){
        $data = Product::where('brand_id',$request->brand_id)->with('category','brand')->get();
        return ResponseHelper::Out('success',$data,200);
    } 
    function ProductSlider(Request $request){
        $data = ProductSlider::all();
        return ResponseHelper::Out('success',$data,200);
    } 
    function ProductById(Request $request){
        $data = ProductDetails::where('product_id',$request->product_id)->with('product','product.brand','product.category')->get();
        return ResponseHelper::Out('success',$data,200);
    }
}
