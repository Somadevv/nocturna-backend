<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerLoginRequest;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:players',
            'password' => 'required|string',

        ]);

        $player = new Player([
            'username'  => $request->username,
            'password' => bcrypt($request->password),
        ]);
        if ($player->save()) {
            // TODO
            $token = Auth::getToken($player->id);
            $player->update(['active_title_id' => 1]);


            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201)->withCookie($this->getCookie($token));
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

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (Auth::user()) {
            $player = Auth::user();

            return response()->json([
                'token' => $token,
                // new PlayerResource($player)
            ])->withCookie($this->getCookie($token), 200);
        } else {
            return response("Title granted", 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'player' => Auth::user(),
        ])->withCookie($this->getCookie(Auth::refresh()));
    }

    // Create the cookie for authorisation
    private function getCookie($token)
    {
        return cookie(
            'NocturnaCookie',
            $token,
            600,
            null,
            null,
            env('APP_DEBUG') ? false : true,
            true,
            false,
            app()->environment('production') ? 'Strict' : 'Lax'
        );
    }
}
