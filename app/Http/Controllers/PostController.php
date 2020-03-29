<?php

namespace App\Http\Controllers;
use App\Amazon\CREATE;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $array = new CREATE('B07FVPR6ZF');
        $array = $array->typeOfItem();
        return view('singleproduct', ['array'=>$array]);
    }
}
