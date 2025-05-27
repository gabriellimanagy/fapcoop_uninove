<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Exibe a lista de clientes.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('razao_social', 'LIKE', "%{$search}%")
                ->orWhere('fantasia', 'LIKE', "%{$search}%")
                ->orWhere('documento', 'LIKE', "%{$search}%")
                ->orWhere('telefone1', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $clientes = $query->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function getFuncoes($id)
    {
        // Get functions related to this client through the pivot table
        $funcoes = \App\Models\Funcao::select('funcoes.*')
            ->join('cliente_funcao', 'funcoes.id', '=', 'cliente_funcao.funcao_id')
            ->where('cliente_funcao.cliente_id', $id)
            ->get();

        return response()->json($funcoes);
    }
    /**
     * Mostra o formulário para criar um novo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Armazena um novo cliente no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'razao_social'       => 'required|string|max:255',
            'fantasia'           => 'nullable|string|max:255',
            'documento'          => 'required|string|max:20|unique:clientes,documento',
            'identificacao'      => 'nullable|string|max:50',
            'endereco'           => 'required|string|max:255',
            'numero'             => 'nullable|string|max:10',
            'complemento'        => 'nullable|string|max:100',
            'bairro'             => 'required|string|max:100',
            'cidade'             => 'required|string|max:100',
            'estado'             => 'required|string|max:2',
            'cep'                => 'required|string|max:10',
            'telefone1'          => 'nullable|string|max:15',
            'telefone2'          => 'nullable|string|max:15',
            'email'              => 'required|email|max:255|unique:clientes,email',
            'pgto_ad_noturno'    => 'nullable|numeric|min:0|max:100',
            'inss'               => 'nullable|numeric|min:0|max:100',
            'aux_uniforme'       => 'nullable|numeric|min:0',
            'vale_transporte'    => 'nullable|numeric|min:0',
            'dt_cadastro'        => 'nullable|date',
            'exigir_antecedentes'=> 'nullable|boolean',
        ]);

        try {
            Cliente::create($request->all());
            return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage());
        }

    }

    public function getSetores($clienteId)
    {
        $setores = \App\Models\Setor::where('cliente_id', $clienteId)->get(['id', 'nome']);
        return response()->json($setores);
    }
    public function funcoes(Cliente $cliente)
    {
        return view('clientes.funcoes.index', compact('cliente'));
    }
    /**
     * Exibe os detalhes de um cliente.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostra o formulário para editar um cliente.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza os dados de um cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'razao_social'       => 'required|string|max:255',
            'fantasia'           => 'nullable|string|max:255',
            'documento'          => 'required|string|max:20|unique:clientes,documento,' . $cliente->id,
            'identificacao'      => 'nullable|string|max:50',
            'endereco'           => 'required|string|max:255',
            'numero'             => 'nullable|string|max:10',
            'complemento'        => 'nullable|string|max:100',
            'bairro'             => 'required|string|max:100',
            'cidade'             => 'required|string|max:100',
            'estado'             => 'required|string|max:2',
            'cep'                => 'required|string|max:10',
            'telefone1'          => 'nullable|string|max:15',
            'telefone2'          => 'nullable|string|max:15',
            'email'              => 'required|email|max:255|unique:clientes,email,' . $cliente->id,
            'pgto_ad_noturno'    => 'nullable|numeric|min:0|max:100',
            'inss'               => 'nullable|numeric|min:0|max:100',
            'aux_uniforme'       => 'nullable|numeric|min:0',
            'vale_transporte'    => 'nullable|numeric|min:0',
            'dt_cadastro'        => 'nullable|date',
            'exigir_antecedentes'=> 'nullable|boolean',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove um cliente do banco de dados.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}
