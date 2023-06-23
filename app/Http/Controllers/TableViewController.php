<?php

/**
 * This file contains the Table View Controller. It is responsible for manipulating Table View objects,
 * interacting with the various Table View database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a table view
     * 
     * @param Request $request
     * @param $tableName
     * @return Response
     */
    public function postTableView(Request $request, $tableName)
    {
        $this->validate($request, [
            'name' => 'required',
            'view_data' => 'required'
        ]);

        // Dynamically get the table view class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'TableView';

        // If the class exists attempt to create the requested table view
        if (class_exists($modelClass)) 
        {
            $tableView = new $modelClass();
            $data = $request->json()->all();
            $tableView->fill($data);
            $tableView->save();

            return response()->json($tableView, 201);
        }

        return response()->json(['error' => 'Could not create Table View'], 400);
    }

    /**
     * Get table view by name
     * 
     * @param Request $request
     * @param $tableName
     * @param $viewRequest
     * @return Response
     */
    public function getTableViewByName(Request $request, $tableName, $viewRequest)
    {
        // Dynamically get the table view class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'TableView';

        // If the class exists attempt to find the requested view
        if (class_exists($modelClass)) 
        {
            $model = new $modelClass();
            $tableView = $model->where('name', $viewRequest)->first();

            // If a view was found, return it; otherwise return not found
            if ($tableView)
                return response()->json($tableView);
            elseif (empty((array) $tableView))
                return response()->json(['error' => 'Table view not found'], 404);
        }

        return response()->json(['error' => 'Table view not found'], 404);
    }
}