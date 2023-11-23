<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerLoginRequest;
use App\Http\Requests\PlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] username
     * @param  [string] password
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:players',
            'password' => 'required|string',

        ]);

        $user = new Player([
            'username'  => $request->username,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function login(PlayerLoginRequest $request)
    {
        $requestValidated = $request->validated();

        $credentials = [
            'username' => $requestValidated['username'],
            'password' => $requestValidated['password'],
        ];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }


        $player = $request->player();
        $tokenResult = $player->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }

        return response()->json([
            'message' => 'User not authenticated',
        ], 401);
    }
}
