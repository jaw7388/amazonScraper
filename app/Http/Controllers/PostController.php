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
        //$array = array('sku'=>"hola", 'hola'=>"hello");
        //$sku = $request->sku;
//    $array = array('name'=>'john', 'dni'=> 22323, 'apellido'=>'ortiz');
        //return view('singleproduct', ['array'=> $array]);
        return response()->json( ['sku'=>$array] );
    }
    
}
