<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use TimeHunter\LaravelGoogleReCaptchaV3\Facades\GoogleReCaptchaV3;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
            return Validator::make($data,[
                'name'     => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                //'email'  => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8','confirmed'],
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'username'  => $data['username'],
            'password'  => Hash::make($data['password']),
            'user_type' => 'none',
            'state' => 0,
        ]);
       
    }

    public function customRegisterUser(Request $request)
    {
        $responseRecaptcha=GoogleReCaptchaV3::verifyResponse($request->input('g-recaptcha-response'),$request->getClientIp())->toArray();
        //dd($responseRecaptcha);
        if($responseRecaptcha['success']==true && $responseRecaptcha['score']>= 0.6){
            $validate = \Validator::make($request->all(), [
                'name' 		=> 'required',
                'username'	 	=> 'required|max:255',
                'password' 	=> 'required|confirmed|max:255'
            ]);
            if( $validate->fails()){
                return redirect()
                ->back()
                ->withErrors($validate);
            }
            $user_create = User::create([
                'name'      => $request->name,
                'username'  => $request->username,
                'password'   => Hash::make($request->password),
                'user_type' => 'none',
                'state' => 0,
            ]);
            return redirect('/register')->with('success', 'Successfully registered');
        }else{
            return redirect()->route('register')->with('error','ReCaptcha Error');
        }
    }
}
