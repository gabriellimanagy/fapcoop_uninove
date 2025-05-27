<?php

namespace App\Http\Controllers;

use PHPJasper\PHPJasper;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Escala;

class RelatorioFaturamentoController extends Controller
{
    public function index(Request $request)
    {
        // Parâmetros recebidos do formulário (com valores padrão null)
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $clienteId = $request->input('cliente_id');
        $setorId = $request->input('setor_id');
        $funcaoId = $request->input('funcao_id');
        $lote = $request->input('lote');
        $antesDaBaixa = $request->input('antes_da_baixa'); // Novo parâmetro

        // Se export_pdf=1, gere o relatório PDF
        if ($request->has('export_pdf')) {
            // Caminho completo do arquivo .jasper
            $input = public_path('reports/relatorio_faturamento.jasper');

            // Verifica se o arquivo existe
            if (!file_exists($input)) {
                return redirect()->back()->with('error', 'Arquivo .jasper não encontrado: ' . $input);
            }

            // Caminho completo de saída (onde o PDF será salvo)
            $output = public_path('reports/relatorio_faturamento') . time();

            // Parâmetros do relatório (construção dinâmica)
            $parameters = [];
            if ($dataInicio) {
                $parameters['dataInicio'] = date('Y-m-d', strtotime($dataInicio));
            }
            if ($dataFim) {
                $parameters['dataFim'] = date('Y-m-d', strtotime($dataFim));
            }
            if ($clienteId) {
                $parameters['clienteId'] = (int)$clienteId;
            }
            if ($setorId) {
                $parameters['setorId'] = (int)$setorId;
            }
            if ($funcaoId) {
                $parameters['funcaoId'] = (int)$funcaoId;
            }
            if ($lote) {
                $parameters['lote'] = $lote;
            }
            if ($antesDaBaixa !== null) {
                $parameters['antesDaBaixa'] = (int)$antesDaBaixa; // Passa o parâmetro para o Jasper
            }

            // Configuração da conexão com o banco de dados
            $database = config('database.connections.mysql');

            // Opções do relatório
            $options = [
                'format' => ['pdf'],
                'params' => $parameters,
                'db_connection' => [
                    'driver' => 'mysql',
                    'username' => $database['username'],
                    'password' => $database['password'],
                    'host' => $database['host'],
                    'database' => $database['database'],
                    'port' => $database['port'],
                ],
            ];

            // Instancia o PHPJasper
            $jasper = new PHPJasper();

            // Processa o relatório com depuração
            try {
                // Captura o comando que será executado
                $processCommand = $jasper->process($input, $output, $options)->output();
                \Log::info('Comando de processamento: ' . $processCommand); // Loga o comando

                // Executa o comando
                $jasper->process($input, $output, $options)->execute();

                // Retorna o arquivo PDF gerado
                $file = $output . '.pdf';
                if (file_exists($file)) {
                    return response()->download($file, 'relatorio_faturamento.pdf')->deleteFileAfterSend(true);
                } else {
                    return redirect()->back()->with('error', 'Erro ao gerar o relatório PDF.');
                }
            } catch (\Exception $e) {
                \Log::error('Erro ao gerar o relatório: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Erro ao gerar o relatório: ' . $e->getMessage());
            }
        }

        // Se não for exportação, exibe a tela com os dados
        $query = Escala::select('escalas.id AS escala_id', 'servicos.dt_servico', 'clientes.fantasia AS cliente_fantasia', 'setores.nome AS setor_nome', 'cooperados.nome AS cooperado_nome', 'funcoes.nome AS funcao_nome', 'servicos.hr_entrada', 'servicos.hr_saida', 'servicos.hr_extra', 'cliente_funcao.qtd_horas_trabalhadas', 'cliente_funcao.valor_hora_faturamento')
            ->join('servicos', 'servicos.escala_id', '=', 'escalas.id')
            ->join('cooperados', 'servicos.cooperado_id', '=', 'cooperados.id')
            ->join('funcoes', 'servicos.funcao_id', '=', 'funcoes.id')
            ->join('setores', 'escalas.setor_id', '=', 'setores.id')
            ->join('clientes', 'escalas.cliente_id', '=', 'clientes.id')
            ->join('cliente_funcao', function ($join) {
                $join->on('escalas.cliente_id', '=', 'cliente_funcao.cliente_id')
                    ->on('servicos.funcao_id', '=', 'cliente_funcao.funcao_id');
            });

        // Aplica os filtros
        if ($dataInicio) {
            $query->where('servicos.dt_servico', '>=', $dataInicio);
        }
        if ($dataFim) {
            $query->where('servicos.dt_servico', '<=', $dataFim);
        }
        if ($clienteId) {
            $query->where('escalas.cliente_id', $clienteId);
        }
        if ($setorId) {
            $query->where('escalas.setor_id', $setorId);
        }
        if ($funcaoId) {
            $query->where('servicos.funcao_id', $funcaoId);
        }
        if ($lote) {
            $query->where('escalas.lote', $lote);
        }
        if ($antesDaBaixa === '1') { // Filtro Antes da Baixa (status != 'baixada')
            $query->where('escalas.status', '!=', 'baixada');
        } elseif ($antesDaBaixa === '0') { // Filtro Baixados (status = 'baixada')
            $query->where('escalas.status', '=', 'baixada');
        }

        // Ordena por data (configuração atual do relatório)
        $query->orderBy('servicos.dt_servico')->orderBy('funcoes.nome');

        // Executa a consulta
        $dados = $query->get();

        // Busca os dados para os filtros
        $clientes = Cliente::all();
        $setores = Setor::all();
        $funcoes = Funcao::all();
        $lotes = Escala::select('lote')->distinct()->pluck('lote');

        // Retorna a view com os dados
        return view('financeiro.relatorio-faturamento', [
            'dados' => $dados,
            'clientes' => $clientes,
            'setores' => $setores,
            'funcoes' => $funcoes,
            'lotes' => $lotes,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'cliente_id' => $clienteId,
            'setor_id' => $setorId,
            'funcao_id' => $funcaoId,
            'lote' => $lote,
            'antes_da_baixa' => $antesDaBaixa, // Passa o parâmetro para a view
        ]);
    }
}
