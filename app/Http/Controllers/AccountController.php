<?php

/**
 * This file contains the Account Controller. It is responsible for manipulating Account objects,
 * interacting with the Accounts database table, and handling incoming requests routed to specific
 * functions.
 * 
 * @author 0xChristopher
 */

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Account constructor for authorization middleware
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new account
     * 
     * @param Request $request
     * @return Response
     */
    public function postAccount(Request $request)
    {
        // Validate incoming request
        $this->validate($request, [
            'account_name' => 'required|string',
            'user_id' => 'required'
        ]);

        // Attempt to create account
        $account = Account::create($request->all());

        // Return success response
        return response()->json($account, 201);
    }

    /**
     * Update an existing account
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function updateAccount(Request $request, $id)
    {
        // Validate incoming request
        $this->validate($request, [
            'account_name' => 'required|string',
            'user_id' => 'required'
        ]);

        // Attempt to retrieve account
        $account = Account::findOrFail($id);
        $account->update($request->all());

        // Return success response
        return response()->json($account, 200);
    }

    /**
     * Get all existing accounts
     * 
     * @return Response
     */
    public function getAccounts()
    {
        // Return success response
        return response()->json(Account::all(), 200);
    }

    /**
     * Get all existing accounts on a given page
     * 
     * @param $page
     * @param $limit
     * @return Response
     */
    public function getAccountsByPage($page = 1, $limit = 100)
    {
        // Attempt to get page of accounts
        $accounts = Account::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        // Return success response
        return response()->json([
            'accounts' => $accounts->items(),
            'total' => $accounts->total(),
            'perPage' => $accounts->perPage(),
            'currentPage' => $accounts->currentPage(),
            'lastPage' => $accounts->lastPage()
        ], 200);
    }

    /**
     * Get account by id
     * 
     * @param $id
     * @return Response
     */
    public function getAccountById($id)
    {
        // Find account by id
        $account = DB::table('accounts')->where('id', $id)->first();

        // Check that a account was found and that the object isn't empty
        if (!$account)
            return response()->json(['error' => 'Account not found'], 404);
        elseif (empty((array) $account))
            return response()->json(['error' => 'Account data is empty'], 404);

        // Find user by id
        $user = DB::table('users')->where('id', $account->user_id)->first();

        // Check that a user was found and that the object isn't empty
        if (!$user)
            return response()->json(['error' => 'User not found'], 404);
        elseif (empty((array) $user))
            return response()->json(['error' => 'User data is empty'], 404);

        // Account found, return response with account data
        return response()->json([
            'accounts' => $account,
            'users' => $user
        ], 200);
    }

    /**
     * Get most recent accounts for quick look
     * 
     * @return Response
     */
    public function getAccountsQuickLook()
    {
        // Attempt to get 10 most recent accounts
        $accounts = Account::orderby('id', 'desc')->take(10)->get();

        // Return success response
        return response()->json($accounts, 200);
    }

    /**
     * Delete an existing account by id
     * 
     * @param $id
     * @return Response
     */
    public function deleteAccount($id)
    {
        // Attempt to delete account
        Account::findOrFail($id)->delete();

        // Return success response
        return response('Account deleted', 200);
    }
}