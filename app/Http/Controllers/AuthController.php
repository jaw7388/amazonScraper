<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Kolovious\MeliSocialite\Facade\Meli;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) 
        {
            $this->currentUser = Auth::user()->id;
            $this->mlUser = User::where('id', $this->currentUser )->firstOrFail();
            $this->access_token = $this->mlUser->token;
            $this->user_id = $this->mlUser->ml_id;

            return $next($request);
        });
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
        $user = $meliUser->user;
        $avatar = $user['thumbnail'];
        
        if (isset($avatar['picture_url'])) {
            $avatar = $avatar['picture_url'];
        }else{
            $avatar = null;
        }
        
        User::where('id', $this->currentUser)
              ->update([
                'ml_id' => $meliUser->id,
                'token' => $meliUser->token,
                'refresh_token' => $meliUser->refresh_token,
                'ml_nickname' => $meliUser->nickname,
                'ml_username' => $meliUser->name,
                'ml_avatar' => $avatar,
                'expires_at' => $meliUser->expires_at],  
        );

        return Redirect::back();
        //return view('home', [ 'avatar'=>$meliUser, 'xxx'=>$avatar]);
    }  

    public function queryget()
    {    
        $offset = 0;
        $call= "/users/".$this->user_id."/items/search";
        $result = Meli::get($call, ["offset"=>$offset, 'access_token'=>$this->access_token]);
        return view('home', ['result'=>$result]);
    }

    public function settings(){
        return view('settings');
    }
}