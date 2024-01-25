<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ProductWish;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class ProductWishController extends Controller
{
    public function WishList(Request $request){
        try{
            $userID = $request->header('userID');
            $data = ProductWish::where('user_id', $userID)->with('product')->get();
            return ResponseHelper::Out('success', $data, 200);
            
        }catch(Exception $exception){
            return ResponseHelper::Out('error', $exception->getMessage(), 500);
        }
    }

    public function CreateWishList(Request $request){
        try{
            $userID = $request->header('userID');
            $data = ProductWish::updateOrCreate(
                ['user_id' => $userID, 'product_id' => $request->product_id]
                
            );
            return ResponseHelper::Out('success', $data, 200);
        }catch(Exception $exception){
            return ResponseHelper::Out('error', $exception->getMessage(), 500);
        }
    }
    public function RemoveWishList(Request $request){
        try{
            $userID = $request->header('userID');
            $data = ProductWish::where(
                ['user_id' => $userID, 'product_id' => $request->product_id]
                
            )->delete();
            return ResponseHelper::Out('success', $data, 200);
        }catch(Exception $exception){
            return ResponseHelper::Out('error', $exception->getMessage(), 500);
        }
    }
}
