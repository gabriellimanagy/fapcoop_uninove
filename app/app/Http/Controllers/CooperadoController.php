<?php
namespace App\Http\Controllers;

use App\Models\Cooperado;
use App\Models\CooperadoContato;
use App\Models\CooperadoPessoal;
use App\Models\CooperadoDocumento;
use App\Models\Financeiro;
use App\Models\Disponibilidade;
use Illuminate\Http\Request;

class CooperadoController extends Controller
{
    public function index()
    {
        $cooperados = Cooperado::all();
        return view('cooperados.index', compact('cooperados'));
    }

    public function create()
    {
        do {
            $firstDigit = mt_rand(1, 9);
            $lastDigits = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $matricula = $firstDigit . $lastDigits;
            $exists = Cooperado::where('matricula', $matricula)->exists();
        } while ($exists);

        return view('cooperados.create', compact('matricula'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'matricula' => 'required|unique:cooperados',
                'nome' => 'required',
                'sexo' => 'required',
                'status' => 'required',
                'cpf' => 'required|unique:cooperado_documentos,cpf', // Adiciona validação de CPF único
            ]);

            $cooperado = Cooperado::create($request->only([
                'matricula', 'dt_cadastro', 'dt_ultima_escala',
                'nome', 'sexo', 'dt_desligamento', 'status'
            ]));

            CooperadoContato::create(array_merge(
                $request->only([
                    'telefone1', 'telefone2', 'email',
                    'cep', 'endereco', 'zona', 'bairro', 'cidade', 'uf'
                ]),
                [
                    'cooperado_id' => $cooperado->id,
                    'celular' => $request->celular ?? '',
                    'whatsapp' => $request->has('whatsapp') ? 1 : 0,
                ]
            ));

            CooperadoPessoal::create([
                'cooperado_id' => $cooperado->id,
                'dt_nascimento' => $request->dt_nascimento,
                'nacionalidade' => $request->nacionalidade,
                'nome_mae' => $request->nome_mae,
                'nome_pai' => $request->nome_pai,
                'est_civil' => $request->est_civil,
                'escolaridade' => $request->escolaridade,
                'qualificacao' => $request->qualificacao,
                'qualificacao_justificativa' => $request->qualificacao_justificativa,
                'indicado_por' => $request->indicado_por,
            ]);

            CooperadoDocumento::create([
                'cooperado_id' => $cooperado->id,
                'cpf' => $request->cpf,
                'ccm' => $request->ccm,
                'num_pis_inss' => $request->num_pis_inss,
                'rg' => $request->rg,
                'dt_emissao' => $request->dt_emissao,
                'orgao_emissor' => $request->orgao_emissor,
                'cidade_natal' => $request->cidade_natal,
                'dt_entrega_at_saude' => $request->dt_entrega_at_saude,
                'carteira_trab' => $request->carteira_trab,
                'serie' => $request->serie,
                'titulo_eleitor' => $request->titulo_eleitor,
                'zona_eleitoral' => $request->zona_eleitoral,
                'num_cracha_carteirinha' => $request->num_cracha_carteirinha,
                'cracha_cart_possui' => $request->has('cracha_cart_possui') ? 1 : 0,
                'antecedentes_criminais_dt_consulta' => $request->antecedentes_criminais_dt_consulta,
                'antecedentes_consultado_por' => $request->antecedentes_consultado_por,
                'status' => $request->status_antecedentes,
            ]);

            Financeiro::create([
                'cooperado_id' => $cooperado->id,
                'descontar_inss' => $request->has('descontar_inss') ? 1 : 0,
                'descontar_ir' => $request->has('descontar_ir') ? 1 : 0,
                'receber_por' => $request->receber_por,
                'banco_agencia' => $request->banco_agencia,
                'banco_conta' => $request->banco_conta,
                'banco_tipo_conta' => $request->banco_tipo_conta,
                'pix_tipo_chave' => $request->pix_tipo_chave,
                'chave_pix' => $request->chave_pix,
            ]);

            Disponibilidade::create([
                'cooperado_id' => $cooperado->id,
                'segunda_feira' => $request->has('segunda_feira') ? 1 : 0,
                'terca_feira' => $request->has('terca_feira') ? 1 : 0,
                'quarta_feira' => $request->has('quarta_feira') ? 1 : 0,
                'quinta_feira' => $request->has('quinta_feira') ? 1 : 0,
                'sexta_feira' => $request->has('sexta_feira') ? 1 : 0,
                'sabado' => $request->has('sabado') ? 1 : 0,
                'domingo' => $request->has('domingo') ? 1 : 0,
            ]);

            return redirect()->route('cooperados.index')->with('success', 'Cooperado criado com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function show(Cooperado $cooperado)
    {
        return view('cooperados.show', compact('cooperado'));
    }

    public function edit(Cooperado $cooperado)
    {
        try {
            $cooperado->load([
                'contato',
                'dadosPessoais',
                'documentos',
                'financeiro',
                'disponibilidade'
            ]);

            if (!$cooperado->relationLoaded('contato') || !$cooperado->relationLoaded('dadosPessoais') || !$cooperado->relationLoaded('documentos') || !$cooperado->relationLoaded('financeiro') || !$cooperado->relationLoaded('disponibilidade')) {
                return redirect()->route('cooperados.index')->with('error', 'Erro ao carregar as informações do cooperado.');
            }

            if (!$cooperado->contato) {
                $cooperado->contato()->create([]);
            }
            if (!$cooperado->dadosPessoais) {
                $cooperado->dadosPessoais()->create([]);
            }
            if (!$cooperado->documentos) {
                $cooperado->documentos()->create([]);
            }
            if (!$cooperado->financeiro) {
                $cooperado->financeiro()->create([]);
            }
            if (!$cooperado->disponibilidade) {
                $cooperado->disponibilidade()->create([]);
            }

            return view('cooperados.edit', compact('cooperado'));
        } catch (\Exception $e) {
            return redirect()->route('cooperados.index')->with('error', 'Erro ao carregar o cooperado: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Cooperado $cooperado)
    {
        try {
            // Log para verificar os dados recebidos
            \Log::info('Dados recebidos no update:', $request->all());

            $request->validate([
                'matricula' => 'required|unique:cooperados,matricula,' . $cooperado->id,
                'nome' => 'required',
                'sexo' => 'required',
                'status' => 'required',
                'cpf' => 'required|unique:cooperado_documentos,cpf,' . ($cooperado->documentos ? $cooperado->documentos->id : '0') . ',id', // Validação de CPF único, ignorando o registro atual
            ]);

            $cooperado->update($request->only([
                'matricula', 'dt_cadastro', 'dt_ultima_escala',
                'nome', 'sexo', 'dt_desligamento', 'status'
            ]));

            if ($cooperado->contato) {
                $cooperado->contato->update(array_merge(
                    $request->only([
                        'telefone1', 'telefone2', 'email',
                        'cep', 'endereco', 'zona', 'bairro', 'cidade', 'uf'
                    ]),
                    [
                        'celular' => $request->celular ?? '',
                        'whatsapp' => $request->has('whatsapp') ? 1 : 0,
                    ]
                ));
            }

            // Atualização das outras tabelas (dadosPessoais, documentos, financeiro, disponibilidade)
            if ($cooperado->dadosPessoais) {
                $cooperado->dadosPessoais->update([
                    'dt_nascimento' => $request->dt_nascimento,
                    'nacionalidade' => $request->nacionalidade,
                    'nome_mae' => $request->nome_mae,
                    'nome_pai' => $request->nome_pai,
                    'est_civil' => $request->est_civil,
                    'escolaridade' => $request->escolaridade,
                    'qualificacao' => $request->qualificacao,
                    'qualificacao_justificativa' => $request->qualificacao_justificativa,
                    'indicado_por' => $request->indicado_por,
                ]);
            }

            if ($cooperado->documentos) {
                $cooperado->documentos->update([
                    'cpf' => $request->cpf,
                    'ccm' => $request->ccm,
                    'num_pis_inss' => $request->num_pis_inss,
                    'rg' => $request->rg,
                    'dt_emissao' => $request->dt_emissao,
                    'orgao_emissor' => $request->orgao_emissor,
                    'cidade_natal' => $request->cidade_natal,
                    'dt_entrega_at_saude' => $request->dt_entrega_at_saude,
                    'carteira_trab' => $request->carteira_trab,
                    'serie' => $request->serie,
                    'titulo_eleitor' => $request->titulo_eleitor,
                    'zona_eleitoral' => $request->zona_eleitoral,
                    'num_cracha_carteirinha' => $request->num_cracha_carteirinha,
                    'cracha_cart_possui' => $request->has('cracha_cart_possui') ? 1 : 0,
                    'antecedentes_criminais_dt_consulta' => $request->antecedentes_criminais_dt_consulta,
                    'antecedentes_consultado_por' => $request->antecedentes_consultado_por,
                    'status' => $request->status_antecedentes,
                ]);
            }

            if ($cooperado->financeiro) {
                $cooperado->financeiro->update([
                    'descontar_inss' => $request->has('descontar_inss') ? 1 : 0,
                    'descontar_ir' => $request->has('descontar_ir') ? 1 : 0,
                    'receber_por' => $request->receber_por,
                    'banco_agencia' => $request->banco_agencia,
                    'banco_conta' => $request->banco_conta,
                    'banco_tipo_conta' => $request->banco_tipo_conta,
                    'pix_tipo_chave' => $request->pix_tipo_chave,
                    'chave_pix' => $request->chave_pix,
                ]);
            }

            if ($cooperado->disponibilidade) {
                $cooperado->disponibilidade->update([
                    'segunda_feira' => $request->has('segunda_feira') ? 1 : 0,
                    'terca_feira' => $request->has('terca_feira') ? 1 : 0,
                    'quarta_feira' => $request->has('quarta_feira') ? 1 : 0,
                    'quinta_feira' => $request->has('quinta_feira') ? 1 : 0,
                    'sexta_feira' => $request->has('sexta_feira') ? 1 : 0,
                    'sabado' => $request->has('sabado') ? 1 : 0,
                    'domingo' => $request->has('domingo') ? 1 : 0,
                ]);
            }

            return redirect()->route('cooperados.index')->with('success', 'Cooperado atualizado com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar cooperado: ' . $e->getMessage());
            return back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    public function destroy(Cooperado $cooperado)
    {
        $cooperado->delete();
        return redirect()->route('cooperados.index')->with('success', 'Cooperado deletado com sucesso.');
    }
}
