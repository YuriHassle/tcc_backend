<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function register(StoreUserRequest $request)
    {
        if ($request->validated()) {
            $user = User::create($request->all());
            $user->createToken($user->email)->plainTextToken;
            return $this->sendResponse(new UserResource($user), 'Usuário criado com sucesso', 201);
        } else {
            return $this->sendError('Erro na validação dos dados.');
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            $result['user'] = $user;
            $result['token'] =  $user->createToken($user->email)->plainTextToken;

            return $this->sendResponse($result, 'The user successfully logged in.', 200);
        } else {
            return $this->sendError('Invalid credentials.', [], 403);
        }
    }

    /**
     * Returns the logged user api
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoggedUser(Request $request)
    {
        $user = Auth::user();

        if (!is_null($user)) {
            return $this->sendResponse(new UserResource($user), 'The user was successfully retrieved.');
        } else {
            return $this->sendError('User not retrieved.');
        }
    }

    /**
     * Logout api
     * Revoke tokens
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->sendResponse([''], 'The user successfully logged out.');
    }
}
