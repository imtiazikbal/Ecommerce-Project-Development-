<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class ProductCartController extends Controller
{

    public function CartProductList(Request $request){
        try{
            $userID = $request->header('userID');
            $data = ProductCart::where('user_id',$userID)->with('product')->get();
            return ResponseHelper::Out('Cart Product List',$data,200);
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
    }
    public function CreateProductCart(Request $request){
        try{
            $userID = $request->header('userID');
            $product_id = $request->input('product_id');
            $color = $request->input('color');
            $size = $request->input('size');
            $qty = $request->input('qty');
            $unitPrice = 0;

            $productDetails =Product::where('id','=',$product_id)->first(); 
            if($productDetails->discount ==1){
                $unitPrice = $productDetails->discount_price;
            }else{
                $unitPrice = $productDetails->price;
            }
            $totalPrice = $unitPrice * $qty;

            $data = ProductCart::updateOrCreate(
                ['user_id' => $userID, 'product_id' => $product_id],
                [ 
                    'color' => $color, 'size' => $size,
                    'qty' => $qty, 'price' => $unitPrice,
                ]
            );
            return ResponseHelper::Out('Product Added To Cart',$data,200);
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
    }
    public function RemoveCartProduct(Request $request){
        try{
            $userID = $request->header('userID');
            $product_id = $request->input('product_id');
            $data = ProductCart::where('user_id',$userID)->where('product_id',$product_id)->delete();
            return ResponseHelper::Out('Product Removed From Cart',$data,200);
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
    }
}
