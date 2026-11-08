<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogInController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['username' => 'Invalid username or password.'])
                ->onlyInput('username');
        }

        $request->session()->put('is_admin', (bool) $user->is_admin);
        $request->session()->put('auth_user_id', $user->id);
        $request->session()->put('auth_username', $user->username);

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('landing');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['is_admin', 'auth_user_id', 'auth_username']);

        return redirect()->route('login');
    }

    public function register()
    {
        return view('register');
    }

    public function registerStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $baseUsername = Str::slug($data['name']);
        $username = $baseUsername ?: 'user';
        $suffix = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . $suffix++;
        }

        User::create([
            'name' => $data['name'],
            'username' => $username,
            'email' => $data['email'],
            'password' => $data['password'],
            'is_admin' => false,
        ]);

        $request->session()->put('is_admin', false);

        return redirect()->route('login')->with('success', 'Account created. You can now log in.');
    }
}
