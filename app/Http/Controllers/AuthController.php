<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function signInwithGoogle()
    {
        return Socialite::driver('google')
            // ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callbackToGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();

            $existingUser = User::where('google_id', $user->id)
                ->where('email', $user->email)
                ->first();

            if (empty($existingUser)) {
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id
                ]);
            }

            Auth::login($user);
            return redirect('/dashboard');
        } catch (Throwable $th) {
            errorLogger('AuthController@callbackToGoogle', $th);
            return redirect('/login')->with('error', 'Something went wrong');
        }
    }
}
