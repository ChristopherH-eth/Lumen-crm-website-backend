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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get action bar by name
     * 
     * @param Request $request
     * @param $actionBarName
     * @param $actionBarRequest
     * @return Response
     */
    public function getActionBar(Request $request, $actionBarName, $actionBarRequest)
    {
        // Dynamically get the action bar class
        $modelClass = 'App\\Models\\' . ucfirst($actionBarName) . 'ActionBar';

        // If the class exists attempt to find the requested action bar
        if (class_exists($modelClass)) {
            $model = new $modelClass();
            $actionBar = $model->where('name', $actionBarRequest)->first();

            // If an action bar was found, return it; otherwise return not found
            if ($actionBar)
                return response()->json($actionBar);
            elseif (empty((array) $actionBar))
                return response()->json(['error' => 'Action Bar not found'], 404);
        }

        return response()->json(['error' => 'Action Bar not found'], 404);
    }
}