<?php
namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Permissao; // Alterado de Permission para Permissao
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento criado com sucesso!');
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('success', 'Departamento atualizado com sucesso!');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso!');
    }

    public function permissions(Departamento $departamento)
    {
        $allPermissions = Permissao::all();
        $currentPermissions = $departamento->permissoes->pluck('id')->toArray(); // Usando a relação carregada

        return view('departamentos.gerenciar', compact('departamento', 'allPermissions', 'currentPermissions'));
    }

    public function updatePermissions(Request $request, Departamento $departamento)
    {
        $departamento->permissoes()->sync($request->allowed); // Alterado para permissoes

        return redirect()->route('departamentos.index')->with('success', 'Permissões atualizadas com sucesso!');
    }
}
