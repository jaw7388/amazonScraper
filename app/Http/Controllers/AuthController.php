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
        $user = Socialite::driver('meli')->user();

        // $user->token;
        // Tokens & Expire time
		$token         = $user->token;
		$refresh_token = $user->refresh_token;
		$expires_at    = $user->expires_at; // UNIX TIMESTAMP

		// Methods from Socialite User 
		$user->getId();
		$user->getNickname();
		$user->getName();
		$user->getEmail();

		// Raw Data
		$user->user; // Provided by Meli
    }  //

}
