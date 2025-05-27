<?php
namespace App\Services;

use FPDF;

class CustomFPDF extends FPDF
{
    protected $dataInicio;
    protected $dataFim;
    protected $clienteId;
    protected $funcaoId;
    protected $setorId;
    protected $lote;
    protected $agrupar;
    protected $clientes;
    protected $funcoes;
    protected $setores;

    public function __construct($dataInicio, $dataFim, $clienteId, $funcaoId, $setorId, $lote, $agrupar, $clientes, $funcoes, $setores)
    {
        parent::__construct('L', 'mm', 'A4'); // Modo paisagem, A4
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->clienteId = $clienteId;
        $this->funcaoId = $funcaoId;
        $this->setorId = $setorId;
        $this->lote = $lote;
        $this->agrupar = $agrupar;
        $this->clientes = $clientes;
        $this->funcoes = $funcoes;
        $this->setores = $setores;
    }

    // Cabeçalho (Header)
    function Header()
    {
        // Título
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Relatorio de Faturamento', 0, 1, 'C');
        $this->Ln(5);

        // Filtros aplicados
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'Filtros Aplicados:', 0, 1, 'L');

        // Período
        $periodo = "Periodo: " . ($this->dataInicio ? \Carbon\Carbon::parse($this->dataInicio)->format('d/m/Y') : 'N/A') . " a " .
                   ($this->dataFim ? \Carbon\Carbon::parse($this->dataFim)->format('d/m/Y') : 'N/A');
        $this->Cell(0, 6, $periodo, 0, 1, 'L');

        // Cliente
        $clienteNome = "Cliente: Todos";
        if ($this->clienteId) {
            $cliente = $this->clientes->firstWhere('id', $this->clienteId);
            $clienteNome = "Cliente: " . ($cliente ? $cliente->nome : 'N/A');
        }
        $this->Cell(0, 6, $clienteNome, 0, 1, 'L');

        // Setor
        $setorNome = "Setor: Todos";
        if ($this->setorId) {
            $setor = $this->setores->firstWhere('id', $this->setorId);
            $setorNome = "Setor: " . ($setor ? $setor->nome : 'N/A');
        }
        $this->Cell(0, 6, $setorNome, 0, 1, 'L');

        // Função
        $funcaoNome = "Funcao: Todos";
        if ($this->funcaoId) {
            $funcao = $this->funcoes->firstWhere('id', $this->funcaoId);
            $funcaoNome = "Funcao: " . ($funcao ? $funcao->nome : 'N/A');
        }
        $this->Cell(0, 6, $funcaoNome, 0, 1, 'L');

        // Lote
        $loteInfo = "Lote: " . ($this->lote ?: 'Todos');
        $this->Cell(0, 6, $loteInfo, 0, 1, 'L');

        // Agrupamento
        $agruparInfo = "Agrupado por: " . ($this->agrupar == 'data' ? 'Data' : 'Funcao');
        $this->Cell(0, 6, $agruparInfo, 0, 1, 'L');

        $this->Ln(5);

        // Cabeçalho da tabela
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 8, 'ID Escala', 1);
        $this->Cell(20, 8, 'Data', 1);
        $this->Cell(35, 8, 'Cliente', 1);
        $this->Cell(25, 8, 'Setor', 1);
        $this->Cell(35, 8, 'Prestador', 1);
        $this->Cell(25, 8, 'Funcao', 1);
        $this->Cell(20, 8, 'Hr. Entrada', 1);
        $this->Cell(20, 8, 'Hr. Saida', 1);
        $this->Cell(20, 8, 'Hr. Extra', 1);
        $this->Cell(20, 8, 'Qtd. Horas', 1);
        $this->Cell(25, 8, 'Valor/Hora Fat.', 1);
        $this->Ln();
    }

    // Rodapé (Footer)
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Gerado em: ' . now()->format('d/m/Y H:i:s'), 0, 0, 'L');
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}