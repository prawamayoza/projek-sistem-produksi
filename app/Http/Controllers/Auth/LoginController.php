<?php

namespace App\Http\Controllers\Auth;

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
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Get the login credentials and check if user is active.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // Menggunakan username() bukan email() dan memastikan akun aktif
        return array_merge($request->only($this->username(), 'password'), ['is_active' => 1]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = \App\Models\User::where($this->username(), $request->{$this->username()})->first();

        if (!$user) {
            // Jika akun tidak terdaftar
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([$this->username() => 'Akun tidak terdaftar.']);
        }

        if (!$user->is_active) {
            // Jika akun tidak aktif
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([$this->username() => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
        }

        // Jika password salah
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => 'Password salah.']);
    }
    
    protected function authenticated(Request $request, $user)
    {
        // Set flash message setelah berhasil login
        $request->session()->flash('success', 'Anda berhasil login!');

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Menyimpan pesan sukses ke dalam session flash
        return redirect('/login')->with('status', 'Anda berhasil logout.');
    }   

}
