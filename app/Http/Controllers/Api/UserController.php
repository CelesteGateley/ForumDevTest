<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = UserRepository::login($request->email, $request->password);
        if (!isset($user)) return response()->json(['success' => false, 'message' => 'An account with those credentials does not exist'], 403);
        $token = $user->repository()->getToken();
        return response()->json(['success' => true, 'token' => $token->token, 'expiry' => $token->expiry,]);
    }
}
