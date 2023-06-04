<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function logout() {
        auth()->logout();
        return redirect('/')->with('success', 'Deslogado com sucesso!');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if(auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Logado com sucesso!');
        }else{
            return redirect('/')->with('failure', 'Falha no login!');
        }

    }

    public function showCorrectHomepage() {
        if(auth()->check()){
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function register(Request $request) {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:6', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        //$incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Registrado com sucesso!');
    }

    public function profile(User $user) {

        return view('profile-posts', ['username' => $user->username, 'posts' => $user->posts()->get(), 'postCount' => $user->posts()->count()]);
    }
}
