<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ActionsController extends Controller
{
    public function getUsers() {
        return \Response::json([
            'errorCode' => 0,
            'users' => User::orderByDesc('id')->get()
        ]);
    }
}
