<?php

/**
 * This file contains the Action Bar Controller. It is responsible for manipulating Action Bar objects,
 * interacting with the various Action Bar database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionBarController extends Controller
{
    /**
     * ActionBar constructor for authorization middleware
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create an action bar
     * 
     * @param Request $request
     * @param $tableName
     * @return Response
     */
    public function postActionBar(Request $request, $tableName)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'action_bar_data' => 'required'
        ]);

        // Dynamically get the action bar class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'ActionBar';

        // If the class exists attempt to create the requested action bar
        if (class_exists($modelClass)) 
        {
            // Attempt to create the new action bar
            $actionBar = new $modelClass();
            $data = $request->json()->all();
            $actionBar->fill($data);
            $actionBar->save();

            // Return success response
            return response()->json($actionBar, 201);
        }

        // Return if action bar could not be created
        return response()->json(['error' => 'Could not create Action Bar'], 400);
    }

    /**
     * Update an action bar
     * 
     * @param Request $request
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function updateActionBar(Request $request, $tableName, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'action_bar_data' => 'required'
        ]);

        // Dynamically get the action bar class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'ActionBar';

        // If the class exists attempt to find the requested action bar
        if (class_exists($modelClass))
        {
            // Attempt to update the action bar
            $model = new $modelClass();
            $actionBar = $model->findOrFail($id);
            $actionBar->update($request->all());

            // Return success response
            return response()->json($actionBar, 200);
        }

        // Return if action bar could not be found
        return response()->json(['error' => 'Action Bar not found'], 404);
    }

    /**
     * Get action bar by name
     * 
     * @param Request $request
     * @param $tableName
     * @param $barRequest
     * @return Response
     */
    public function getActionBarByName(Request $request, $tableName, $barRequest)
    {
        // Dynamically get the action bar class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'ActionBar';

        // If the class exists attempt to find the requested action bar
        if (class_exists($modelClass)) 
        {
            // Attempt to retrieve action bar
            $model = new $modelClass();
            $actionBar = $model->where('name', $barRequest)->first();

            // If an action bar was found, return it; otherwise return not found
            if ($actionBar)
                return response()->json($actionBar);
            elseif (empty((array) $actionBar))
                return response()->json(['error' => 'Action Bar not found'], 404);
        }

        // Return if action bar could not be found
        return response()->json(['error' => 'Action Bar not found'], 404);
    }

    /**
     * Delete an existing action bar by id
     * 
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function deleteActionBar($tableName, $id)
    {
        // Dynamically get the action bar class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'ActionBar';

        // If the class exists attempt to find the requested action bar
        if (class_exists($modelClass)) 
        {
            // Attempt to delete the action bar
            $model = new $modelClass();
            $model->findOrFail($id)->delete();

            // Return success response
            return response('Action Bar deleted', 200);
        }

        // Return if action could not be found
        return response()->json(['error' => 'Action Bar not found'], 404);
    }
}