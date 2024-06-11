<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Returns field name to use at login.
     *
     * @return string
     */
    public function username()
    {
        return config('auth.providers.users.field', 'email');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->username() === 'email') {
            return $this->attemptLoginAtAuthenticatesUsers($request);
        }
        if (! $this->attemptLoginAtAuthenticatesUsers($request)) {
            return $this->attempLoginUsingUsernameAsAnEmail($request);
        }
        return false;
    }

    /**
     * Attempt to log the user into application using username as an email.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempLoginUsingUsernameAsAnEmail(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->input('username'), 'password' => $request->input('password')],
            $request->has('remember')
        );
    }

    protected function sendLoginResponse(Request $request)
    {
        // Existing code from AuthenticatesUsers trait
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        // Add CSRF token generation and response
        $csrfToken = csrf_token();

        // Check if this is an API request and respond accordingly.
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => $this->guard()->user(),
                'csrf_token' => $csrfToken,
            ]);
        }

        // If it's not an API request, use the default redirect.
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate a new CSRF token after successful login
            $csrfToken = csrf_token();

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => Auth::user(),
                'csrf_token' => $csrfToken // Include CSRF token in response
            ]);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    }
    public function login2(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate a new CSRF token after successful login
            $csrfToken = csrf_token();

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => Auth::user(),
                'csrf_token' => $csrfToken // Include CSRF token in response
            ]);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    }
}

