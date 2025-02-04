<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\IpUtils;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if (Auth::check()){
            $previous_session = Auth::User()->session_id;
            if ($previous_session) {
                Session::getHandler()->destroy($previous_session);
                Auth::logout();
                redirect('/');
            }
        }
    }

//    public function login(Request $request){
//
//        $input = $request->all();
//
//        $this->validate($request, [
//            'username' => 'required',
//            'password' => 'required',
//            'g-recaptcha-response' => 'required',
//        ]);
//
//        $recaptcha_response = $request->input('g-recaptcha-response');
//
//        if (is_null($recaptcha_response)) {
//            return redirect()->back()->with('status', 'Please Complete the Recaptcha to proceed');
//        }
//
//        $url = "https://www.google.com/recaptcha/api/siteverify";
//
//        $body = [
//            'secret' => config('services.recaptcha.secret'),
//            'response' => $recaptcha_response,
//            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
//        ];
//
//        $response = Http::asForm()->post($url, $body);
//
//        $result = json_decode($response);
//
//        if ($response->successful() && $result->success == true) {
//
//
//            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
//            if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
//                $role1 = Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN');
//                $role2 = Auth::user()->hasRole('CIUDADANO|DELEGADO');
//
//                $user = Auth::user();
//                $user->session_id = session()->getId();
//                $user->logged_at = now();
//                $user->logged = true;
//                $user->save();
//
//
//                if ($role1) {
//                    return redirect()->route('home');
//                } elseif($role2) {
//                    return redirect()->route('home-ciudadano');
//                } else {
//                    return redirect()->route('home');
//                }
//            }else{
//                return redirect()->route('login')
//                    ->with('error','Username, email ó password incorrecto');
//            }
//
//        } else {
//            return redirect()->back()->with('status', 'Please Complete the Recaptcha Again to proceed');
//        }
//
//    }


    public function login(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']))) {
                $role1 = Auth::user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN');
                $role2 = Auth::user()->hasRole('CIUDADANO|DELEGADO');

                $user = Auth::user();
                $user->session_id = session()->getId();
                $user->logged_at = now();
                $user->logged = true;
                $user->save();


                if ($role1) {
                    return redirect()->route('home');
                } elseif($role2) {
                    return redirect()->route('home-ciudadano');
                } else {
                    return redirect()->route('home');
                }
            }else{
                return redirect()->route('login')
                    ->with('error','Username, email ó password incorrecto');
            }

    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function redirectPath(){

    }

    public function authenticated(Request $request, $user)
    {
        Auth::logoutOtherDevices(request('password'));
        if ($user->session_id){
            Session::getHandler()->destroy($user->session_id);
        }
        $user->session_id = session()->getId();
        $user->save();
        return redirect()->intended($this->redirectPath());
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request){
        $user = Auth::user();

        $user->logged = false;
        $user->logout_at = now();
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }


}
