<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class RelatorioFaturamentoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function collection()
    {
        return $this->dados;
    }

    public function headings(): array
    {
        return [
            'ID Escala',
            'Data Evento',
            'ID Cliente',
            'Nome Fantasia',
            'ID Setor',
            'Setor',
            'ID Prestador',
            'Nome Prestador',
            'RG',
            'CPF',
            'ID Função',
            'Função',
            'Hr. Entrada',
            'Hr. Saída',
            'Hr. Extra',
            'Hr. Noturna',
            'Vl. Hora Fat.',
            'Vl. Hora Extra Fat.',
            'Vl. Hora Noturna Fat.',
            'Vl. Hora Fat. Menor',
            'Vl. Hora Extra Fat. Menor',
            'Vl. Hora Noturna Fat. Menor',
            'Total Horas Escala',
            'Valor Hora Total',
            'Total Faturamento',
        ];
    }

    public function map($dado): array
    {
        return [
            $dado->escala_id,
            \Carbon\Carbon::parse($dado->dt_servico)->format('d/m/Y'),
            $dado->cliente_id,
            $dado->cliente_fantasia,
            $dado->setor_id,
            $dado->setor_nome,
            $dado->cooperado_id,
            $dado->cooperado_nome,
            $dado->cooperado_rg ?? '',
            $dado->cooperado_cpf ?? '',
            $dado->funcao_id,
            $dado->funcao_nome,
            $dado->hr_entrada ? substr($dado->hr_entrada, 0, 5) : '',
            $dado->hr_saida ? substr($dado->hr_saida, 0, 5) : '',
            $dado->hr_extra_hours > 0 ? substr($dado->hr_extra, 0, 5) : '00:00',
            0, // hrNoturna (não disponível, ajustar conforme necessário)
            "R$ " . number_format($dado->valor_hora_faturamento, 2, ',', '.'),
            "R$ " . number_format($dado->valorHoraExtraFaturada, 2, ',', '.'), // Corrigido para valorHoraExtraFaturada
            "R$ 0,00", // vHrNoturnoFaturamento (não disponível, ajustar conforme necessário)
            "R$ 0,00", // vHrFaturamentoMenor (não disponível, ajustar conforme necessário)
            "R$ 0,00", // vHrExtraFaturamentoMenor (não disponível, ajustar conforme necessário)
            "R$ 0,00", // vHrNoturnoFaturamentoMenor (não disponível, ajustar conforme necessário)
            $dado->totalHorasEscala,
            "R$ " . number_format($dado->valorHoraTotal, 2, ',', '.'), // Valor Hora Total
            "R$ " . number_format($dado->totalFaturamento, 2, ',', '.'), // Total Faturamento
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Estilizar os headers
        $sheet->getStyle('A1:Y1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4A90E2'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Adicionar bordas a todas as células
        $sheet->getStyle('A1:Y' . ($this->dados->count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID Escala
            'B' => 12,  // Data Evento
            'C' => 10,  // ID Cliente
            'D' => 20,  // Nome Fantasia
            'E' => 10,  // ID Setor
            'F' => 20,  // Setor
            'G' => 12,  // ID Prestador
            'H' => 30,  // Nome Prestador
            'I' => 15,  // RG
            'J' => 15,  // CPF
            'K' => 10,  // ID Função
            'L' => 20,  // Função
            'M' => 12,  // Hr. Entrada
            'N' => 12,  // Hr. Saída
            'O' => 10,  // Hr. Extra
            'P' => 10,  // Hr. Noturna
            'Q' => 15,  // Vl. Hora Fat.
            'R' => 15,  // Vl. Hora Extra Fat.
            'S' => 15,  // Vl. Hora Noturna Fat.
            'T' => 15,  // Vl. Hora Fat. Menor
            'U' => 15,  // Vl. Hora Extra Fat. Menor
            'V' => 15,  // Vl. Hora Noturna Fat. Menor
            'W' => 15,  // Total Horas Escala
            'X' => 15,  // Valor Hora Total
            'Y' => 15,  // Total Faturamento
        ];
    }
}