<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        return User::findOrFail(Auth::id())->only(['id', 'name', 'email']);
    }

    public function getRandomUserCredentials()
    {
        return response([
            'email' => User::all()->random()->email, 
            'password' => 'password']);
    }
}
