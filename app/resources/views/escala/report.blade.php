<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Escala</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
        body {
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            background: #fff;
            padding: 15px;
            counter-reset: page-counter;
        }
        .container { width: 100%; max-width: 100%; }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
        }
        .header-left {
            width: 30%;
            text-align: center;
        }
        .header-left img {
            width: auto;
            height: 100px;
            margin: 0 auto;
            display: block;
        }
        .header-left .placeholder {
            width: 150px;
            height: 100px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #777;
            margin: 0 auto;
            border-radius: 5px;
        }
        .header-center {
            width: 60%;
            text-align: center;
            padding: 0 15px;
        }
        .header-center h3 {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header-center p {
            font-size: 12px;
            color: #555;
            margin: 2px 0;
        }
        .header-right {
            width: 20%;
            text-align: right;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #eaeaea;
        }
        .header-right p {
            font-size: 12px;
            margin: 5px 0;
            display: flex;
            justify-content: flex-end;
        }
        .header-right span {
            font-weight: bold;
            margin-right: 5px;
            min-width: 100px;
            text-align: left;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .info-column {
            width: 48%;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-item {
            font-size: 12px;
            color: #333;
            margin-bottom: 3px;
        }
        .info-item span {
            font-weight: bold;
            color: #2c3e50;
            margin-right: 5px;
        }

        /* Title */
        .title {
            text-align: center;
            margin: 25px 0;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            padding: 10px;
            background: #2c3e50;
            border-radius: 6px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        th { background: #f2f2f2; font-weight: bold; color: #2c3e50; text-transform: uppercase; letter-spacing: 0.5px; }
        /* Ajustando larguras específicas para as colunas */
        table th:nth-child(1), table td:nth-child(1) { width: 20%; } /* Cooperado */
        table th:nth-child(2), table td:nth-child(2) { width: 10%; } /* CPF */
        table th:nth-child(3), table td:nth-child(3) { width: 15%; } /* Função */
        table th:nth-child(4), table td:nth-child(4) { width: 10%; } /* Data */
        table th:nth-child(5), table td:nth-child(5),
        table th:nth-child(6), table td:nth-child(6),
        table th:nth-child(7), table td:nth-child(7) { width: 8%; } /* Horários */
        table th:nth-child(8), table td:nth-child(8) { width: 21%; height: 40px; } /* Assinatura - ajustada para 21% */
        td { vertical-align: middle; }
        tr:nth-child(even) { background: #fafafa; }
        tr:hover { background: #f5f5f5; }

        /* Date Header */
        .date-header {
            margin: 15px 0;
            background: #e9ecef;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            color: #2c3e50;
        }

        /* Summary */
        .summary {
            margin: 25px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        .summary-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 12px;
            color: #2c3e50;
        }
        .summary-content {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .summary-content div {
            padding: 6px 12px;
            background: #fff;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Signature */
        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .signature-box {
            width: 280px;
            text-align: center;
        }
        .signature-box label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            background: #f2f2f2;
            padding: 5px;
            border-radius: 4px;
            color: #2c3e50;
        }
        .signature-line {
            width: 100%;
            border-top: 2px solid #333;
            margin-top: 25px;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
        }
        .page-counter {
            counter-increment: page-counter;
        }
        .page-number::after {
            content: "Página " counter(page-counter) " de " attr(data-total-pages);
        }
        .strong { font-weight: bold; }
        .page-break { page-break-after: always; }

        @media print {
            .footer {
                position: fixed;
                bottom: 0;
            }
            .page-counter {
                display: block;
                position: running(pageNumber);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                @php
                    $logoPath = public_path('img/logopng.png');
                    $logoExists = file_exists($logoPath);
                @endphp

                @if($logoExists)
                    <img src="file://{{ $logoPath }}" alt="Logo FAPCOOP">
                @else
                    <div class="placeholder">Logo FAPCOOP</div>
                @endif
            </div>
        </div>

        <div class="info-section">
            <div class="info-column">
                <div class="info-row">
                    <div class="info-item"><span>Dt. Solicitação:</span> {{ $escala->data_solicitacao instanceof \DateTime ? $escala->data_solicitacao->format('d/m/Y') : date('d/m/Y', strtotime($escala->data_solicitacao ?? now())) }}</div>
                    <div class="info-item"><span>Dt. Evento:</span> {{ $escala->data_servico instanceof \DateTime ? $escala->data_servico->format('d/m/Y') : date('d/m/Y', strtotime($escala->data_servico ?? now())) }}</div>
                    <div class="info-item"><span>Nome do Evento:</span> {{ $escala->nome_evento ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="info-column">
                <div class="info-row">
                    <div class="info-item"><span>Cliente:</span> {{ $escala->cliente ? $escala->cliente->razao_social : 'N/A' }}</div>
                    <div class="info-item"><span>CNPJ:</span> {{ $escala->cliente ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $escala->cliente->documento ?? 'N/A') : 'N/A' }}</div>
                    <div class="info-item"><span>Endereço:</span> {{ $escala->cliente ? $escala->cliente->endereco : 'N/A' }}</div>
                    <div class="info-item"><span>Setor:</span> {{ $escala->setor ? $escala->setor->nome : 'N/A' }}</div>
                    <div class="info-item"><span>Nº Solicitação:</span> {{ $escala->id }}</div>
                </div>
            </div>
        </div>

        <div class="title">RELATÓRIO DE ESCALA DE SERVIÇO</div>

        @php
            $servicosPorData = $escala->servicos->sortBy('dt_servico')->groupBy(function($servico) {
                return $servico->dt_servico instanceof \DateTime ?
                    $servico->dt_servico->format('Y-m-d') :
                    date('Y-m-d', strtotime($servico->dt_servico ?? now()));
            });

            $totalPages = count($servicosPorData);
        @endphp

        @foreach($servicosPorData as $data => $servicosDoDia)
            <div class="page-counter"></div>
            <div class="date-header">
                Data: {{ date('d/m/Y', strtotime($data)) }}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Cooperado</th>
                        <th>CPF</th>
                        <th>Função</th>
                        <th>Dt. Serviço</th>
                        <th>Hr Entrada</th>
                        <th>Hr Saída</th>
                        <th>Hr Extra</th>
                        <th>Assinatura</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($servicosDoDia as $servico)
                        <tr>
                            <td>{{ $servico->cooperado ? $servico->cooperado->nome : 'N/A' }}</td>
                            <td>{{ $servico->cooperado && isset($servico->cooperado->documentos) ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $servico->cooperado->documentos->cpf ?? 'N/A') : 'N/A' }}</td>
                            <td>{{ $servico->funcao ? $servico->funcao->nome : 'N/A' }}</td>
                            <td>{{ $servico->dt_servico instanceof \DateTime ? $servico->dt_servico->format('d/m/Y') : date('d/m/Y', strtotime($servico->dt_servico ?? now())) }}</td>
                            <td>{{ date('H:i', strtotime($servico->hr_entrada)) }}</td>
                            <td>{{ date('H:i', strtotime($servico->hr_saida)) }}</td>
                            <td>{{ isset($servico->hr_extra) ? date('H:i', strtotime($servico->hr_extra)) : '00:00' }}</td>
                            <td style="height: 40px;"></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align: center; color: #777;">Nenhum serviço registrado</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="summary">
                <div class="summary-title">Resumo de Funções do Dia {{ date('d/m/Y', strtotime($data)) }}</div>
                <div class="summary-content">
                    @foreach ($servicosDoDia->groupBy(function($s) { return optional($s->funcao)->nome ?? 'Não especificada'; }) as $nome => $grupo)
                        <div><span class="strong">{{ $nome }}:</span> {{ $grupo->count() }}</div>
                    @endforeach
                </div>
            </div>

            <div class="signature-area">
                <div class="signature-box">
                    <label>Responsável FAPCOOP</label>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-box">
                    <label>Responsável Cliente</label>
                    <div class="signature-line"></div>
                </div>
            </div>

            <div class="footer">
                Relatório Oficial FAPCOOP - {{ now()->format('d/m/Y H:i:s') }} -
                <span class="page-number" data-total-pages="{{ $totalPages }}"></span>
            </div>

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalPages = {{ $totalPages }};
            const pageNumbers = document.querySelectorAll('.page-number');

            pageNumbers.forEach((element, index) => {
                element.setAttribute('data-total-pages', totalPages);
            });
        });
    </script>
</body>
</html>
