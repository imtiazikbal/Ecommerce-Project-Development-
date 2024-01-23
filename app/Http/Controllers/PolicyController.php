<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class PolicyController extends Controller
{
    public function PolicyByType(Request $request)
    {
        $data = Policy::where('type', $request->type)->get();
        return ResponseHelper::Out('success', $data, 200);
    }
}
