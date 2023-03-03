<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }

    /**
     * Attempt to register a new user
     * 
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        // Validate user input
        $this->validate($request, [
            'first_name' => 'required|string|between:2,50',
            'last_name' => 'required|string|between:2,50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6'
        ]);

        try
        {
            $user = new User;
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            return response()->json([
                'user' => $user, 
                'message' => 'CREATED'
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => 'User registration failed',
                'error' => $e
            ], 409);
        }
    }

    /**
     * Attempt to login a user
     * 
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        // Validate user credentials
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only(['email', 'password']);

        // Check for failed login
        if (!$token = Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'Invalid email address or password'
            ], 401);
        }

        // Add token to user session
        $request->session()->put('jwt', $this->respondWithToken($token)->original);

        return $request->session()->all();
    }

    /**
     * Logout the user and invalidate JWT
     * 
     * @return \Illuminate\Https\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'message' => 'User successfully logged out'
        ]);
    }

    /**
     * Refresh the current token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->responseWithToken(auth()->refresh());
    }

    /**
     * Helper function to format the response with the JWT
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}