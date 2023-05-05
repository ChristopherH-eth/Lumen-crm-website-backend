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
     * @param $request
     * @return $response
     */
    public function postUser(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required|alpha',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Update an existing user
     * 
     * @param $id
     * @return $response
     */
    public function updateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    /**
     * Get all existing users
     * 
     * @return $response
     */
    public function getUsers()
    {
        return response()->json(User::all());
    }

    /**
     * Get user by id
     * 
     * @param $id
     * @return $response
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
     * @return $response
     */
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();

        return response('User deleted', 200);
    }

    /**
     * Get user session
     * 
     * @param $request
     * @return $response
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