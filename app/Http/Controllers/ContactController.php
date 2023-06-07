<?php

/**
 * This file contains the Contact Controller. It is responsible for manipulating Contact objects,
 * interacting with the Contacts database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new contact
     * 
     * @param Request $request
     * @return Response
     */
    public function postContact(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'full_name' => 'required',
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
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateContact(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return response()->json($contact, 200);
    }

    /**
     * Get all existing contacts
     * 
     * @return Response
     */
    public function getContacts()
    {
        return response()->json(Contact::all());
    }

    /**
     * Get all existing contacts on a given page
     * 
     * @param $page
     * @param $limit
     * @return Response
     */
    public function getContactsByPage($page = 1, $limit = 100)
    {
        $contacts = Contact::with('user', 'account')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'contacts' => $contacts->items(),
            'total' => $contacts->total(),
            'perPage' => $contacts->perPage(),
            'currentPage' => $contacts->currentPage(),
            'lastPage' => $contacts->lastPage()
        ]);
    }

    /**
     * Get contact by id
     * 
     * @param $id
     * @return Response
     */
    public function getContactById($id)
    {
        // Find contact by id
        $contact = DB::table('contacts')->where('id', $id)->first();

        // Check that a contact was found and that the object isn't empty
        if (!$contact)
            return response()->json(['error' => 'Contact not found'], 404);
        elseif (empty((array) $contact))
            return response()->json(['error' => 'Contact data is empty'], 404);

        $user = DB::table('users')->where('id', $contact->user_id)->first();

        // Check that a user was found and that the object isn't empty
        if (!$user)
            return response()->json(['error' => 'User not found'], 404);
        elseif (empty((array) $user))
            return response()->json(['error' => 'User data is empty'], 404);

        $account = DB::table('accounts')->where('id', $contact->account_id)->first();

        // Check that a account was found and that the object isn't empty
        if (!$account)
            return response()->json(['error' => 'Account not found'], 404);
        elseif (empty((array) $account))
            return response()->json(['error' => 'Account data is empty'], 404);

        // Contact found, return response with contact data
        return response()->json([
            'contact' => $contact,
            'user' => $user,
            'account' => $account
        ], 200);
    }

    /**
     * Get most recent contacts for quick look
     * 
     * @return Response
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
     * @return Response
     */
    public function deleteContact($id)
    {
        Contact::findOrFail($id)->delete();

        return response('Contact deleted', 200);
    }
}