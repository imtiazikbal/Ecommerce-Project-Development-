<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invoice;
use App\Helper\SSLCommerz;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Models\InvoiceProduct;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function InvoiceCreate(Request $request){
        DB::beginTransaction();
        try {

            //
            $user_id=$request->header('userID');
            $user_email=$request->header('userEmail');

            $tran_id=uniqid();
            $delivery_status='Pending';
            $payment_status='Pending';

            $Profile=CustomerProfile::where('user_id','=',$user_id)->first();
            $cus_details="Name:$Profile->cus_name,Address:$Profile->cus_add,City:$Profile->cus_city,Phone: $Profile->cus_phone";
            $ship_details="Name:$Profile->ship_name,Address:$Profile->ship_add ,City:$Profile->ship_city ,Phone: $Profile->cus_phone";

            // Payable Calculation
            $total=0;
            $cartList=ProductCart::where('user_id','=',$user_id)->get();
            foreach ($cartList as $cartItem) {
                $total=$total+$cartItem->price;
            }

            $vat=($total*3)/100;
            $payable=$total+$vat;

            $invoice= Invoice::create([
                'total'=>$total,
                'vat'=>$vat,
                'payable'=>$payable,
                'cus_details'=>$cus_details,
                'ship_details'=>$ship_details,
                'tran_id'=>$tran_id,
                'delivery_status'=>$delivery_status,
                'payment_status'=>$payment_status,
                'user_id'=>$user_id
            ]);

            $invoiceID=$invoice->id;

            foreach ($cartList as $EachProduct) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'product_id' => $EachProduct['product_id'],
                    'user_id'=>$user_id,
                    'qty' =>  $EachProduct['qty'],
                    'sale_price'=>  $EachProduct['price'],
                ]);
            }

          $paymentMethod=SSLCommerz::InitiatePayment($Profile,$payable,$tran_id,$user_email);

           DB::commit();
         //  return ResponseHelper::Out('success',"",200);

           return ResponseHelper::Out('success',array(['paymentMethod'=>$paymentMethod,'payable'=>$payable,'vat'=>$vat,'total'=>$total]),200);

        }catch(Exception $e){
            DB::rollBack();
            return ResponseHelper::Out('Error',$e->getMessage(),500);
        }
        
    }

    function InvoiceList(Request $request){
        try{
            $userID = $request->header('userID');
            $data = Invoice::where('user_id',$userID)->get();
            return ResponseHelper::Out('Invoice List',$data,200);
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
    }

    function InvoiceProductList(Request $request){
        try{
            $userID = $request->header('userID');
            $InvoiceID = $request->invoice_id;
            $data = InvoiceProduct::where('user_id',$userID)->where('invoice_id',$InvoiceID)->with('product')->get();
            return ResponseHelper::Out('Invoice Product List',$data,200);
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
    }
    function PaymentSuccess(Request $request){
            try{
                SSLCommerz::PaymentSucces($request->query('tran_id'));
               // return redirect('/Profile');
               return 1;
            }catch(Exception $e){
                return ResponseHelper::Out('Error',$e->getMessage(),200);
            }
    }

    function PaymentFail(Request $request){
        try{
            SSLCommerz::PaymentFail($request->query('tran_id'));
           // return redirect('/Profile');
           return 1;
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
}   
 function PaymentCancel(Request $request){
        try{
            SSLCommerz::PaymentCancel($request->query('tran_id'));
           // return redirect('/Profile');
           return 1;
        }catch(Exception $e){
            return ResponseHelper::Out('Error',$e->getMessage(),200);
        }
}
}
