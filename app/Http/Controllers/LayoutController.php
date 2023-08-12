<?php

/**
 * This file contains the Layout Controller. It is responsible for manipulating Layout objects,
 * interacting with the various Layout database tables, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    /**
     * Layout constructor for authorization middleware
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a layout
     * 
     * @param Request $request
     * @param $layoutName
     * @return Response
     */
    public function postLayout(Request $request, $layoutName)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'layout_data' => 'required'
        ]);

        // Dynamically get the layout class
        $modelClass = 'App\\Models\\' . ucfirst($layoutName) . 'Layout';

        // If the class exists attempt to create the requested layout
        if (class_exists($modelClass)) 
        {
            // Attempt to create the new layout
            $layout = new $modelClass();
            $data = $request->json()->all();
            $layout->fill($data);
            $layout->save();

            // Return success response
            return response()->json($layout, 201);
        }

        // Return if the layout could not be created
        return response()->json(['error' => 'Could not create Layout'], 400);
    }

    /**
     * Update a layout
     * 
     * @param Request $request
     * @param $layoutName
     * @param $id
     * @return Response
     */
    public function updateLayout(Request $request, $layoutName, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'layout_data' => 'required'
        ]);

        // Dynamically get the layout class
        $modelClass = 'App\\Models\\' . ucfirst($layoutName) . 'Layout';

        // If the class exists attempt to find the requested layout
        if (class_exists($modelClass))
        {
            // Attempt to update the layout
            $model = new $modelClass();
            $layout = $model->findOrFail($id);
            $layout->update($request->all());

            // Return success response
            return response()->json($layout, 200);
        }

        // Return if layout could not be found
        return response()->json(['error' => 'Layout not found'], 404);
    }

    /**
     * Get layout by name
     * 
     * @param Request $request
     * @param $layoutName
     * @param $viewRequest
     * @return Response
     */
    public function getLayoutByName(Request $request, $layoutName, $viewRequest)
    {
        // Dynamically get the layout class
        $modelClass = 'App\\Models\\' . ucfirst($layoutName) . 'Layout';

        // If the class exists attempt to find the requested view
        if (class_exists($modelClass)) 
        {
            // Attempt to retrieve the layout
            $model = new $modelClass();
            $layout = $model->where('name', $viewRequest)->first();

            // If a view was found, return it; otherwise return not found
            if ($layout)
                return response()->json($layout);
            elseif (empty((array) $layout))
                return response()->json(['error' => 'Layout not found'], 404);
        }

        // Return if the layout could not be found
        return response()->json(['error' => 'Layout not found'], 404);
    }

    /**
     * Delete an existing layout by id
     * 
     * @param $layoutName
     * @param $id
     * @return Response
     */
    public function deleteLayout($layoutName, $id)
    {
        // Dynamically get the layout class
        $modelClass = 'App\\Models\\' . ucfirst($layoutName) . 'Layout';

        // If the class exists attempt to find the requested layout
        if (class_exists($modelClass)) 
        {
            // Attempt to delete the layout
            $model = new $modelClass();
            $model->findOrFail($id)->delete();

            // Return success response
            return response('Layout deleted', 200);
        }

        // Return if layout could not be found
        return response()->json(['error' => 'Layout not found'], 404);
    }
}