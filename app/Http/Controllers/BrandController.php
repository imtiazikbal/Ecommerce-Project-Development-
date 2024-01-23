<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class BrandController extends Controller
{
     function BrandList(Request $request){
        $data = Brand::all();
        return ResponseHelper::Out('success',$data,200);
    }
}
