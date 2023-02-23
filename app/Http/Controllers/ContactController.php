<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Create a new contact
     * 
     * @param $request
     * @return $response
     */
    public function postContact(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'account_name' => 'required'
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
        return response()->json(Contact::all());
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