<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Helper\ResponseHelper;
use App\Models\ProductDetails;
use App\Models\CustomerProfile;

class ProductController extends Controller
{
    public function ProductByCategory(Request $request)
    {
        try {
            $data = Product::where('category_id', $request->category_id)->with('category', 'brand')->get();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function ProductByRemark(Request $request)
    {
        try {
            $data = Product::where('remark', $request->remark)->with('category', 'brand')->get();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function ProductByBrand(Request $request)
    {
        try { $data = Product::where('brand_id', $request->brand_id)->with('category', 'brand')->get();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function ProductSlider(Request $request)
    {
        try {
            $data = ProductSlider::all();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function ProductById(Request $request)
    {
        try {
            $data = ProductDetails::where('product_id', $request->product_id)->with('product', 'product.brand', 'product.category')->get();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function ListReviewByProduct(Request $request)
    {
        try {
            //$data = ProductReview::where('product_id',$request->product_id)->with('profile')->get();
            $data = ProductReview::where('product_id', $request->product_id)->with(['profile' => function ($query) {
                $query->select('id', 'cus_name');

            }])->get();

            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $ex) {
            return ResponseHelper::Out('error', $ex->getMessage(), 500);
        }
    }
    public function CreateProductReview(Request $request)
    {
        try {
           $userID = $request->header('userID');
            $profile = CustomerProfile::where('user_id', $userID)->first();
          
            if($profile){
                $request->merge(['customer_id' => $profile->id]);
                $data = ProductReview::updateOrCreate(
                    ['customer_id' => $profile->id, 'product_id' => $request->product_id],
                    $request->input()
                );
                return ResponseHelper::Out('success', $data, 200);
            }else{
                return ResponseHelper::Out('error', 'User Not Found', 500);
            }
        } catch (Exception $e) {
            return ResponseHelper::Out('error', 'Something went wrong', 500);
        }
    }

}
