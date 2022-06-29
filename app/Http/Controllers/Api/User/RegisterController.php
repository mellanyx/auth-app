<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:11'],
            'birthdate' => ['required', 'date_format:Y-m-d'],
            'password' => ['required', 'min:4'],
            'address' => ['required'],
        ];

        $customMessages = [
            'required' => 'Поле :attribute является обязательным',
            'email' => 'Поле :attribute должно содержать email',
            'min' => 'Поле :attribute должно содержать минимум 4 символа',
            'date_format' => 'Дата должна быть в формате d.m.Y',
        ];

        $validator = Validator::make($request->post(), $rules, $customMessages);

        if ($validator->fails()) {
            return \Response::json([
                'errorCode' => 1,
                'msg' => $validator->errors()
            ], 401);
        }

        if (User::where('email', $validator->valid()['email'])->exists()) {
            return \Response::json([
                'errorCode' => 1,
                'msg' => ['email' => ['Такой пользователь уже существует']]
            ], 401);
        }

        $user = User::create($validator->valid());

        if ($user) {
            auth()->login($user, $request->get('remember'));

            return \Response::json([
                'errorCode' => 0,
                'msg' => ['success' => ['Пользователь успешно зарегистрирован']]
            ]);
        }

        return \Response::json([
            'errorCode' => 1,
            'msg' => ['error' => ['Произошла ошибка при регистрации пользователя']]
        ], 401);
    }
}
