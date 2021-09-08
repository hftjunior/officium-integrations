<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTFactory;
use App\User;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['login', 'password']);
        $user = User::where([
            'login' => $request->login,
            'pswd' => md5($request->password)
        ])->first();

        if(!$user){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$token = auth('api')->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $responseToken = $this->respondWithToken($token);
        $response = array();
        $response['user'] = $user;
        $response['token'] = $responseToken->original['access_token'];
        return response()->json($response);
        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
