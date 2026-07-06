<?php

namespace App\Services;

use App\Repositories\Contracts\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StockOpnameService
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

    public function getOpnameOverview()
    {
        return $this->stockCalculatorService->getAllProductsWithStock();
    }

    public function processOpname(array $data)
    {
        $validated = Validator::make($data, [
            'product_id' => 'required|exists:products,id',
            'physical_count' => 'required|integer|min:0',
            'date' => 'required|date',
        ])->validate();

        $systemStock = $this->stockCalculatorService->getCurrentStock($validated['product_id']);
        $physicalCount = (int) $validated['physical_count'];
        $difference = $physicalCount - $systemStock;

        if ($difference === 0) {
            return null; // tidak ada penyesuaian diperlukan
        }

        if ($difference > 0) {
            return $this->stockTransactionRepository->create([
                'product_id' => $validated['product_id'],
                'user_id' => Auth::id(),
                'type' => 'Masuk',
                'quantity' => $difference,
                'date' => $validated['date'],
                'status' => 'Diterima',
                'notes' => "Stock Opname: penyesuaian +{$difference} (sistem: {$systemStock}, fisik: {$physicalCount})",
            ]);
        }

        $absDifference = abs($difference);

        return $this->stockTransactionRepository->create([
            'product_id' => $validated['product_id'],
            'user_id' => Auth::id(),
            'type' => 'Keluar',
            'quantity' => $absDifference,
            'date' => $validated['date'],
            'status' => 'Dikeluarkan',
            'notes' => "Stock Opname: penyesuaian -{$absDifference} (sistem: {$systemStock}, fisik: {$physicalCount})",
        ]);
    }
}