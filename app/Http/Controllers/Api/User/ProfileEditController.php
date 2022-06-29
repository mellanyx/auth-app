<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileEditController extends Controller
{
    public function edit(Request $request)
    {
        $userID = $request->post('id');

        $rules = [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:11'],
            'birthdate' => ['required', 'date_format:Y-m-d'],
            'address' => ['required'],
            'password' => ['min:4'],
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
                'msg' => ['errors' => $validator->errors()]
            ], 401);
        }

        $userValidData = $validator->valid();

        // Убираем пустые поля и лишние
        foreach ($userValidData as $key => $val) {
            unset($userValidData['id']);

            if (empty($val)) {
                unset($userValidData[$key]);
            }
        }

        if (!empty($userValidData['password'])) {
            $userValidData['password'] = Hash::make($userValidData['password']);
        }

        User::where('id', $userID)
            ->update($userValidData);

        return \Response::json([
            'errorCode' => 0,
            'user' => User::where('id', $userID)->first(),
            'msg' => ['success' => ['Данные пользователя успешно изменены']]
        ]);
    }
}
