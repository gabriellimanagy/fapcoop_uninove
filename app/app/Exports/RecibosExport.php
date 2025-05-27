<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Financeiro;

class RecibosExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    protected $recibos;
    protected $password;

    public function __construct($recibos, $password = 'senha123')
    {
        $this->recibos = $recibos;
        $this->password = $password;
    }

    public function collection()
    {
        return $this->recibos;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'CPF',
            'Valor (R$)',
            'Chave PIX',
            'Tipo de Chave PIX',
        ];
    }

    public function map($recibo): array
    {
        // Busca o CPF do modelo CooperadoDocumento
        $cpf = $recibo['cooperado']->documentos->cpf ?? 'N/A';

        // Busca a chave PIX e o tipo de chave do modelo Financeiro
        $financeiro = Financeiro::where('cooperado_id', $recibo['cooperado_id'])->first();
        $pix = $financeiro->chave_pix ?? 'N/A';
        $pixTipoChave = $financeiro->pix_tipo_chave ?? 'N/A';

        return [
            $recibo['cooperado_id'],
            $recibo['cooperado']->nome ?? 'N/A',
            $cpf,
            $recibo['total_valor'], // O valor será formatado no Excel
            $pix,
            $pixTipoChave,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Estilizar o cabeçalho
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'], // Cor branca
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4A90E2'], // Cor azul
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Adicionar bordas a todas as células
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $event->sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Formatar a coluna de valor (D) como moeda com R$
                $event->sheet->getStyle('D2:D' . $highestRow)->getNumberFormat()
                    ->setFormatCode('"R$"#,##0.00');

                // Centralizar todas as colunas
                $event->sheet->getStyle('A1:F' . $highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Proteger a planilha com senha
                $protection = $event->sheet->getDelegate()->getProtection();
                $protection->setSheet(true); // Ativa a proteção da planilha
                $protection->setPassword($this->password); // Usa a senha passada pelo modal
                $protection->setSort(false);
                $protection->setInsertRows(false);
                $protection->setFormatCells(false);
            },
        ];
    }
}