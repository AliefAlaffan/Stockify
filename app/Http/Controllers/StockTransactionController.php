<?php

namespace App\Http\Controllers;

use App\Services\StockTransactionService;
use App\Services\StockCalculatorService;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    protected StockTransactionService $stockTransactionService;
    protected StockCalculatorService $stockCalculatorService;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        StockTransactionService $stockTransactionService,
        StockCalculatorService $stockCalculatorService,
        ProductRepositoryInterface $productRepository
    ) {
        $this->stockTransactionService = $stockTransactionService;
        $this->stockCalculatorService = $stockCalculatorService;
        $this->productRepository = $productRepository;
    }

    // Barang Masuk
    public function indexIn()
    {
        $transactions = $this->stockTransactionService->getIncomingTransactions();
        return view('stock-transactions.in.index', compact('transactions'));
    }

    public function createIn()
    {
        $products = $this->productRepository->all();
        return view('stock-transactions.in.create', compact('products'));
    }

    public function storeIn(Request $request)
    {
        $this->stockTransactionService->createIncoming($request->all());
        return redirect()->route('stock-transactions.in.index')->with('success', 'Transaksi barang masuk berhasil dicatat, menunggu konfirmasi Staff Gudang.');
    }

    // Barang Keluar
    public function indexOut()
    {
        $transactions = $this->stockTransactionService->getOutgoingTransactions();
        return view('stock-transactions.out.index', compact('transactions'));
    }

    public function createOut()
    {
        $products = $this->stockCalculatorService->getAllProductsWithStock();
        return view('stock-transactions.out.create', compact('products'));
    }

    public function storeOut(Request $request)
    {
        try {
            $this->stockTransactionService->createOutgoing($request->all());
            return redirect()->route('stock-transactions.out.index')->with('success', 'Transaksi barang keluar berhasil dicatat, menunggu konfirmasi Staff Gudang.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Konfirmasi (Staff Gudang)
    public function pendingIncoming()
    {
        $transactions = $this->stockTransactionService->getPendingIncoming();
        return view('stock-transactions.confirm.incoming', compact('transactions'));
    }

    public function pendingOutgoing()
    {
        $transactions = $this->stockTransactionService->getPendingOutgoing();
        return view('stock-transactions.confirm.outgoing', compact('transactions'));
    }

    public function confirmIncoming(Request $request, int $id)
    {
        try {
            $this->stockTransactionService->confirmIncoming($id, $request->input('decision'));
            return redirect()->route('stock-transactions.confirm.incoming')->with('success', 'Transaksi berhasil diproses.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmOutgoing(int $id)
    {
        try {
            $this->stockTransactionService->confirmOutgoing($id);
            return redirect()->route('stock-transactions.confirm.outgoing')->with('success', 'Barang berhasil dikeluarkan.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}