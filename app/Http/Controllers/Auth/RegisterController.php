<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirm' =>['same:password'],
            'staff_id' => ['required', 'string', 'max:150'],
            'fullname' => ['required', 'string', 'max:50'],
            'dob'=> ['required'],
            'phone'=> ['required', 'max:10'],
            'zalo'=> ['required', 'string', 'max:15'],
            'address'=> ['required', 'string', 'max:250'],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'ID_Staff' => $data['staff_id'],
            'fullname' => $data['fullname'],
            'DoB' => $data['dob'],
            'sex' => $data['sex'],
            'phone' => $data['phone'],
            'zalo_id' => $data['zalo'],
            'address' => $data['address'],
            'avatar' => '1',
            /*'avatar' => $data['avatar'],*/
            'ID_Position' => $data['position'],
            'ID_Role' => $data['role'],
            /*'user_15' => $user_15,
            'user_16' => $user_16,
            'user_17' => $user_17,
            'user_18' => $user_18,
            'user_19' => $user_19,*/
        ]);
    }
}
