<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            'email' => 'required',
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
        return response()->json(User::find($id));
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