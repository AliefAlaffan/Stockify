<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use App\Exports\TransactionReportExport;
use App\Exports\UserActivityExport;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN STOK
    |--------------------------------------------------------------------------
    */

    private function buildStockData(Request $request): array
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        $baseQuery = Product::with('category')
            ->when($request->category_id, fn ($q) => $q->where('category_id', $request->category_id));

        $allProducts = $baseQuery->get()->map(function ($product) use ($start, $end) {
            $product->period_in = StockTransaction::where('product_id', $product->id)
                ->where('type', 'Masuk')->where('status', 'Diterima')
                ->whereBetween('date', [$start, $end])->sum('quantity');

            $product->period_out = StockTransaction::where('product_id', $product->id)
                ->where('type', 'Keluar')->where('status', 'Dikeluarkan')
                ->whereBetween('date', [$start, $end])->sum('quantity');

            $totalIn = StockTransaction::where('product_id', $product->id)
                ->where('type', 'Masuk')->where('status', 'Diterima')->sum('quantity');
            $totalOut = StockTransaction::where('product_id', $product->id)
                ->where('type', 'Keluar')->where('status', 'Dikeluarkan')->sum('quantity');

            $product->current_stock = $totalIn - $totalOut;

            return $product;
        });

        $summary = [
            'total_products'  => $allProducts->count(),
            'total_units'     => $allProducts->sum('current_stock'),
            'total_value'     => $allProducts->sum(fn ($p) => $p->current_stock * $p->purchase_price),
            'low_stock_count' => $allProducts->filter(fn ($p) => $p->current_stock <= $p->minimum_stock)->count(),
        ];

        return [$allProducts, $summary];
    }

    public function stock(Request $request)
    {
        [$allProducts, $summary] = $this->buildStockData($request);

        // Paginasi manual dari collection yang sudah dihitung
        $page    = (int) $request->get('page', 1);
        $perPage = 15;

        $products = new LengthAwarePaginator(
            $allProducts->forPage($page, $perPage)->values(),
            $allProducts->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $categories = Category::all();

        return view('reports.stock', compact('products', 'summary', 'categories'));
    }

    public function stockExportPdf(Request $request)
    {
        [$products, $summary] = $this->buildStockData($request);

        $pdf = Pdf::loadView('reports.pdf.stock', compact('products', 'summary'));

        return $pdf->download('laporan-stok-' . now()->format('Y-m-d') . '.pdf');
    }

    public function stockExportExcel(Request $request)
    {
        [$products, $summary] = $this->buildStockData($request);

        return Excel::download(
            new StockReportExport($products),
            'laporan-stok-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN TRANSAKSI
    |--------------------------------------------------------------------------
    */

    private function buildTransactionQuery(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        return StockTransaction::with(['product', 'user'])
            ->whereBetween('date', [$start, $end])
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderByDesc('date');
    }

    public function transactions(Request $request)
    {
        $query = $this->buildTransactionQuery($request);

        $transactions = (clone $query)->paginate(15)->withQueryString();

        $summary = [
            'total_in'  => (clone $query)->where('type', 'Masuk')->sum('quantity'),
            'total_out' => (clone $query)->where('type', 'Keluar')->sum('quantity'),
            'pending'   => (clone $query)->where('status', 'Pending')->count(),
        ];

        return view('reports.transactions', compact('transactions', 'summary'));
    }

    public function transactionsExportPdf(Request $request)
    {
        $transactions = $this->buildTransactionQuery($request)->get();

        $pdf = Pdf::loadView('reports.pdf.transactions', compact('transactions'));

        return $pdf->download('laporan-transaksi-' . now()->format('Y-m-d') . '.pdf');
    }

    public function transactionsExportExcel(Request $request)
    {
        $transactions = $this->buildTransactionQuery($request)->get();

        return Excel::download(
            new TransactionReportExport($transactions),
            'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN AKTIVITAS PENGGUNA
    |--------------------------------------------------------------------------
    */

    private function buildActivityQuery(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        return StockTransaction::with(['product', 'user'])
            ->whereBetween('date', [$start, $end])
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->orderByDesc('created_at');
    }

    public function userActivity(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        $logActivities = \App\Models\ActivityLog::with('user')
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end)
        ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
        ->get()
        ->map(fn ($log) => (object) [
            'type'        => 'log',
            'action'      => $log->action,
            'description' => $log->description,
            'changes'     => $log->changes,   // <-- pastikan baris ini ada
            'user'        => $log->user,
            'created_at'  => $log->created_at,
        ]);

        $allActivities = $logActivities->sortByDesc('created_at')->values();

        $page = (int) $request->get('page', 1);
        $perPage = 20;

        $activities = new \Illuminate\Pagination\LengthAwarePaginator(
            $allActivities->forPage($page, $perPage)->values(),
            $allActivities->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $users = \App\Models\User::all();

        return view('reports.user-activity', compact('activities', 'users'));
    }

    public function userActivityExportPdf(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        $activities = \App\Models\ActivityLog::with('user')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('reports.pdf.user-activity', [
            'activities' => $activities,
            'startDate'  => $start,
            'endDate'    => $end,
        ]);

        return $pdf->download('laporan-aktivitas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function userActivityExportExcel(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->toDateString();

        $activities = \App\Models\ActivityLog::with('user')
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->orderByDesc('created_at')
            ->get();

        return Excel::download(
            new UserActivityExport($activities),
            'laporan-aktivitas-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    
}