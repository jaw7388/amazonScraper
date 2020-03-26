<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Kolovious\MeliSocialite\Facade\Meli;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    

    public function __construct()
    {
        //$this->middleware('auth');

        $this->currentUser = Auth::user()->id;
        $this->mlUser = User::where('id', $this->currentUser )->firstOrFail();
        $this->access_token = $this->mlUser->token;
        $this->user_id = $this->mlUser->ml_id;
    }


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
     * @return Response
     */
     public function handleProviderCallback()
    {
        $meliUser = Socialite::driver('meli')->user();
        
        //$mlUser = User::where('ml_id', $meliUser->id)->first();
        User::where('id', $this->user_id)
              ->update([
                  'ml_id' => $meliUser->id,
                  'token' => $meliUser->token,
                  'refresh_token' => $meliUser->refresh_token,
                  'ml_nickname' => $meliUser->nickname,
                  'ml_username' => $meliUser->name,
                  'ml_avatar' => $meliUser->avatar],  
        );

              

        // $mlUser['expires_at'] = $meliUser->expires_at;
        // $mlUser['token'] = $meliUser->token;
        // $mlUser['refresh_token'] = $meliUser->refresh_token;
        // $mlUser['expires_at'] = $meliUser->expires_at;
        // $mlUser['id'] = $meliUser->id;
        // $mlUser['nickname'] = $meliUser->nickname;
        // $mlUser['name'] = $meliUser->name;
        // $mlUser['email'] = $meliUser->email;
        // $mlUser['avatar'] = $meliUser->avatar;
        // dd($meliUser);
        // echo "<pre>";
        // print_r($mlUser);
        //Auth::login($meliUser, true);
        //return redirect()->route('home');
        //return view('home', ['token' => $token, 'refresh_token' => 'refresh_token', 'expires_at' => 'expires_at']);
        // $params = array('access_token' => $access_token);
        // $result = Meli::get('/users/me', $params, true); 
    }  //

    public function queryget()
    {    
        $mlUser = User::where('id', Auth::user()->id )->firstOrFail();
        $access_token = $mlUser->token;
        $user_id = $mlUser->ml_id;
    
        $offset = 0;
        $call= "/users/".$user_id."/items/search";
        $result = Meli::get($call, ["offset"=>$offset, 'access_token'=>$access_token]);
        return view('home', ['result'=>$result]);
    }

}