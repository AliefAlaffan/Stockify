<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use App\Services\StockCalculatorService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $productsWithRelations = $this->productRepository->allWithRelations();
        $totalProducts = $productsWithRelations->count();

        $totalCategories = \App\Models\Category::count();
        $totalSuppliers  = \App\Models\Supplier::count();

        $allTransactions = $this->stockTransactionRepository->allWithRelations();
        $totalIncoming = $allTransactions->where('type', 'Masuk')->count();
        $totalOutgoing = $allTransactions->where('type', 'Keluar')->count();

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

        $topCategories = $productsWithRelations
            ->groupBy(fn($p) => $p->category->name ?? 'Tanpa Kategori')
            ->map(fn($group, $name) => ['name' => $name, 'count' => $group->count()])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        $lowStockCount = $this->stockCalculatorService->getLowStockProducts()->count();

        $topProducts = $allTransactions
            ->where('type', 'Keluar')
            ->where('status', 'Dikeluarkan')
            ->filter(fn($t) => $t->product !== null)
            ->groupBy('product_id')
            ->map(function ($group) {
                $product = $group->first()->product;
                return [
                    'name'      => $product->name ?? '-',
                    'sku'       => $product->sku ?? '-',
                    'total_out' => $group->sum('quantity'),
                ];
            })
            ->sortByDesc('total_out')
            ->take(5)
            ->values();

        $maxSold = $topProducts->max('total_out') ?: 1;

        $productsWithStock = $this->stockCalculatorService->getAllProductsWithStock();

        $totalInventoryValue = $productsWithStock->sum(function ($product) {
            return $product->current_stock * ($product->purchase_price ?? 0);
        });

        $supplierPerformance = $allTransactions
            ->where('type', 'Masuk')
            ->where('status', 'Diterima')
            ->filter(fn($t) => $t->product !== null && $t->product->supplier !== null)
            ->groupBy(fn($t) => $t->product->supplier->name)
            ->map(function ($group, $name) {
                return [
                    'name'              => $name,
                    'total_supplied'    => $group->sum('quantity'),
                    'transaction_count' => $group->count(),
                ];
            })
            ->sortByDesc('total_supplied')
            ->take(5)
            ->values();

        $maxSupplied = $supplierPerformance->max('total_supplied') ?: 1;

        return view('dashboard.admin', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalIncoming',
            'totalOutgoing',
            'chartData',
            'recentActivity',
            'topCategories',
            'lowStockCount',
            'topProducts',
            'maxSold',
            'totalInventoryValue',
            'supplierPerformance',
            'maxSupplied'
        ));
    }

    protected function manajerDashboard()
    {
        $lowStockProducts = $this->stockCalculatorService->getLowStockProducts();
        $totalAllProducts = $this->productRepository->all()->count();

        $today = Carbon::today()->format('Y-m-d');
        $allTransactions = $this->stockTransactionRepository->allWithRelations();

        $incomingToday = $allTransactions->filter(fn($t) => $t->type === 'Masuk' && Carbon::parse($t->date)->format('Y-m-d') === $today)->count();
        $outgoingToday = $allTransactions->filter(fn($t) => $t->type === 'Keluar' && Carbon::parse($t->date)->format('Y-m-d') === $today)->count();

        $recentTransactions = $allTransactions->sortByDesc('created_at')->take(5)->values();

        $pendingCount = $allTransactions->where('status', 'Pending')->count();

        return view('dashboard.manajer', compact(
            'lowStockProducts',
            'incomingToday',
            'outgoingToday',
            'totalAllProducts',
            'recentTransactions',
            'pendingCount'
        ));
    }

    protected function staffDashboard()
    {
        $pendingIncoming = $this->stockTransactionRepository->getPendingByType('Masuk');
        $pendingOutgoing = $this->stockTransactionRepository->getPendingByType('Keluar');

        $allTransactions = $this->stockTransactionRepository->allWithRelations();
        $completedToday = $allTransactions
            ->filter(fn($t) => $t->status !== 'Pending' && Carbon::parse($t->updated_at)->isToday())
            ->sortByDesc('updated_at')
            ->values();

        $totalTasksToday = $pendingIncoming->count() + $pendingOutgoing->count() + $completedToday->count();
        $completionRatio = $totalTasksToday > 0 ? round(($completedToday->count() / $totalTasksToday) * 100) : 100;

        return view('dashboard.staff', compact(
            'pendingIncoming',
            'pendingOutgoing',
            'completedToday',
            'completionRatio'
        ));
    }
}