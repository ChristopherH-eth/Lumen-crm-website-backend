<?php

/**
 * This file contains the Lead Controller. It is responsible for manipulating Lead objects,
 * interacting with the Leads database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Lead constructor for authorization middleware
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new lead
     * 
     * @param Request $request
     * @return Response
     */
    public function postLead(Request $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required|string',
            'company' => 'required',
            'lead_status' => 'required',
            'email_opt_out' => 'required',
            'user_id' => 'required'
        ]);

        // Attempt to create lead
        $lead = Lead::create($request->all());

        // Return success response
        return response()->json($lead, 201);
    }

    /**
     * Update an existing lead
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateLead(Request $request, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required|string',
            'company' => 'required',
            'lead_status' => 'required',
            'email_opt_out' => 'required',
            'user_id' => 'required'
        ]);

        // Attempt to update lead
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());

        // Return success response
        return response()->json($lead, 200);
    }

    /**
     * Get all existing leads
     * 
     * @return Response
     */
    public function getLeads()
    {
        // Return success response
        return response()->json(Lead::all(), 200);
    }

    /**
     * Get all existing leads on a given page
     * 
     * @param $page
     * @param $limit
     * @return Response
     */
    public function getLeadsByPage($page = 1, $limit = 100)
    {
        // Attempt to get page of leads
        $leads = Lead::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        // Return success response
        return response()->json([
            'leads' => $leads->items(),
            'total' => $leads->total(),
            'perPage' => $leads->perPage(),
            'currentPage' => $leads->currentPage(),
            'lastPage' => $leads->lastPage()
        ], 200);
    }

    /**
     * Get lead by id
     * 
     * @param $id
     * @return Response
     */
    public function getLeadById($id)
    {
        // Find lead by id
        $lead = DB::table('leads')->where('id', $id)->first();

        // Check that a lead was found and that the object isn't empty
        if (!$lead)
            return response()->json(['error' => 'Lead not found'], 404);
        elseif (empty((array) $lead))
            return response()->json(['error' => 'Lead data is empty'], 404);

        // Find user by id
        $user = DB::table('users')->where('id', $lead->user_id)->first();

        // Check that a user was found and that the object isn't empty
        if (!$user)
            return response()->json(['error' => 'User not found'], 404);
        elseif (empty((array) $user))
            return response()->json(['error' => 'User data is empty'], 404);

        // Lead found, return response with lead data
        return response()->json([
            'leads' => $lead,
            'users' => $user
        ], 200);
    }

    /**
     * Get most recent leads for quick look
     * 
     * @return Response
     */
    public function getLeadsQuickLook()
    {
        // Attempt to get 10 most recent leads
        $leads = Lead::orderby('id', 'desc')->take(10)->get();

        // Return success response
        return response()->json($leads, 200);
    }

    /**
     * Delete an existing lead by id
     * 
     * @param $id
     * @return Response
     */
    public function deleteLead($id)
    {
        // Attempt to delete lead
        Lead::findOrFail($id)->delete();

        // Return success response
        return response('Lead deleted', 200);
    }
}