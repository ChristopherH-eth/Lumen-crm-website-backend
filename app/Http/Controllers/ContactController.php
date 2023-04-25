<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new contact
     * 
     * @param $request
     * @return $response
     */
    public function postContact(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'account_id' => 'required',
            'email_opt_out' => 'required',
            'user_id' => 'required'
        ]);

        $contact = Contact::create($request->all());

        return response()->json($contact, 201);
    }

    /**
     * Update an existing contact
     * 
     * @param $id
     * @return $response
     */
    public function updateContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return response()->json($contact, 200);
    }

    /**
     * Get all existing contacts
     * 
     * @return $response
     */
    public function getContacts()
    {
        $contacts = Contact::orderby('id', 'desc')->get();

        return response()->json($contacts);
    }

    /**
     * Get contact by id
     * 
     * @param $id
     * @return $response
     */
    public function getContactById($id)
    {
        return response()->json(Contact::find($id));
    }

    /**
     * Get most recent contacts for quick look
     * 
     * @return $response
     */
    public function getContactsQuickLook()
    {
        $contacts = Contact::orderby('id', 'desc')->take(10)->get();

        return response()->json($contacts);
    }

    /**
     * Delete an existing contact by id
     * 
     * @param $id
     * @return $response
     */
    public function deleteContact($id)
    {
        Contact::findOrFail($id)->delete();

        return response('Contact deleted', 200);
    }
}