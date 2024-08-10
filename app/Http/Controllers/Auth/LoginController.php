<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve the role name
            $role = Auth::user()->role->name ?? null;
    
            // Redirect based on the role
            switch ($role) {
                case 'admin':
                    return '/admin/dashboard';
                case 'vendor':
                    return '/vendor/dashboard';
                case 'customer':
                    return '/customer/index';
                default:
                    return '/home'; // Fallback route
            }
        }
    
        // Fallback if the user is not authenticated
        return '/login';
    }
    
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
