<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function postCryptos(Request $request)
    {
        $cryptocurrency = Cryptocurrency::create($request->all());

        return response()->json($cryptocurrency, 201);
    }

    public function getCryptos()
    {
        return response()->json(Cryptocurrency::all());
    }

    public function getCryptoCount()
    {
        return response()->json(Cryptocurrency::all());
    }

    public function getCryptosByPage(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');

        return response()->json(Cryptocurrency::all());
    }

    public function getCryptoById($id)
    {
        return response()->json(Cryptocurrency::find($id));
    }
}