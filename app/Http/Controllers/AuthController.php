<?php

/**
 * This file contains the Authentication Controller. It is responsible for handling incoming requests 
 * routed to specific functions (such as login and logout), authenticating incoming requests to ensure
 * they are legal by validating user credentials and/or JWT access tokens, as well as managing those
 * access tokens.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use DateTime;

class AuthController extends Controller
{
    /**
     * Auth constructor for authorization middleware
     * 
     * @return void
     */
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
            'full_name' => 'required|string|between:4,100',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6'
        ]);

        try
        {
            // Attempt to register new user
            $user = new User;
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            // Return success response
            return response()->json([
                'user' => $user, 
                'message' => 'CREATED'
            ], 201);
        }
        catch (\Exception $e)
        {
            // Return registration error
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

        // Pull credentials from request
        $credentials = $request->only(['email', 'password']);

        // Check for failed login
        if (!$token = auth()->attempt($credentials))
        {
            // Return invalid credentials error
            return response()->json([
                'message' => 'Invalid email address or password'
            ], 401);
        }

        // Get current logged in user
        $user = Auth::user();

        // Set session data
        $sessionData = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
            'user_id' => $user->id
        ];

        // Set user session
        $request->session()->regenerateToken();
        $request->session()->put('user', $sessionData);

        // Return JWT response
        return $this->respondWithToken($request, $token);
    }

    /**
     * Logout the user and invalidate JWT
     * 
     * @param Request $request
     * @return \Illuminate\Https\JsonResponse
     */
    public function logout(Request $request)
    {
        // Logout the current user
        auth()->logout();

        // Invalidate the user's current session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return success response
        return response()->json([
            'message' => 'User successfully logged out'
        ], 200);
    }

    /**
     * Refresh the current token
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken($request, auth()->refresh());
    }

    /**
     * Helper function to format the response with the JWT to be sent in an HttpOnly cookie
     * 
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken($request, $token)
    {
        $cookie = new Cookie(
            'token',                                                // Cookie name
            $token,                                                 // Cookie content
            (new DateTime('now'))->modify('+1 day'),                // Expiration date
            '/',                                                    // Path
            'localhost',                                            // Domain
            $request->getScheme() === 'https',                      // Secure
            true,                                                   // HttpOnly
            true,                                                   // Raw
            'Strict'                                                // SameSite Policy
        );

        // Return token response as a cookie
        return response()->json([
            'token' => 'jwt access token',
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60          // Set token time to live
        ], 200)->withCookie($cookie);
    }
}