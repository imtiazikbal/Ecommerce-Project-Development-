<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;

class ProductReviewController extends Controller
{
    public function CreateProductReviewindex(Request $request)
    {
        $user_id=$request->header('userID');
        $profile=CustomerProfile::where('user_id',$user_id)->first();

        if($profile){
            $request->merge(['customer_id' =>$profile->id]);
            $data=ProductReview::updateOrCreate(
                ['customer_id' => $profile->id,'product_id'=>$request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::Out('success',$data,200);
        }
        else{
            return ResponseHelper::Out('fail','Customer profile not exists',200);
        }

    }

   
}
