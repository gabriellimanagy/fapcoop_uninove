<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    public function create()
    {
        return view('funcoes.create');
    }
}
