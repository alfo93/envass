<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LogEvent;
use Hash;
use App\User;
use Auth;
use Defender;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Log;
use App\Event\LoggerEvent;

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

    /**
     * Sovrascrivo il metodo che mostra il form di login per fare l'accesso automaticamente
     *
     * @return mixed
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // $request->validate([
        //     'uid' => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // $credentials = $request->only('uid', 'password');

        // if (Auth::attempt($credentials)) {
        //     return redirect()->intended('/');
        // }

        $attributes = request()->validate([
            'uid'=>'required',
            'password'=>'required' 
        ]);

        $uid = $attributes['uid'];
        $password = $attributes['password'];

        if (!empty($uid)) {     
            $user = User::where('uid', '=', $uid)->where('versione',2)->first();
           
            if ($user) {
                if(Hash::check($password, $user->password)) 
                {
                    Log::info($user);
                    Auth::login($user);
                    LoggerEvent::log(auth()->user()->id, 'Login effettuato',['uid' => auth()->user()->uid],false,null);
                    return redirect()->intended('/');
                }
                else
                {
                    return back()->withErrors(['password'=>'Password errata.']);
                }           
            } else {
                Log::info("L'utente $uid non è autorizzato");
                return redirect('login')->with('error', 'Oppes! Hai inserito credenziali errrate');
            }
        }
    }

    /**
     * The user has logged out of the application.
     *
     * @return mixed
     */
    protected function loggedOut()
    {
        return view('bye');
    }
}
