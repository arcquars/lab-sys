<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Person;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        die(encrypt('123Medico'));
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('guest.login-guest');
    }

    public function login()
    {
        return view('guest.login');
    }

    public function postLogin(Request $request)
    {
        request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        }
        return Redirect::to("guest/login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function postLoginGuest(Request $request)
    {
        request()->validate([
            'ci' => 'required',
            'password' => 'required',
        ]);

//        dd($request->post('password'));
        $person = Person::where('ci', $request->post('ci'))->first();
        if($person && strcmp($request->post('ci'), $person->ci) == 0 && strcmp($request->post('password'), 'h'.$person->ci) == 0){
            $request->session()->regenerate();
            $request->session()->put('guest', $person);
            return redirect()->intended('/guest/home');
        }

        return Redirect::to("guest")->withErrors('Credenciales incorrectas.');
    }

    public function postLogoutGuest(Request $request){
        Session::flush();
        Auth::logout();
        return redirect('/guest');
    }

    public function home()
    {
        if(!Session::get('guest')){
            return redirect('/guest');
        }
        $person = Session::get('guest');
        return view('guest.view', compact('person'));
    }
}
