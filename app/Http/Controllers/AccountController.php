<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

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
            'account_name' => 'required'
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
        $accounts = Account::orderby('id', 'desc')->get();

        return response()->json($accounts);
    }

    /**
     * Get account by id
     * 
     * @param $id
     * @return $response
     */
    public function getAccountById($id)
    {
        return response()->json(Account::find($id));
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