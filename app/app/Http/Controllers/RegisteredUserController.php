<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Support\Facades\Hash;


class RegisteredUserController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function index()
    {
        $users = User::select('id', 'name', 'celular', 'departamento_id')->get();
        return view('funcionarios.index', compact('users'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('funcionarios.create', compact('departamentos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|max:14|unique:users',
            'celular' => 'required|string|max:15',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $this->createNewUser->create($request->all());

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $user)
    {
        return view('funcionarios.show', compact('user'));
    }

    public function edit(User $user)
    {
        $departamentos = Departamento::all();
        return view('funcionarios.edit', compact('user', 'departamentos'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }



    public function resetPassword(User $user)
    {
        $user->password = Hash::make('2SCJ^vMRp!');
        $user->save();

        return redirect()->route('users.edit', $user->id)->with('success', 'Senha redefinida com sucesso!');
    }
}
