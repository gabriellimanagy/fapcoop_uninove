<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Setor;
use App\Models\Funcao;
use App\Models\Escala;
use App\Models\Servico;
use App\Models\User;
use App\Models\Cooperado;
use Carbon\Carbon;

class EscalaSeeder extends Seeder
{
    public function run()
    {
        $clientes = Cliente::all();
        $setores = Setor::all();
        $users = User::all();
        $cooperados = Cooperado::all();
        $funcoes = Funcao::all();
        
        // Garantir que as coleções não estão vazias
        if ($clientes->isEmpty() || $setores->isEmpty() || $users->isEmpty() || $cooperados->isEmpty() || $funcoes->isEmpty()) {
            throw new \Exception('Algumas coleções estão vazias. Verifique os seeders.');
        }

        // Criação de escalas únicas
        $escalas = [];
        
        for ($i = 0; $i < 3; $i++) {
            do {
                $clienteId = $clientes->random()->id;
                $setorId = $setores->random()->id;
                $userId = $users->random()->id;
                $dataServico = Carbon::now()->addDays(7); // Data do serviço no futuro (7 dias a partir de agora)

                // Verifica se já existe uma escala com a mesma combinação
                $escalaExistente = Escala::where('cliente_id', $clienteId)
                    ->where('setor_id', $setorId)
                    ->where('user_id', $userId)
                    ->where('data_servico', $dataServico)
                    ->exists();
            } while ($escalaExistente);

            // Cria a escala
            $escala = Escala::create([
                'cliente_id' => $clienteId,
                'setor_id' => $setorId,
                'user_id' => $userId,
                'status' => 'aberta',
                'data_solicitacao' => Carbon::now(),
                'data_servico' => $dataServico,
                'data_inicio_servico' => $dataServico,
                'fechamento_de_escala' => false,
                'pagamento' => 0,  // Alterar para 0 para "pendente"
            ]);
            
            $escalas[] = $escala;
        }

        // Criando serviços para cada escala com 10 cooperados aleatórios
        foreach ($escalas as $escala) {
            // Seleciona 10 cooperados aleatórios para cada escala
            $cooperadosParaEscala = $cooperados->random(10);

            foreach ($cooperadosParaEscala as $cooperado) {
                // Cria um serviço para cada cooperado na escala
                Servico::factory()->create([
                    'escala_id' => $escala->id,
                    'cooperado_id' => $cooperado->id,
                    'funcao_id' => $funcoes->random()->id,
                    'hr_entrada' => '08:00:00',
                    'hr_saida' => '17:00:00',
                    'hr_extra' => '01:00:00',
                    'dt_servico' => $escala->data_servico,
                    'dias_servico' => 1,
                ]);
            }
        }
    }
}
