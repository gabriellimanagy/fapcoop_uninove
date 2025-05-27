<?php 

namespace Database\Factories;

use App\Models\Escala;
use App\Models\Cliente;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EscalaFactory extends Factory
{
    protected $model = Escala::class;

    public function definition()
    {
        // Carregar coleções para garantir que o código não faça múltiplas consultas ao banco de dados
        $clientes = Cliente::all();
        $setores = Setor::all();
        $users = User::all();

        // Garantir que as coleções não estão vazias
        if ($clientes->isEmpty() || $setores->isEmpty() || $users->isEmpty()) {
            throw new \Exception('Algumas coleções estão vazias. Verifique os seeders.');
        }

        // Garante IDs aleatórios para cliente, setor e usuário
        $clienteId = $clientes->random()->id;
        $setorId = $setores->random()->id;
        $userId = $users->random()->id;
        $dataServico = now()->addDays(7); // Define a data do serviço

        // Verifica se a combinação de cliente, setor, usuário e data_servico já existe
        while (Escala::where('cliente_id', $clienteId)
                    ->where('setor_id', $setorId)
                    ->where('user_id', $userId)
                    ->where('data_servico', $dataServico)
                    ->exists()) {
            // Se existir, escolhe novas IDs aleatórias e nova data_servico
            $clienteId = $clientes->random()->id;
            $setorId = $setores->random()->id;
            $userId = $users->random()->id;
            $dataServico = now()->addDays(rand(1, 30)); // Gera uma data de serviço aleatória nos próximos 30 dias
        }

        return [
            'cliente_id' => $clienteId,
            'setor_id' => $setorId,
            'user_id' => $userId,
            'status' => $this->faker->randomElement(['aberta', 'fechada']),
            'data_solicitacao' => now(),
            'data_servico' => $dataServico,
            'data_inicio_servico' => $dataServico,
            'fechamento_de_escala' => false,
            'pagamento' => $this->faker->randomElement(['pendente', 'pago']),
        ];
    }
}
