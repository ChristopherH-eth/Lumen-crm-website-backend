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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new opportunity
     * 
     * @param $request
     * @return $response
     */
    public function postOpportunity(Request $request)
    {
        $this->validate($request, [
            'opportunity_name' => 'required|alpha',
            'follow_up' => 'required',
            'close_date' => 'required',
            'stage' => 'required',
            'user_id' => 'required',
            'account_id' => 'required'
        ]);

        $opportunity = Opportunity::create($request->all());

        return response()->json($opportunity, 201);
    }

    /**
     * Update an existing opportunity
     * 
     * @param $id
     * @return $response
     */
    public function updateOpportunity($id)
    {
        $opportunity = Opportunity::findOrFail($id);
        $opportunity->update($request->all());

        return response()->json($opportunity, 200);
    }

    /**
     * Get all existing opportunities
     * 
     * @return $response
     */
    public function getOpportunities()
    {
        return response()->json(Opportunity::all());
    }

    /**
     * Get all existing opportunities on a given page
     * 
     * @param $page
     * @param $limit
     * @return $response
     */
    public function getOpportunitiesByPage($page = 1, $limit = 100)
    {
        $opportunities = Opportunity::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'opportunities' => $opportunities->items(),
            'total' => $opportunities->total(),
            'perPage' => $opportunities->perPage(),
            'currentPage' => $opportunities->currentPage(),
            'lastPage' => $opportunities->lastPage()
        ]);
    }

    /**
     * Get opportunity by id
     * 
     * @param $id
     * @return $response
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
     * @return $response
     */
    public function getOpportunitiesQuickLook()
    {
        $opportunities = Opportunity::orderby('id', 'desc')->take(10)->get();

        return response()->json($opportunities);
    }

    /**
     * Delete an existing opportunity by id
     * 
     * @param $id
     * @return $response
     */
    public function deleteOpportunity($id)
    {
        Opportunity::findOrFail($id)->delete();

        return response('Opportunity deleted', 200);
    }
}