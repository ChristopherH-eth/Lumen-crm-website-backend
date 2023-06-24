<?php

/**
 * This file contains the User Controller. It is responsible for manipulating User objects,
 * interacting with the Users database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new user
     * 
     * @param Request $request
     * @return Response
     */
    public function postUser(Request $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Update an existing user
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateUser(Request $request, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Get all existing users
     * 
     * @return Response
     */
    public function getUsers()
    {
        return response()->json(User::all());
    }

    /**
     * Get user by id
     * 
     * @param $id
     * @return Response
     */
    public function getUserById($id)
    {
        // Find user by id
        $user = DB::table('users')->where('id', $id)->first();

        // Check that a user was found and that the object isn't empty
        if (!$user)
            return response()->json(['error' => 'User not found'], 404);
        elseif (empty((array) $user))
            return response()->json(['error' => 'User data is empty'], 404);

        // User found, return response with user data
        return response()->json(['user' => $user], 200);
    }

    /**
     * Delete an existing user by id
     * 
     * @param $id
     * @return Response
     */
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return response('User deleted', 200);
    }

    /**
     * Get user session
     * 
     * @param Request $request
     * @return Response
     */
    public function getSession(Request $request)
    {
        // $request->session()->put('name', 'Lumen-Session');

        // return response()->json([
        //     'session.name' => $request->session()->get('name')
        // ]);

        return response()->json([
            $request->session()->all()
        ]);
    }
}