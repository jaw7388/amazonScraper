<?php

namespace App\Http\Controllers;
use App\Amazon\CREATE;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function singleProduct(Request $request){
        
        $sku = $request->sku;
        $array = new CREATE($sku);
        $array = $array->typeOfItem();
        return response()->json( ['sku'=>$array] );
    }
    
}
