<?php

/**
 * This file contains the Layout Controller. It is responsible for manipulating Layout objects,
 * interacting with the various Layout database tables, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\Layout;
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
     * @return Response
     */
    public function postLayout(Request $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'layout_data' => 'required'
        ]);

        // Attempt to create layout
        $layout = Layout::create($request->all());

        // Return success response
        return response()->json($layout, 201);
    }

    /**
     * Update a layout
     * 
     * @param Request $request
     * @param $layoutName
     * @return Response
     */
    public function updateLayout(Request $request, $layoutName)
    {
        // Validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'layout_data' => 'required'
        ]);

        // Attempt to retrieve layout
        $layout = Layout::findOrFail($layoutName);
        $layout->update($request->all());

        // Return success response
        return response()->json($layout, 200);
    }

    /**
     * Get layout by name
     * 
     * @param Request $request
     * @param $layoutName
     * @return Response
     */
    public function getLayoutByName(Request $request, $layoutName)
    {
        // Find layout by id
        $layout = DB::table('layouts')->where('name', $layoutName)->first();

        // Check that a layout was found and that the object isn't empty
        if (!$layout)
            return response()->json(['error' => 'Layout not found'], 404);
        elseif (empty((array) $layout))
            return response()->json(['error' => 'Layout data is empty'], 404);

        // Layout found, return response with layout data
        return response()->json($layout, 200);
    }

    /**
     * Delete an existing layout by id
     * 
     * @param $layoutName
     * @return Response
     */
    public function deleteLayout($layoutName)
    {
        // Attempt to delete layout
        Layout::findOrFail($layoutName)->delete();

        // Return success response
        return response('Layout deleted', 200);
    }
}