<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class AuthController extends Controller
{
    public function auth(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate(
            [
                'email'    => ['required', 'email'],
                'password' => ['required'],
            ]
        );

        if (Auth::attempt($credentials, (bool) $request->input('remember'))) {
            $request->session()->regenerate();
            return \Response::json([
                'errorCode' => 0,
                'id' => Auth::user()->id
            ]);
        } else {
            return \Response::json([
                'errorCode' => 1,
                'msg' => ['error' => 'Данные не верны']
            ], 401);
        }
    }

    public function getCurrentAuth(): \Illuminate\Http\JsonResponse
    {
        if ($user = Auth::user()) {
            return \Response::json([
                'errorCode' => 0,
                'id' => $user->id,
                'name' => $user->name,
                'birthdate' => $user->birthdate,
                'phone' => $user->phone,
                'address' => $user->address,
                'email' => $user->email,
            ]);
        }

        return \Response::json([
            'errorCode' => 1,
            'message' => __('auth.unknown'),
        ], 401);
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}
