<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile');
    }
    
    public function settings()
    {
        // $array = new CREATE('B07NBZZFD5');
        // $array = $array->typeOfItem();
        // return view('singleproduct', ['array'=>$array]);
        return view('settings');
    }

    public function singleProduct()
    {
        // $array = new CREATE('B07NBZZFD5');
        // $array = $array->typeOfItem();
        // return view('singleproduct', ['array'=>$array]);
        return view('singleproduct');
    }

    public function massiveProduct()
    {
        // $array = new CREATE('B07NBZZFD5');
        // $array = $array->typeOfItem();
        // return view('singleproduct', ['array'=>$array]);
        return view('massiveproduct');
    }    

}
