<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Escala;
use App\Models\Cliente;
use App\Models\Setor;
use App\Models\Cooperado;
use App\Models\Funcao;
use App\Models\Servico;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecibosExport;
use Barryvdh\Snappy\Facades\SnappyPdf;

class EscalaController extends Controller
{
    /**
     * Exibe a lista de escalas.
     */

     public function index()
     {
         $escalas = Escala::with(['cliente', 'cooperados', 'user', 'setor', 'servicos' => function ($query) {
             $query->with(['cooperado', 'funcao']);
         }])->get();

         // Calcula os dados financeiros para cada serviço e adiciona ao array
         $financialData = [];
         foreach ($escalas as $escala) {
             $financialData[$escala->id] = []; // Inicializa o array para cada escala
             foreach ($escala->servicos as $servico) {
                 $clienteId = $escala->cliente_id;
                 $funcaoId = $servico->funcao_id;

                 $clienteFuncao = DB::table('cliente_funcao')
                     ->where('cliente_id', $clienteId)
                     ->where('funcao_id', $funcaoId)
                     ->first();

                 $valorRepasse = 0;
                 $valorFaturamento = 0;

                 if ($clienteFuncao) {
                     $hrEntrada = Carbon::parse($servico->hr_entrada);
                     $hrSaida = Carbon::parse($servico->hr_saida);
                     $horasRegulares = $hrEntrada->diffInHours($hrSaida);

                     // Cálculo de repasse (correto conforme modelo)
                     $valorRepasseRegular = $horasRegulares * ($clienteFuncao->valor_hora_repasse ?? 0);
                     $valorRepasseExtra = 0;
                     if ($servico->hr_extra) {
                         $horasExtras = is_numeric($servico->hr_extra) ? $servico->hr_extra : Carbon::parse($servico->hr_extra)->hour;
                         $valorRepasseExtra = $horasExtras * ($clienteFuncao->valor_hora_extra_repasse ?? 0);
                     }
                     $valorRepasse = $valorRepasseRegular + $valorRepasseExtra;

                     // Cálculo de faturamento (corrigido para usar os nomes corretos dos campos)
                     $valorFaturamentoRegular = $horasRegulares * ($clienteFuncao->valor_hora_faturamento ?? 0);
                     $valorFaturamentoExtra = 0;
                     if ($servico->hr_extra) {
                         $horasExtras = is_numeric($servico->hr_extra) ? $servico->hr_extra : Carbon::parse($servico->hr_extra)->hour;
                         $valorFaturamentoExtra = $horasExtras * ($clienteFuncao->valor_hora_extra_faturamento ?? 0);
                     }
                     $valorFaturamento = $valorFaturamentoRegular + $valorFaturamentoExtra;
                 }

                 $financialData[$escala->id][] = [
                     'valor_repasse' => $valorRepasse,
                     'valor_faturamento' => $valorFaturamento,
                 ];
             }
         }

         return view('escala.index', compact('escalas', 'financialData'));
     }

    /**
     * Mostra o formulário para criação de uma nova escala.
     */
    public function create()
    {
        $clientes   = Cliente::all();
        $cooperados = Cooperado::all();
        // Inicialmente, não carregamos funções – estas serão carregadas dinamicamente
        $funcoes    = [];
        return view('escala.create', compact('clientes', 'cooperados', 'funcoes'));
    }

    /**
     * Armazena uma nova escala.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'          => 'required|exists:clientes,id',
            'setor_id'            => 'required|exists:setores,id',
            'data_solicitacao'    => 'required|date_format:d/m/Y',
            'data_inicio_servico' => 'required|date_format:d/m/Y',
            'data_servico'        => 'required|date_format:Y-m-d', // Ajustado para formato ISO
            'user_id'             => 'required|exists:users,id',
            'cooperados'          => 'required|array|min:1',
            'cooperados.*'        => 'exists:cooperados,id',
            'hr_entrada'          => 'required|array',
            'hr_saida'            => 'required|array',
            'hr_extra'            => 'nullable|array',
            'dt_servico'          => 'nullable|array',
            'dias_servico'        => 'nullable|array',
            'funcoes_cooperado'   => 'nullable|array',
        ]);

        $escala = new Escala();
        $escala->cliente_id = $request->cliente_id;
        $escala->setor_id = $request->setor_id;
        $escala->nome_evento = $request->nome_evento;
        $escala->data_solicitacao = Carbon::createFromFormat('d/m/Y', $request->data_solicitacao)->toDateString();
        $escala->data_servico = Carbon::parse($request->data_servico)->toDateString(); // Parsing ajustado
        $escala->data_inicio_servico = Carbon::createFromFormat('d/m/Y', $request->data_inicio_servico)->toDateString();
        $escala->observacoes = $request->observacoes;
        $escala->user_id = $request->user_id;
        $escala->save();

        foreach ($request->cooperados as $index => $cooperadoId) {
            if ($cooperadoId) {
                $dataServicoInicial = $request->dt_servico[$index] ?? $request->data_inicio_servico; // Fallback para data_inicio_servico
                $dataServicoInicial = Carbon::createFromFormat('d/m/Y', $dataServicoInicial);
                $diasServico = (int) ($request->dias_servico[$index] ?? 1);

                for ($dia = 0; $dia < $diasServico; $dia++) {
                    $dataServico = $dataServicoInicial->copy()->addDays($dia);

                    $escala->cooperados()->attach($cooperadoId, [
                        'funcao_id'    => $request->input("funcoes_cooperado.$index", null),
                        'hr_entrada'   => $request->hr_entrada[$index],
                        'hr_saida'     => $request->hr_saida[$index],
                        'hr_extra'     => $request->hr_extra[$index] ?? null,
                        'dt_servico'   => $dataServico->toDateString(),
                        'dias_servico' => $diasServico
                    ]);
                }
            }
        }

        return redirect()->route('escala.index')->with('success', 'Escala criada com sucesso!');
    }
    /**
     * Exibe os detalhes de uma escala.
     */
    public function show($id)
    {
        $escala = Escala::with('cliente', 'cooperados')->findOrFail($id);
        return view('escala.show', compact('escala'));
    }

    /**
     * Mostra o formulário para edição de uma escala.
     */
    public function edit($id)
    {
        $escala = Escala::with(['cooperados' => function ($query) {
            $query->withPivot('funcao_id', 'hr_entrada', 'hr_saida', 'hr_extra', 'dt_servico', 'dias_servico');
        }, 'cliente', 'setor', 'servicos'])->findOrFail($id);

        $clientes = Cliente::all();
        $setores = Setor::where('cliente_id', $escala->cliente_id)->get();
        $cooperados = Cooperado::all();
        $cliente = $escala->cliente;
        $funcoes = $cliente ? $cliente->funcoes : collect();
        $servicos = $escala->servicos;

        return view('escala.edit', compact('escala', 'clientes', 'setores', 'cooperados', 'funcoes', 'servicos'));
    }
    /**
     * Atualiza os dados de uma escala.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'setor_id' => 'required|exists:setores,id',
            'data_solicitacao' => 'required|date_format:d/m/Y',
            'data_inicio_servico' => 'required|date_format:d/m/Y',
            'cooperados.*.id' => 'required|exists:cooperados,id',
            'cooperados.*.hr_entrada' => 'required|date_format:H:i',
            'cooperados.*.hr_saida' => 'required|date_format:H:i',
            'cooperados.*.hr_extra' => 'nullable|date_format:H:i',
            'cooperados.*.dt_servico' => 'required|date_format:d/m/Y',
            'cooperados.*.servico_id' => 'nullable|exists:servicos,id',
            'cooperados.*.dias_servico' => 'nullable|integer|min:1|max:30',
        ]);

        DB::beginTransaction();
        try {
            $escala = Escala::findOrFail($id);

            $escala->update([
                'cliente_id' => $request->cliente_id,
                'setor_id' => $request->setor_id,
                'nome_evento' => $request->nome_evento,
                'data_solicitacao' => Carbon::createFromFormat('d/m/Y', $request->data_solicitacao)->toDateString(),
                'data_servico' => Carbon::parse($request->data_servico)->toDateString(),
                'data_inicio_servico' => Carbon::createFromFormat('d/m/Y', $request->data_inicio_servico)->toDateString(),
                'observacoes' => $request->observacoes,
                'user_id' => $request->user_id,
            ]);

            $servicosManterIds = [];

            foreach ($request->cooperados as $cooperadoData) {
                $servicoId = $cooperadoData['servico_id'] ?? null;
                $diasServico = isset($cooperadoData['dias_servico']) ? (int)$cooperadoData['dias_servico'] : 1;

                if ($servicoId) {
                    // Update existing service
                    Servico::where('id', $servicoId)->update([
                        'funcao_id' => $cooperadoData['funcao_id'] ?? null,
                        'hr_entrada' => $cooperadoData['hr_entrada'],
                        'hr_saida' => $cooperadoData['hr_saida'],
                        'hr_extra' => $cooperadoData['hr_extra'] ?? null,
                        'dt_servico' => Carbon::createFromFormat('d/m/Y', $cooperadoData['dt_servico'])->toDateString(),
                    ]);
                    $servicosManterIds[] = $servicoId;
                } else {
                    // Create new service(s) - one for each day in dias_servico
                    $dataServicoInicial = Carbon::createFromFormat('d/m/Y', $cooperadoData['dt_servico']);

                    for ($dia = 0; $dia < $diasServico; $dia++) {
                        $dataServico = $dataServicoInicial->copy()->addDays($dia);

                        $novoServico = Servico::create([
                            'escala_id' => $escala->id,
                            'cooperado_id' => $cooperadoData['id'],
                            'funcao_id' => $cooperadoData['funcao_id'] ?? null,
                            'hr_entrada' => $cooperadoData['hr_entrada'],
                            'hr_saida' => $cooperadoData['hr_saida'],
                            'hr_extra' => $cooperadoData['hr_extra'] ?? null,
                            'dt_servico' => $dataServico->toDateString(),
                        ]);
                        $servicosManterIds[] = $novoServico->id;
                    }
                }
            }

            // Remove services not in the updated list
            Servico::where('escala_id', $escala->id)
                ->whereNotIn('id', $servicosManterIds)
                ->delete();

            DB::commit();
            return redirect()->route('escala.index')->with('success', 'Escala atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar escala: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Erro ao atualizar escala: ' . $e->getMessage()]);
        }
    }
    /**
     * Exclui uma escala.
     */
    public function destroy($id)
    {
        $escala = Escala::findOrFail($id);
        $escala->cooperados()->detach();
        $escala->delete();

        return redirect()->route('escala.index')->with('success', 'Escala deletada com sucesso!');
    }

    /**
     * Retorna as funções associadas ao cliente selecionado.
     */
    public function getFuncoesPorCliente($clienteId)
    {
        $cliente = Cliente::with('funcoes')->findOrFail($clienteId);
        return response()->json($cliente->funcoes);
    }

    /**
     * Método para exibir a página de baixar escalas
     */
    public function baixarEscalas()
    {
        $escalas = Escala::with(['setor.cliente', 'servicos.cooperado', 'servicos.funcao'])
                        ->where('status', '!=', 'baixada')
                        ->get();

        return view('financeiro.baixar-escalas', compact('escalas'));
    }
    public function destroyMultiple(Request $request)
    {
        $ids = json_decode($request->input('ids'), true);
        Escala::whereIn('id', $ids)->delete();
        return redirect()->route('escala.index')->with('success', 'Escalas excluídas com sucesso!');
    }
    public function dar_baixa(Request $request)
    {

        $escala = Escala::findOrFail($request->escala_id);
        $escala->status = 'baixada';
        $escala->lote = $request->lote;
        $escala->save();

        // Log da ação
        Log::info('Escala com ID ' . $escala->id . ' foi baixada por ' . auth()->user()->name);

        return response()->json(['message' => 'Escala alterada com sucesso']);
    }

    public function recibosPorLote(Request $request)
    {
        $lote = $request->input('lote'); // Pega o lote do formulário

        // Inicializa variáveis para evitar erros de "undefined variable"
        $recibos = collect(); // Coleção vazia por padrão
        $valorTotalLote = 0;
        $mesRef = 'N/A';
        $dtPagamento = 'N/A';

        // Se um lote foi selecionado, busca os dados
        if ($lote) {
            // Busca os serviços do lote, com as relações necessárias
            $servicos = Servico::whereHas('escala', function ($query) use ($lote) {
                $query->where('lote', $lote);
            })
            ->with(['cooperado', 'funcao', 'escala.cliente'])
            ->get();

            // Agrupa os serviços por cooperado_id e calcula o valor total
            $recibos = $servicos->groupBy('cooperado_id')->map(function ($servicosPorCooperado) {
                $totalValor = 0;

                foreach ($servicosPorCooperado as $servico) {
                    // Pega o cliente_id da escala
                    $clienteId = $servico->escala->cliente_id;
                    $funcaoId = $servico->funcao_id;

                    // Busca as taxas na tabela cliente_funcao
                    $clienteFuncao = DB::table('cliente_funcao')
                        ->where('cliente_id', $clienteId)
                        ->where('funcao_id', $funcaoId)
                        ->first();

                    if (!$clienteFuncao) {
                        continue; // Pula se não encontrar as taxas
                    }

                    // Calcula as horas regulares
                    $hrEntrada = Carbon::parse($servico->hr_entrada);
                    $hrSaida = Carbon::parse($servico->hr_saida);
                    $horasRegulares = $hrEntrada->diffInHours($hrSaida);

                    // Calcula o valor das horas regulares
                    $valorRegular = $horasRegulares * ($clienteFuncao->valor_hora_repasse ?? 0);

                    // Calcula o valor das horas extras
                    $horasExtras = 0;
                    if ($servico->hr_extra) {
                        if (is_numeric($servico->hr_extra)) {
                            $horasExtras = $servico->hr_extra;
                        } else {
                            $horasExtras = Carbon::parse($servico->hr_extra)->hour;
                        }
                    }
                    $valorExtra = $horasExtras * ($clienteFuncao->valor_hora_extra_repasse ?? 0);

                    // Soma o valor total deste serviço
                    $totalValor += $valorRegular + $valorExtra;
                }

                return [
                    'cooperado_id' => $servicosPorCooperado->first()->cooperado_id,
                    'cooperado' => $servicosPorCooperado->first()->cooperado,
                    'total_valor' => $totalValor,
                ];
            })->values();

            // Calcula o valor total do lote
            $valorTotalLote = $recibos->sum('total_valor');

            // Determina o mês de referência e a data de pagamento (baseado no lote)
            if (preg_match('/(JAN|FEV|MAR|ABR|MAI|JUN|JUL|AGO|SET|OUT|NOV|DEZ)(\d{2})/', $lote, $matches)) {
                $mes = $matches[1];
                $ano = '20' . $matches[2];
                $meses = [
                    'JAN' => 'JANEIRO', 'FEV' => 'FEVEREIRO', 'MAR' => 'MARÇO', 'ABR' => 'ABRIL',
                    'MAI' => 'MAIO', 'JUN' => 'JUNHO', 'JUL' => 'JULHO', 'AGO' => 'AGOSTO',
                    'SET' => 'SETEMBRO', 'OUT' => 'OUTUBRO', 'NOV' => 'NOVEMBRO', 'DEZ' => 'DEZEMBRO'
                ];
                $mesRef = $meses[$mes] . '/' . $ano;
                $dtPagamento = $meses[$mes] . '/' . $ano;
            }

            // Verifica se o botão de exportação foi clicado
            if ($request->has('export')) {
                $password = $request->input('password', 'senha123'); // Pega a senha do formulário, com fallback para 'senha123'
                return Excel::download(new RecibosExport($recibos, $password), "recibos_lote_{$lote}.xlsx");
            }
        }

        // Busca todos os lotes disponíveis para o dropdown
        $lotes = Escala::whereNotNull('lote')->distinct()->pluck('lote');

        // Retorna a view correta
        return view('financeiro.recibos-por-lote', compact('recibos', 'lote', 'valorTotalLote', 'mesRef', 'dtPagamento', 'lotes'));
    }

    public function report($id)
    {
        $escala = Escala::with(['cliente', 'setor', 'cooperados', 'servicos.funcao'])->findOrFail($id);

        // Convertir logo a base64 para asegurar que se muestre en el PDF
        $logoPath = public_path('img/logopng.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        return view('escala.report', compact('escala', 'logoBase64'));
    }

    public function downloadReport($id)
    {
        $escala = Escala::with(['cliente', 'setor', 'cooperados', 'servicos.funcao', 'servicos.cooperado.documentos'])->findOrFail($id);

        // Convertir logo a base64 para asegurar que se muestre en el PDF
        $logoPath = public_path('img/logopng.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        try {
            // Use Snappy with explicit binary configuration for reliability on Windows
            $pdf = SnappyPdf::loadView('escala.report', compact('escala', 'logoBase64'))
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOption('margin-top', 15)
                ->setOption('margin-right', 15)
                ->setOption('margin-bottom', 15)
                ->setOption('margin-left', 15)
                ->setOption('encoding', 'UTF-8');

            return $pdf->download('relatorio_escala_' . $id . '.pdf');
        } catch (\Exception $e) {
            // Fallback to DomPDF if Snappy fails
            \Log::error('Snappy PDF error: ' . $e->getMessage());

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('escala.report', compact('escala'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('relatorio_escala_' . $id . '_fallback.pdf');
        }
    }

}
