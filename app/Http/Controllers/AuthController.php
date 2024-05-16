<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function authenticate(AuthRequest $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {

                return successResponse(__('auth.success'));
            }

            return failureResponse(__('auth.failed'),JsonResponse::HTTP_UNAUTHORIZED);
        }catch(Throwable $e)
        {
            errorLogger('AuthController@authenticate', $e);
            return redirect('/login')->with('error', 'Something went wrong');
        }
    }

    public function signInwithGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callbackToGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();

            $existingUser = User::where('google_id', $user->id)
                ->where('email', $user->email)
                ->first();

            if (!empty($existingUser)) {
                Auth::login($existingUser);
            }else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id
                ]);
                Auth::login($user);
            }

            return redirect('/dashboard');
        } catch (Throwable $e) {
            errorLogger('AuthController@callbackToGoogle', $e);
            return redirect('/login')->with('error', 'Something went wrong');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        } catch (\Exception $e) {
            errorLogger('AuthController@logout', $e);
            return redirect()->back()->with(['error' => __('auth.logout_failed')]);
        }
    }
}
