<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }
    public function adminlogin()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('admin.pages.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required'
        ]);

        $remember = $request->has('remember') ? true : false;

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            flash(__('auth.failed'))->error();
            return back()->with('phone', __('auth.failed'));
        }
        if($user->type != User::TYPE_CLIENT){
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, $remember);
                if($user->type==User::TYPE_RESPONSIBLE){

                    session()->put('responsiveId', $user->id);
                 }
                return redirect()->route('home');

            }
        }else{
            Auth::login($user, $remember);
            return redirect()->route('home');

        }
        return back()
            ->withInput($request->only('phone', 'remember'))
            ->withErrors(['phone' => __('auth.failed')]);
    }

    public function logout()
    {
        Auth::logout();
            return redirect()->route('login');

    }
}
