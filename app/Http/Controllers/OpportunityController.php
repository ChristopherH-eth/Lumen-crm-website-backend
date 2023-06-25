<?php

/**
 * This file contains the Opportunity Controller. It is responsible for manipulating Opportunity objects,
 * interacting with the Opportunities database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    /**
     * Opportunity constructor for authorization middleware
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new opportunity
     * 
     * @param Request $request
     * @return Response
     */
    public function postOpportunity(Request $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'opportunity_name' => 'required|string',
            'follow_up' => 'required',
            'close_date' => 'required',
            'stage' => 'required',
            'user_id' => 'required',
            'account_id' => 'required'
        ]);

        // Attempt to create Opportunity
        $opportunity = Opportunity::create($request->all());

        // Return success response
        return response()->json($opportunity, 201);
    }

    /**
     * Update an existing opportunity
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateOpportunity(Request $request, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'opportunity_name' => 'required|string',
            'follow_up' => 'required',
            'close_date' => 'required',
            'stage' => 'required',
            'user_id' => 'required',
            'account_id' => 'required'
        ]);

        // Attempt to update opportunity
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->update($request->all());

        // Return success response
        return response()->json($opportunity, 200);
    }

    /**
     * Get all existing opportunities
     * 
     * @return Response
     */
    public function getOpportunities()
    {
        // Return success response
        return response()->json(Opportunity::all(), 200);
    }

    /**
     * Get all existing opportunities on a given page
     * 
     * @param $page
     * @param $limit
     * @return Response
     */
    public function getOpportunitiesByPage($page = 1, $limit = 100)
    {
        // Attempt to get page of opportunities
        $opportunities = Opportunity::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        // Return success response
        return response()->json([
            'opportunities' => $opportunities->items(),
            'total' => $opportunities->total(),
            'perPage' => $opportunities->perPage(),
            'currentPage' => $opportunities->currentPage(),
            'lastPage' => $opportunities->lastPage()
        ], 200);
    }

    /**
     * Get opportunity by id
     * 
     * @param $id
     * @return Response
     */
    public function getOpportunityById($id)
    {
        // Find opportunity by id
        $opportunity = DB::table('opportunities')->where('id', $id)->first();

        // Check that a opportunity was found and that the object isn't empty
        if (!$opportunity)
            return response()->json(['error' => 'Opportunity not found'], 404);
        elseif (empty((array) $opportunity))
            return response()->json(['error' => 'Opportunity data is empty'], 404);

        // Find user by id
        $user = DB::table('users')->where('id', $opportunity->user_id)->first();

        // Check that a user was found and that the object isn't empty
        if (!$user)
            return response()->json(['error' => 'User not found'], 404);
        elseif (empty((array) $user))
            return response()->json(['error' => 'User data is empty'], 404);

        // Opportunity found, return response with opportunity data
        return response()->json([
            'opportunity' => $opportunity,
            'user' => $user
        ], 200);
    }

    /**
     * Get most recent opportunities for quick look
     * 
     * @return Response
     */
    public function getOpportunitiesQuickLook()
    {
        // Attempt to get 10 most recent opportunities
        $opportunities = Opportunity::orderby('id', 'desc')->take(10)->get();

        // Return success response
        return response()->json($opportunities, 200);
    }

    /**
     * Delete an existing opportunity by id
     * 
     * @param $id
     * @return Response
     */
    public function deleteOpportunity($id)
    {
        // Attempt to delete opportunity
        Opportunity::findOrFail($id)->delete();

        // Return success response
        return response('Opportunity deleted', 200);
    }
}