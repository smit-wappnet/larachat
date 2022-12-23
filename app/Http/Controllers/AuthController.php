<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function dashboard()
    {
        $users =  User::where('id', '!=', Auth::user()->id)->get();
        $data = compact("users");
        return view('dashboard', $data);
    }

    public function signin_view()
    {
        return view("auth.signin");
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return redirect()->route("auth.signin")->withErrors("Error");
    }

    public function signup_view()
    {
        return view("auth.signup");
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return redirect()->route("auth.signup")->withErrors("Error");
    }

    public function signout()
    {
        Session::flush();
        Auth::logout();
        return redirect(url("/"));
    }

    public function forgot_password_view()
    {
        return view('auth.forgot-password');
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ], [
            'email.exists' => 'Please Enter Registered Email id'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status;
        return $request->all();
    }

    public function reset_password_view(Request $request, $token)
    {
        $email = $request->get('email');
        if ($email != null) {
            $data = compact("email", "token");
            return view('auth.reset-password', $data);
        } else {
            return redirect("/");
        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.signin');
        } else {
            return redirect()->route('auth.signin');
        }
    }
}
