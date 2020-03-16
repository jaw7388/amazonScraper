<?php

namespace App\Providers;
//namespace Kolovious\MeliSocialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
use GuzzleHttp\ClientInterface;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;

use Laravel\Socialite\Two\User;

class MeliSocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //// Here we will be registering the facade, but not now yet.
        $this->app->bind('Kolovious\MeliSocialite\MeliManager',function() {
            return new MeliManager(
                            $this->app['config']['services.meli.client_id'],
                            $this->app['config']['services.meli.client_secret']
                        );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'meli',
            function ($app) use ($socialite) {
                $config = $app['config']['services.meli'];
                return $socialite->buildProvider(MeliSocialite::class, $config);
            }
        );
    }
}





class MeliSocialite extends AbstractProvider implements ProviderInterface
{
    /**
     * @var string Refresh Token
     */
    protected $refresh_token;
    /**
     * @var string Access Token Expires in
     */
    protected $expires_in;
    /**
     * @var string With Access Token, Refresh Token and Expires In.
     */
    protected $parsed_response;

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(MeliManager::$AUTH_URL, $state);
    }

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    protected function getTokenUrl()
    {

        $token_url = MeliManager::$API_ROOT_URL.MeliManager::$OAUTH_URL;

        return $token_url;
    }


    protected function getTokenFields($code)
    {
        return [
            'client_id' => $this->clientId, 'client_secret' => $this->clientSecret,
            'grant_type'=>'authorization_code',
            'code' => $code, 'redirect_uri' => $this->redirectUrl,
        ];
    }

    /**
     * Get the raw user for the given access token.
     *
     * @param  string $token
     * @return array
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(MeliManager::$API_ROOT_URL.'/users/me?'.http_build_query(['access_token'=>$token]));
        $output = json_decode($response->getBody(), true);
        return $output;
    }

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param  array $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new MeliUser)->setRaw($user)->map([
            'id'                => $user['id'],
            'nickname'          => $user['nickname'],
            'name'              => trim($user['first_name'].' '.$user['last_name']),
            'email'             => (isset($user['email']))? $user['email'] : \Auth::user()->email,
        ]);
    }

    public function getAccessToken($code)
    {
        $postKey = (version_compare(ClientInterface::VERSION, '6') === 1) ? 'form_params' : 'body';

        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => ['Accept' => 'application/json'],
            $postKey => $this->getTokenFields($code),
        ]);

        return $this->parseResponse($response->getBody())->parsedAccessToken();
    }

    protected function parseResponse($body)
    {
        $this->parsed_response = json_decode($body, true);
        return $this;
    }

    protected function parsedAccessToken()
    {
        return $this->parsed_response['access_token'];
    }

    protected function getRefreshToken()
    {
        return $this->parsed_response['refresh_token'];
    }

    protected function getExpiresIn()
    {
        return $this->parsed_response['expires_in'];
    }

    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException;
        }

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = $this->getAccessToken($this->getCode())
        ));

        return $user->setToken($token)->setRefreshToken($this->getRefreshToken())->setExpiresIn($this->getExpiresIn());;
    }
}







/**
 * Class MeliManager
 * @package Kolovious\MeliSocialite
 * This class is cut off of Meli Official SDK, we removed all the auth part, because we only need the API interaction here.
 * When the Meli Official SDK were available via Composer, we will change this
 */

class MeliManager
{
    public static $API_ROOT_URL = "https://api.mercadolibre.com";
    public static $AUTH_URL     = "http://auth.mercadolibre.com/authorization";
    public static $OAUTH_URL    = "/oauth/token";

    /**
     * Configuration for CURL
     */
    public static $CURL_OPTS = array(
        CURLOPT_USERAGENT => "MELI-PHP-SDK-2.0.0",
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 60
    );

    protected $client_id;
    protected $client_secret;
    protected $access_token;
    protected $refresh_token;

    /**
     * @var boolean Next is with token?
     */
    protected $call_with_token;

    /**
     * Constructor method.
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $access_token
     * @param string $refresh_token
     */
    public function __construct($client_id, $client_secret, $access_token = null, $refresh_token = null) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->call_with_token=false;
    }

    /**
     * Execute a POST Request to create a new AccessToken from a existent refresh_token
     *
     * @return string|mixed
     */
    public function refreshAccessToken() {

        if($this->refresh_token) {
            $body = array(
                "grant_type"    => "refresh_token",
                "client_id"     => $this->client_id,
                "client_secret" => $this->client_secret,
                "refresh_token" => $this->refresh_token
            );

            $opts = array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body
            );

            // Cancel if the access_token is set, the call for refresh with it
            // FIXED BY: Matias Azar - matiazar@gmail.com
            $this->call_with_token = false;
            $request = $this->execute(self::$OAUTH_URL, $opts);

            if($request["httpCode"] == 200) {
                $this->access_token = $request["body"]->access_token;

                if($request["body"]->refresh_token)
                    $this->refresh_token = $request["body"]->refresh_token;

                return $request;

            } else {
                return $request;
            }
        } else {
            $result = array(
                'error' => 'Offline-Access is not allowed.',
                'httpCode'  => null
            );
            return $result;
        }
    }


    /**
     * Execute a GET Request
     *
     * @param string $path
     * @param array $params
     * @return mixed
     */
    public function get($path, $params = null) {
        $exec = $this->execute($path, null, $params);
        return $exec;
    }
    /**
     * Execute a POST Request
     *
     * @param string $body
     * @param array $params
     * @return mixed
     */
    public function post($path, $body = null, $params = array()) {
        $body = json_encode($body);
        $opts = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body
        );

        $exec = $this->execute($path, $opts, $params);
        return $exec;
    }
    /**
     * Execute a PUT Request
     *
     * @param string $path
     * @param string $body
     * @param array $params
     * @return mixed
     */
    public function put($path, $body = null, $params) {
        $body = json_encode($body);
        $opts = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $body
        );

        $exec = $this->execute($path, $opts, $params);
        return $exec;
    }
    /**
     * Execute a DELETE Request
     *
     * @param string $path
     * @param array $params
     * @return mixed
     */
    public function delete($path, $params) {
        $opts = array(
            CURLOPT_CUSTOMREQUEST => "DELETE"
        );

        $exec = $this->execute($path, $opts, $params);

        return $exec;
    }
    /**
     * Execute a OPTION Request
     *
     * @param string $path
     * @param array $params
     * @return mixed
     */
    public function options($path, $params = null) {
        $opts = array(
            CURLOPT_CUSTOMREQUEST => "OPTIONS"
        );

        $exec = $this->execute($path, $opts, $params);
        return $exec;
    }
    /**
     * Execute all requests and returns the json body and headers
     *
     * @param string $path
     * @param array $opts
     * @param array $params
     * @return mixed
     */
    public function execute($path, $opts = array(), $params = array()) {
        $uri = $this->make_path($path, $params);
        $ch = curl_init($uri);
        curl_setopt_array($ch, self::$CURL_OPTS);

        if(!empty($opts)) {
            curl_setopt_array($ch, $opts);
        }

        $return["body"] = json_decode(curl_exec($ch));
        $return["httpCode"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $return;
    }


    /**
     * Next call to the API will be sent with access_token as parameter.
     * @param string|null $token We can sent the token to set it up in the object for future calls.
     * @return $this MeliManager
     */
    public function withToken($token=null)
    {
        if($token) {
            $this->access_token = $token;
        }

        $this->call_with_token=true;
        return $this;
    }

    /**
     * Save refresh token for refreshToken Call
     * @param string|null $refresh_token to be saved
     * @return $this MeliManager
     */
    public function withRefreshToken($token)
    {
        $this->refresh_token = $token;
        return $this;
    }

    /**
     * Wrapper for using the Actual user
     * @return MeliManager
     */
    public function withAuthToken()
    {
        $user = Auth::user();
        return $this->withToken($user->access_token)->withRefreshToken($user->refresh_token);
    }

    /**
     * Check and construct an real URL to make request
     *
     * @param string $path
     * @param array $params
     * @return string
     */
    public function make_path($path, $params = array()) {
        if (!preg_match("/^http/", $path)) {
            if (!preg_match("/^\//", $path)) {
                $path = '/'.$path;
            }
            $uri = self::$API_ROOT_URL.$path;
        } else {
            $uri = $path;
        }
        // FIX: If access_token is set, and we have the flag to call withToken, first, we send as a param the access_token, then we set the flag to 0
        if($this->access_token && $this->call_with_token) {
            $params['access_token'] = $this->access_token;
            $this->call_with_token = false;
        }

        if(!empty($params)) {
            $paramsJoined = array();
            foreach($params as $param => $value) {
                $paramsJoined[] = "$param=$value";
            }
            $params = '?'.implode('&', $paramsJoined);
            $uri = $uri.$params;
        }
        return $uri;
    }
}





class MeliUser extends User
{
    public $refresh_token;

    protected $expired_in;

    public $expires_at;

    /**
     * Set the token on the user.
     *
     * @param  string  $refresh_token
     * @return $this
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;

        return $this;
    }

    /**
     * Set the token on the user.
     *
     * @param  string  $expires_in
     * @return $this
     */
    public function setExpiresIn($expires_in)
    {
        $this->expired_in = $expires_in;
        $this->expires_at = time()+$expires_in;

        return $this;
    }
}