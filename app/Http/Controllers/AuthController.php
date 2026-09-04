<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function create() {
        return view('admin.auth.login');
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Check it again!!',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('admin.home'));
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->sessiono()->regenerateTooken();

        return redirect()->route('auth.login');
    }
}
