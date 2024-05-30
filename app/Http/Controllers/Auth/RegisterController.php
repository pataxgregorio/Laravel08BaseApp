<?php

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\WelcomeUser;
use App\Notifications\RegisterConfirm;
use App\Notifications\NotificarEventos;


/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class RegisterController extends Controller{
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(){
        return view('adminlte::auth.register');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'username' => 'sometimes|required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'terms'    => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data){
        $fields = [
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'confirmation_code' => \Str::random(25),
            'init_day'          => \Carbon\Carbon::now(),
            'end_day'           => \Carbon\Carbon::now()->addMonth(6),
            'colores'           => array(
                                        'encabezado'=>'#5333ed',
                                        'menu'=>'#0B0E66',
                                        'group_button'=>'#5333ed',
                                        'back_button'=>'#5333ed',
                                        'process_button'=>'#5333ed',
                                        'create_button'=>'#5333ed',
                                        'update_button'=>'#5333ed',
                                        'edit_button'=>'#2962ff',
                                        'view_button'=>'#5333ed'
                                    ),
        ];
        if (config('auth.providers.users.field', 'email') === 'username' && isset($data['username'])) {
            $fields['username'] = $data['username'];
        }        
        $user = User::create($fields);
        $user->notify(new WelcomeUser);
        $user->notify(new RegisterConfirm);
        $notificacion = [
                'title' => trans('message.msg_notification.title'),
                'body' => trans('message.msg_notification.body')
            ]; 
        $user->notify(new NotificarEventos($notificacion));   
        return $user;
    }

    /**
     * Confirm a user with a given confirmation code.
     *
     * @param $confirmation_code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm($confirmation_code){
        try{
            $user = User::where('confirmation_code', $confirmation_code)->firstOrFail();            
            $user->confirmation_code = null;
            $user->confirmed_at = now();
            $user->activo = 'ALLOW';
            $colores = $user->colores;
            $user->save();
            $this->guard()->login($user);
            session(['menu_color' => $colores['menu']]);
            session(['encabezado_color' => $colores['encabezado']]);
            session(['group_button_color' => $colores['group_button']]);
            session(['back_button_color' => $colores['back_button']]);
            session(['process_button_color' => $colores['process_button']]);
            session(['create_button_color' => $colores['create_button']]);
            session(['update_button_color' => $colores['update_button']]);
            session(['edit_button_color' => $colores['edit_button']]);
            session(['view_button_color' => $colores['view_button']]);
        }catch(Exception $e){
            return redirect('/');    
        }catch(Throwable $e){
            return redirect('/');
        }               
        return redirect('/dashboard');
    }
}