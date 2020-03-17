<?php

namespace App\Http\Controllers;

use Socialite;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  /**
     * Redirect the user to the Meli authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('meli')->redirect();
    }

    /**
     * Obtain the user information from Meli.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $meliUser = Socialite::driver('meli')->user();
        //dd($meliUser);
        //Auth::login($meliUser, true);
        return redirect()->route('home');
    }  //

}
