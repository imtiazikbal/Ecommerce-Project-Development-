<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class CategoryController extends Controller
{
    
    function CategoryList(){
        $data = Category::all();
        return ResponseHelper::Out('success',$data,200);
    }
}
