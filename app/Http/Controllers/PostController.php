<?php

namespace App\Http\Controllers;
use App\Amazon\CREATE;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        // $array = new CREATE('B07NBZZFD5');
        // $array = $array->typeOfItem();
        // return view('singleproduct', ['array'=>$array]);
        return view('singleproduct');
    }
}
