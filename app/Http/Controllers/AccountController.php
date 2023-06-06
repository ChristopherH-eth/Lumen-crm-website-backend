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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new account
     * 
     * @param $request
     * @return $response
     */
    public function postAccount(Request $request)
    {
        $this->validate($request, [
            'account_name' => 'required',
            'user_id' => 'required'
        ]);

        $account = Account::create($request->all());

        return response()->json($account, 201);
    }

    /**
     * Update an existing account
     * 
     * @param $id
     * @return $response
     */
    public function updateAccount($id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->all());

        return response()->json($account, 200);
    }

    /**
     * Get all existing accounts
     * 
     * @return $response
     */
    public function getAccounts()
    {
        return response()->json(Account::all());
    }

    /**
     * Get all existing accounts on a given page
     * 
     * @param $page
     * @param $limit
     * @return $response
     */
    public function getAccountsByPage($page = 1, $limit = 100)
    {
        $accounts = Account::with('user')
            ->orderByDesc('id')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'accounts' => $accounts->items(),
            'total' => $accounts->total(),
            'perPage' => $accounts->perPage(),
            'currentPage' => $accounts->currentPage(),
            'lastPage' => $accounts->lastPage()
        ]);
    }

    /**
     * Get account by id
     * 
     * @param $id
     * @return $response
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
            'account' => $account,
            'user' => $user
        ], 200);
    }

    /**
     * Get most recent accounts for quick look
     * 
     * @return $response
     */
    public function getAccountsQuickLook()
    {
        $accounts = Account::orderby('id', 'desc')->take(10)->get();

        return response()->json($accounts);
    }

    /**
     * Delete an existing account by id
     * 
     * @param $id
     * @return $response
     */
    public function deleteAccount($id)
    {
        Account::findOrFail($id)->delete();

        return response('Account deleted', 200);
    }
}