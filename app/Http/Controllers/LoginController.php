<?php

namespace App\Http\Controllers;

use App\CustomOption;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {

        $code = $request->get('code');
        $token = $this->getWPAuthToken($code);
        $user = $this->getWPUser($token);

        if ($dbuser = User::where('email', '=', $user['user_email'])->get()->first()) {

            // User already exists, we log them in
            Auth::loginUsingId($dbuser->id);

            return redirect()->route('home');

        } else {

            // User doesn't exist and they need to be created.
            $laravelUser = User::create([
                'name' => $user['display_name'],
                'email' => $user['user_email'],
                'password' => '1234'
            ]);

            $laravelUser->save();

            Auth::login($laravelUser);

            return redirect()->route('home');

        }

    }

    public function logout()
    {
        session()->remove('WP_AUTH_TOKEN');
        Auth::logout();
        return redirect()->route('home');
    }

    private function getWPAuthToken(String $code)
    {

        if (session()->has('WP_AUTH_TOKEN')) {

            return session()->pull('WP_AUTH_TOKEN');

        } else {

            $client_id = CustomOption::get('WP_SSO_PUB_KEY');
            $client_secret = CustomOption::get('WP_SSO_PRIV_KEY');

            $curl_post_data = array(
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => CustomOption::get('WP_SSO_RET_URL'),
                'client_id' => $client_id,
                'client_secret' => $client_secret
            );

            $curl = curl_init(CustomOption::get('WP_SSO_URL') . '?oauth=token');

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
            curl_setopt($curl, CURLOPT_REFERER, env('WP_SSO_RET_URL'));

            $curl_response = curl_exec($curl);
            curl_close($curl);
            $curl_response = json_decode($curl_response, true);

            session(['WP_AUTH_TOKEN' => $curl_response['access_token']]);

            return session()->pull('WP_AUTH_TOKEN');

        }

    }

    public function getWPUser(String $token)
    {

        $service_url = CustomOption::get('WP_SSO_URL') . '?oauth=me&access_token=' . $token;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // If the url has https and you don't want to verify source certificate

        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response, true);

        curl_close($curl);

        return $response;

    }

}
