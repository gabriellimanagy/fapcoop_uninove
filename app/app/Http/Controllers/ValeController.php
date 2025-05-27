<?php

namespace App\Http\Controllers;

use App\Models\Vale;
use App\Models\Cooperado;
use Illuminate\Http\Request;

class ValeController extends Controller
{
    public function index()
    {
        $vales = Vale::with('cooperado')->get();
        return view('vales.index', compact('vales'));
    }

    public function create()
    {
        $cooperados = Cooperado::all();
        return view('vales.create', compact('cooperados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cooperado_id' => 'required|exists:cooperados,id',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'required|string|max:255',
            'data_solicitacao' => 'required|date',
            'data_desconto' => 'required|date|after_or_equal:data_solicitacao',
            'status' => 'required|in:pendente,aprovado,negado'
        ]);

        Vale::create($request->all());

        return redirect()->route('vales.index')->with('success', 'Vale cadastrado com sucesso!');
    }

    public function edit(Vale $vale)
    {
        $cooperados = Cooperado::all();
        return view('vales.edit', compact('vale', 'cooperados'));
    }

    public function update(Request $request, Vale $vale)
    {
        $request->validate([
            'cooperado_id' => 'required|exists:cooperados,id',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'required|string|max:255',
            'data_solicitacao' => 'required|date',
            'data_desconto' => 'required|date|after_or_equal:data_solicitacao',
            'status' => 'required|in:pendente,aprovado,negado'
        ]);

        $vale->update($request->all());

        return redirect()->route('vales.index')->with('success', 'Vale atualizado com sucesso!');
    }

    public function destroy(Vale $vale)
    {
        $vale->delete();
        return redirect()->route('vales.index')->with('success', 'Vale excluído com sucesso!');
    }
}
