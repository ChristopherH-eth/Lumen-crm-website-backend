<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new lead
     * 
     * @param $request
     * @return $response
     */
    public function postLead(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'company' => 'required',
            'lead_status' => 'required'
        ]);

        $lead = Lead::create($request->all());

        return response()->json($lead, 201);
    }

    /**
     * Update an existing lead
     * 
     * @param $id
     * @return $response
     */
    public function updateLead($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());

        return response()->json($lead, 200);
    }

    /**
     * Get all existing leads
     * 
     * @return $response
     */
    public function getLeads()
    {
        $leads = Lead::orderby('id', 'desc')->get();

        return response()->json($leads);
    }

    /**
     * Get lead by id
     * 
     * @param $id
     * @return $response
     */
    public function getLeadById($id)
    {
        return response()->json(Lead::find($id));
    }

    /**
     * Get most recent leads for quick look
     * 
     * @return $response
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
     * @return $response
     */
    public function deleteLead($id)
    {
        Lead::findOrFail($id)->delete();

        return response('Lead deleted', 200);
    }
}