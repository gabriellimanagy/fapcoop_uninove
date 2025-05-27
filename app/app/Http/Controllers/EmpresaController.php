<?php
namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresa.index', compact('empresas'));
    }

    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:empresas,cnpj',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para a logo
            // outros campos de validação...
        ]);

        try {
            $data = $request->all();

            // Verifica se o arquivo de logo foi enviado
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('logos', 'public'); // Salva a logo na pasta 'storage/app/public/logos'
            }

            Empresa::create($data);
            return redirect()->route('empresas.index')->with('success', 'Empresa cadastrada com sucesso!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('error', 'CNPJ já cadastrado.');
            }
            return redirect()->back()->with('error', 'Erro ao cadastrar empresa.');
        }
    }

    public function show(Empresa $empresa)
    {
        return view('empresa.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('empresa.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:empresas,cnpj,' . $empresa->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação para a logo
            // outros campos de validação...
        ]);

        try {
            $data = $request->all();

            // Verifica se o arquivo de logo foi enviado
            if ($request->hasFile('logo')) {
                // Remove a logo antiga, se existir
                if ($empresa->logo) {
                    Storage::disk('public')->delete($empresa->logo);
                }

                // Salva a nova logo
                $data['logo'] = $request->file('logo')->store('logos', 'public');
            }

            $empresa->update($data);
            return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar empresa.');
        }
    }

    public function destroy(Empresa $empresa)
    {
        // Remove a logo associada, se existir
        if ($empresa->logo) {
            Storage::disk('public')->delete($empresa->logo);
        }

        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
    }
}
