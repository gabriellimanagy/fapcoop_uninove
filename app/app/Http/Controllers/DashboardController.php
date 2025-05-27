<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cooperado;
use App\Models\Escala;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Count total members
        $totalCooperados = Cooperado::where('status', 'ativo')->count();

        // Count active members compared to last month
        $lastMonthCooperados = Cooperado::where('status', 'ativo')
            ->where('dt_cadastro', '<', Carbon::now()->subMonth())
            ->count();

        $cooperadosGrowth = $lastMonthCooperados > 0
            ? round((($totalCooperados - $lastMonthCooperados) / $lastMonthCooperados) * 100, 1)
            : 0;

        // Get monthly revenue - using a fixed value for now since valor_total column doesn't exist
        // You can replace this with actual calculation after adding the column
        $currentMonthRevenue = 0;
        $lastMonthRevenue = 0;

        // Alternative calculation based on services count (placeholder)
        $currentMonthServices = Servico::whereHas('escala', function($query) {
            $query->whereMonth('data_servico', Carbon::now()->month)
                  ->whereYear('data_servico', Carbon::now()->year);
        })->count();

        $estimatedRevenuePerService = 150; // Placeholder value
        $currentMonthRevenue = $currentMonthServices * $estimatedRevenuePerService;

        $lastMonthServices = Servico::whereHas('escala', function($query) {
            $query->whereMonth('data_servico', Carbon::now()->subMonth()->month)
                  ->whereYear('data_servico', Carbon::now()->subMonth()->year);
        })->count();

        $lastMonthRevenue = $lastMonthServices * $estimatedRevenuePerService;

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        // Count total transactions (services)
        $currentMonthTransactions = Servico::whereHas('escala', function($query) {
            $query->whereMonth('data_servico', Carbon::now()->month)
                  ->whereYear('data_servico', Carbon::now()->year);
        })->count();

        $lastMonthTransactions = Servico::whereHas('escala', function($query) {
            $query->whereMonth('data_servico', Carbon::now()->subMonth()->month)
                  ->whereYear('data_servico', Carbon::now()->subMonth()->year);
        })->count();

        $transactionsGrowth = $lastMonthTransactions > 0
            ? round((($currentMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100, 1)
            : 0;

        // Recent members
        $recentCooperados = Cooperado::with(['dadosPessoais', 'financeiro'])
            ->where('status', 'ativo')
            ->orderBy('dt_cadastro', 'desc')
            ->limit(5)
            ->get();

        // Upcoming schedules - fixed query
        $upcomingEscalas = Escala::with(['cliente', 'setor', 'servicos'])
            ->where('data_servico', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('data_servico', 'asc')
            ->limit(5)
            ->get();

        // Active clients count
        $activeClientes = Cliente::count();

        return view('dashboard', compact(
            'totalCooperados',
            'cooperadosGrowth',
            'currentMonthRevenue',
            'revenueGrowth',
            'currentMonthTransactions',
            'transactionsGrowth',
            'recentCooperados',
            'upcomingEscalas',
            'activeClientes'
        ));
    }
}
