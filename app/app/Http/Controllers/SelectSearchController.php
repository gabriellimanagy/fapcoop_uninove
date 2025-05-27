<?php

namespace App\Http\Controllers;

use App\Models\Cooperado;
use Illuminate\Http\Request;

class SelectSearchController extends Controller
{
    public function searchCooperados(Request $request)
    {
        $search = $request->input('search');
        
        $cooperados = Cooperado::where('nome', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'nome']);

        return response()->json($cooperados);
    }
}