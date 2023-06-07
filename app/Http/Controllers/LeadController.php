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
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required',
            'company' => 'required',
            'lead_status' => 'required',
            'email_opt_out' => 'required',
            'user_id' => 'required'
        ]);

        $lead = Lead::create($request->all());

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
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());

        return response()->json($lead, 200);
    }

    /**
     * Get all existing leads
     * 
     * @return Response
     */
    public function getLeads()
    {
        return response()->json(Lead::all());
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
        $leads = Lead::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'leads' => $leads->items(),
            'total' => $leads->total(),
            'perPage' => $leads->perPage(),
            'currentPage' => $leads->currentPage(),
            'lastPage' => $leads->lastPage()
        ]);
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
            'lead' => $lead,
            'user' => $user
        ], 200);
    }

    /**
     * Get most recent leads for quick look
     * 
     * @return Response
     */
    public function getLeadsQuickLook()
    {
        $leads = Lead::orderby('id', 'desc')->take(10)->get();

        return response()->json($leads);
    }

    /**
     * Delete an existing lead by id
     * 
     * @param $id
     * @return Response
     */
    public function deleteLead($id)
    {
        Lead::findOrFail($id)->delete();

        return response('Lead deleted', 200);
    }
}