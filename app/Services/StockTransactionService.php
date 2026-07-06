<?php

namespace App\Services;

use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StockTransactionService
{
    protected StockTransactionRepositoryInterface $stockTransactionRepository;
    protected StockCalculatorService $stockCalculatorService;

    public function __construct(
        StockTransactionRepositoryInterface $stockTransactionRepository,
        StockCalculatorService $stockCalculatorService
    ) {
        $this->stockTransactionRepository = $stockTransactionRepository;
        $this->stockCalculatorService = $stockCalculatorService;
    }

    public function getIncomingTransactions()
    {
        return $this->stockTransactionRepository->allWithRelations()
            ->where('type', 'Masuk')
            ->values();
    }

    public function getOutgoingTransactions()
    {
        return $this->stockTransactionRepository->allWithRelations()
            ->where('type', 'Keluar')
            ->values();
    }

    public function getPendingIncoming()
    {
        return $this->stockTransactionRepository->getPendingByType('Masuk');
    }

    public function getPendingOutgoing()
    {
        return $this->stockTransactionRepository->getPendingByType('Keluar');
    }

    public function createIncoming(array $data)
    {
        $validated = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ])->validate();

        $validated['type'] = 'Masuk';
        $validated['status'] = 'Pending';
        $validated['user_id'] = Auth::id();

        return $this->stockTransactionRepository->create($validated);
    }

    public function createOutgoing(array $data)
    {
        $validated = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ])->validate();

        // Validasi stok cukup sebelum dicatat sebagai transaksi keluar
        $currentStock = $this->stockCalculatorService->getCurrentStock($validated['product_id']);
        if ($validated['quantity'] > $currentStock) {
            throw new \InvalidArgumentException("Stok tidak mencukupi. Stok saat ini: {$currentStock}");
        }

        $validated['type'] = 'Keluar';
        $validated['status'] = 'Pending';
        $validated['user_id'] = Auth::id();

        return $this->stockTransactionRepository->create($validated);
    }

    public function findById(int $id)
    {
        return $this->stockTransactionRepository->findWithRelations($id);
    }

    public function confirmIncoming(int $id, string $decision)
    {
        if (!in_array($decision, ['Diterima', 'Ditolak'])) {
            throw new \InvalidArgumentException('Keputusan tidak valid.');
        }

        $transaction = $this->stockTransactionRepository->find($id);

        if ($transaction->status !== 'Pending') {
            throw new \InvalidArgumentException('Transaksi ini sudah diproses sebelumnya.');
        }

        return $this->stockTransactionRepository->update($id, ['status' => $decision]);
    }

    public function confirmOutgoing(int $id)
    {
        $transaction = $this->stockTransactionRepository->find($id);

        if ($transaction->status !== 'Pending') {
            throw new \InvalidArgumentException('Transaksi ini sudah diproses sebelumnya.');
        }

        // Cek ulang stok saat konfirmasi (jaga-jaga jika ada transaksi lain yang mendahului)
        $currentStock = $this->stockCalculatorService->getCurrentStock($transaction->product_id);
        if ($transaction->quantity > $currentStock) {
            throw new \InvalidArgumentException("Stok tidak mencukupi untuk mengeluarkan barang ini. Stok saat ini: {$currentStock}");
        }

        return $this->stockTransactionRepository->update($id, ['status' => 'Dikeluarkan']);
    }
}