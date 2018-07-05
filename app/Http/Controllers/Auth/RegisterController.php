<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificationEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['resend',  'confirm']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_token' => base64_encode($data['email'])
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $errors = $this->validator($request->all())->errors();

        if (count($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        event(new Registered($user = $this->create($request->all())));

        dispatch(new SendVerificationEmail($user));

        $this->guard()->login($user);

        session()->flash('status', 'Registered successfully, an verification email has been send, please confirm it !');

        return redirect('home');
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm($token)
    {
        $user = User::where('email_token', $token)->first();
        if (!$user) {
            session()->flash('status', 'Email confirmation expired');
            return abort(200, 'Email confirmation expired');
        }

        $user->confirmed = true;
        $user->email_token = null;

        $user->save();
        $this->guard()->login($user);
        session()->flash('status', 'Email confirmed with success !');

        return redirect('home');

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend()
    {
        $user = auth()->user();

        dispatch(new SendVerificationEmail($user));
        session()->flash('status', 'An new email was send.');

        return redirect('home');
    }
}
