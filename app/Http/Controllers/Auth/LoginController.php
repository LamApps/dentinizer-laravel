<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use TimeHunter\LaravelGoogleReCaptchaV3\Facades\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $responseRecaptcha=GoogleReCaptchaV3::verifyResponse($request->input('g-recaptcha-response'),$request->getClientIp())->toArray();
        //dd($responseRecaptcha);
        if($responseRecaptcha['success']==true && $responseRecaptcha['score']>= 0.6){
            $inputVal = $request->all();
            $this->validate($request, [
                'username' => 'required|string',
                'password' => 'required',
            ]);
            if(auth()->attempt(array('username' => $inputVal['username'], 'password' => $inputVal['password']))){
                if (auth()->user()->user_type == "admin")
                    return redirect()->route('admin.home');
                else if (auth()->user()->user_type == "doctor" && auth()->user()->state == 1 ) 
                    return redirect()->route('doctor.home');
                else if (auth()->user()->user_type == "nurse" && auth()->user()->state == 1 ) 
                    return redirect()->route('nurse.home');
                else if (auth()->user()->user_type == "reception" && auth()->user()->state == 1 ) 
                    return redirect()->route('reception.home');
                else if (auth()->user()->state == 0 ){
                    Auth::logout();
                    return redirect()->route('login')
                    ->with('error','Account Still suspensed.');
                }
            }else{
                return redirect()->route('login')->with('error','Email or Password are incorrect.');
            }
        }else{
            return redirect()->route('login')->with('error','ReCaptcha Error');
        }     
    }

}
