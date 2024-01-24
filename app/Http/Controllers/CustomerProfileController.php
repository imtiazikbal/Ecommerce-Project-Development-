<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;

class CustomerProfileController extends Controller
{
    public function CustomerProfileCreate(Request $request)
    {
        try {
            $user_id = $request->header('userID');
            // $data = CustomerProfile::updateOrCreate([
            //     'user_id' => $user_id,
            //     'cus_name' => $request->input('cus_name'),
            //     'cus_add' => $request->input('cus_add'),
            //     'cus_city' => $request->input('cus_city'),
            //     'cus_state' => $request->input('cus_state'),
            //     'cus_postcode' => $request->input('cus_postcode'),
            //     'cus_country' => $request->input('cus_country'),
            //     'cus_phone' => $request->input('cus_phone'),
            //     'cus_fax' => $request->input('cus_fax'),
            //     'ship_name' => $request->input('ship_name'),
            //     'ship_add' => $request->input('ship_add'),
            //     'ship_city' => $request->input('ship_city'),
            //     'ship_state' => $request->input('ship_state'),
            //     'ship_postcode' => $request->input('ship_postcode'),
            //     'ship_country' => $request->input('ship_country'),
            //     'ship_phone' => $request->input('ship_phone'),

            // ]);

            $data = CustomerProfile::updateOrCreate(
                ['user_id' => $user_id],
                $request->input()
            );

            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $e) {
            return ResponseHelper::Out('error', $e->getMessage(), 500);
        }
    }
    public function ReadCustomerProfile(Request $request)
    {
        try {
            $userID = $request->header('userID');
            $data = CustomerProfile::where('user_id', $userID)->with(['user' => function ($query) {
                $query->select('id', 'email');
            }])->get();
            return ResponseHelper::Out('success', $data, 200);
        } catch (Exception $e) {

        }
    }
}
