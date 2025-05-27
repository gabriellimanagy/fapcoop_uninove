<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\EmpresaController;
    use App\Http\Controllers\RegisteredUserController;
    use App\Http\Controllers\DepartamentoController;
    use App\Http\Controllers\CooperadoController;
    use App\Http\Controllers\ClienteController;
    use App\Http\Controllers\FuncaoController;
    use App\Http\Middleware\CheckPermission;
    use App\Http\Controllers\EscalaController;
    use App\Livewire\ClienteFuncaoManager;
    use App\Http\Controllers\ValeController;
    use App\Http\Controllers\RelatorioFaturamentoController;
    use App\Http\Controllers\Folhapgt;
    use App\Http\Controllers\ReciboController;
    use App\Http\Controllers\ReportController;

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/dados', function () {
            return view('dados');
        })->name('dados');

        Route::get('/permissao', function () {
            return view('permissao');
        })->name('permissao');

        Route::resource('empresas', EmpresaController::class)->middleware(CheckPermission::class.':empresa_cooperativa_menu_ativar');

        Route::get('/funcionarios', function () {
            return view('funcionarios');
        })->name('funcionarios');

        Route::middleware('permission:empresa_funcionarios_menu_ativar')->group(function () {
            Route::resource('users', RegisteredUserController::class);
            Route::put('/users/{user}/reset_password', [RegisteredUserController::class, 'resetPassword'])->name('users.reset_password');
        });

        // Rotas para o CRUD de clientes
        Route::resource('clientes', ClienteController::class);
        Route::resource('escala', EscalaController::class);
        Route::get('/baixar-escalas', [EscalaController::class, 'baixarEscalas'])->name('baixar-escalas');
        Route::post('escalas/baixar', [EscalaController::class, 'dar_baixa'])->name('baixar');
        Route::get('/escala/{id}/report', [EscalaController::class, 'report'])->name('escala.report');
        Route::get('/escala/{id}/download', [EscalaController::class, 'downloadReport'])->name('escala.download');

        Route::get('/clientes/{clienteId}/setores', [ClienteController::class, 'getSetores'])->name('clientes.setores');
        Route::get('/clientes/{cliente}/funcoes/json', [ClienteController::class, 'getFuncoes']);

        Route::resource('departamentos', DepartamentoController::class)->names([
            'index' => 'departamentos.index',
            'create' => 'departamentos.create',
            'store' => 'departamentos.store',
            'show' => 'departamentos.show',
            'edit' => 'departamentos.edit',
            'update' => 'departamentos.update',
            'destroy' => 'departamentos.destroy',
        ]);
        Route::delete('/escala/destroy-multiple', [EscalaController::class, 'destroyMultiple'])->name('escala.destroy.multiple');
        Route::resource('cooperados', CooperadoController::class);
        Route::get('departamentos/{departamento}/permissions', [DepartamentoController::class, 'permissions'])->name('departamentos.permissions');
        Route::put('departamentos/{departamento}/permissions', [DepartamentoController::class, 'updatePermissions'])->name('departamentos.update_permissions');
        Route::get('/clientes/{cliente}/funcoes', [EscalaController::class, 'getFuncoesPorCliente'])->name('clientes.funcoes');

        Route::get('/funcoes/create', [FuncaoController::class, 'create'])->name('funcoes.create');
        Route::get('/funcoes', \App\Livewire\FuncaoManager::class)->name('funcoes.index');
        Route::get('/clientes/{cliente}/funcoes', ClienteFuncaoManager::class)->name('clientes.funcoes.index');
        Route::get('/clientes/{cliente}/funcoes/json', [EscalaController::class, 'getFuncoesPorCliente'])->name('clientes.funcoes.json');

        Route::get('/financeiro/recibos-por-lote', [EscalaController::class, 'recibosPorLote'])->name('financeiro.recibos-por-lote');

        // Rota para o relatório de faturamento
        Route::get('/relatorios/faturamento', [RelatorioFaturamentoController::class, 'index'])->name('relatorios.faturamento');

        Route::resource('folhapgt', Folhapgt::class);

        Route::resource('vales', ValeController::class);
        Route::get('/select-search/cooperados', [\App\Http\Controllers\SelectSearchController::class, 'searchCooperados'])->name('select.search.cooperados');

        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');
    });
