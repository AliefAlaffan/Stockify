<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use App\Services\StockCalculatorService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected ProductRepositoryInterface $productRepository;
    protected StockTransactionRepositoryInterface $stockTransactionRepository;
    protected StockCalculatorService $stockCalculatorService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockTransactionRepositoryInterface $stockTransactionRepository,
        StockCalculatorService $stockCalculatorService
    ) {
        $this->productRepository = $productRepository;
        $this->stockTransactionRepository = $stockTransactionRepository;
        $this->stockCalculatorService = $stockCalculatorService;
    }

    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'Admin' => $this->adminDashboard(),
            'Manajer Gudang' => $this->manajerDashboard(),
            'Staff Gudang' => $this->staffDashboard(),
            default => view('dashboard.default'),
        };
    }

    protected function adminDashboard()
    {
        $totalProducts = $this->productRepository->all()->count();

        $allTransactions = $this->stockTransactionRepository->allWithRelations();

        $totalIncoming = $allTransactions->where('type', 'Masuk')->count();
        $totalOutgoing = $allTransactions->where('type', 'Keluar')->count();

        // Grafik stok 7 hari terakhir (jumlah transaksi masuk vs keluar per hari)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $chartData[] = [
                'date' => Carbon::now()->subDays($i)->format('d M'),
                'masuk' => $allTransactions->where('type', 'Masuk')->filter(fn($t) => Carbon::parse($t->date)->format('Y-m-d') === $date)->sum('quantity'),
                'keluar' => $allTransactions->where('type', 'Keluar')->filter(fn($t) => Carbon::parse($t->date)->format('Y-m-d') === $date)->sum('quantity'),
            ];
        }

        $recentActivity = $allTransactions->sortByDesc('created_at')->take(8)->values();

        return view('dashboard.admin', compact(
            'totalProducts',
            'totalIncoming',
            'totalOutgoing',
            'chartData',
            'recentActivity'
        ));
    }

    protected function manajerDashboard()
    {
        $lowStockProducts = $this->stockCalculatorService->getLowStockProducts();

        $today = Carbon::today()->format('Y-m-d');
        $allTransactions = $this->stockTransactionRepository->allWithRelations();

        $incomingToday = $allTransactions->filter(fn($t) => $t->type === 'Masuk' && Carbon::parse($t->date)->format('Y-m-d') === $today)->count();
        $outgoingToday = $allTransactions->filter(fn($t) => $t->type === 'Keluar' && Carbon::parse($t->date)->format('Y-m-d') === $today)->count();

        return view('dashboard.manajer', compact('lowStockProducts', 'incomingToday', 'outgoingToday'));
    }

    protected function staffDashboard()
    {
        $pendingIncoming = $this->stockTransactionRepository->getPendingByType('Masuk');
        $pendingOutgoing = $this->stockTransactionRepository->getPendingByType('Keluar');

        return view('dashboard.staff', compact('pendingIncoming', 'pendingOutgoing'));
    }
}