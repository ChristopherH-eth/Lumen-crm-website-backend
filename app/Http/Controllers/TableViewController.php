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
    /**
     * TableView constructor for authorization middleware
     * 
     * @return void
     */
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
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'view_data' => 'required'
        ]);

        // Dynamically get the table view class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'TableView';

        // If the class exists attempt to create the requested table view
        if (class_exists($modelClass)) 
        {
            // Attempt to create the new table view
            $tableView = new $modelClass();
            $data = $request->json()->all();
            $tableView->fill($data);
            $tableView->save();

            // Return success response
            return response()->json($tableView, 201);
        }

        // Return if the table view could not be created
        return response()->json(['error' => 'Could not create Table View'], 400);
    }

    /**
     * Update a table view
     * 
     * @param Request $request
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function updateTableView(Request $request, $tableName, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'view_data' => 'required'
        ]);

        // Dynamically get the table view class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'TableView';

        // If the class exists attempt to find the requested table view
        if (class_exists($modelClass))
        {
            // Attempt to update the table view
            $model = new $modelClass();
            $tableView = $model->findOrFail($id);
            $tableView->update($request->all());

            // Return success response
            return response()->json($tableView, 200);
        }

        // Return if table view could not be found
        return response()->json(['error' => 'Table View not found'], 404);
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
            // Attempt to retrieve the table view
            $model = new $modelClass();
            $tableView = $model->where('name', $viewRequest)->first();

            // If a view was found, return it; otherwise return not found
            if ($tableView)
                return response()->json($tableView);
            elseif (empty((array) $tableView))
                return response()->json(['error' => 'Table view not found'], 404);
        }

        // Return if the table view could not be found
        return response()->json(['error' => 'Table view not found'], 404);
    }

    /**
     * Delete an existing table view by id
     * 
     * @param $tableName
     * @param $id
     * @return Response
     */
    public function deleteTableView($tableName, $id)
    {
        // Dynamically get the table view class
        $modelClass = 'App\\Models\\' . ucfirst($tableName) . 'TableView';

        // If the class exists attempt to find the requested table view
        if (class_exists($modelClass)) 
        {
            // Attempt to delete the table view
            $model = new $modelClass();
            $model->findOrFail($id)->delete();

            // Return success response
            return response('Table View deleted', 200);
        }

        // Return if table view could not be found
        return response()->json(['error' => 'Table View not found'], 404);
    }
}