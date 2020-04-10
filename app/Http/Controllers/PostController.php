<?php

namespace App\Http\Controllers;
use App\Amazon\CREATE;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PostController extends Controller
{
    public function singleProduct(Request $request){
        
        $sku = $request->sku;
         $array = new CREATE($sku);
         $array = $array->typeOfItem();
        return response()->json( ['sku'=>$array] );
        //return view('home', ['array'=>$array]);
    }


    public function mlCategories(){
        
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.mercadolibre.com/sites/MCO/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        // Create a client with a base URI
        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', 'categories');
        return($response->getBody()->getContents());
    }

    public function category($id){
        
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.mercadolibre.com/categories/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        // Create a client with a base URI
        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', "{$id}");
        return($response->getBody()->getContents());
    }

    
}
