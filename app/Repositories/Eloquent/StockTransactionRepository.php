<?php

namespace App\Repositories\Eloquent;

use App\Models\StockTransaction;
use App\Repositories\Contracts\StockTransactionRepositoryInterface;

class StockTransactionRepository extends BaseRepository implements StockTransactionRepositoryInterface
{
    public function __construct(StockTransaction $model)
    {
        parent::__construct($model);
    }

    public function getByProduct(int $productId)
    {
        return $this->model->where('product_id', $productId)->latest('date')->get();
    }

    public function getPendingByType(string $type)
    {
        return $this->model->with(['product', 'user'])
            ->where('type', $type)
            ->where('status', 'Pending')
            ->latest('date')
            ->get();
    }

    public function allWithRelations()
    {
        return $this->model->with(['product.supplier', 'product.category', 'user'])->get();
    }

    public function findWithRelations(int $id)
    {
        return $this->model->with(['product', 'user'])->findOrFail($id);
    }

    public function getStockIn(int $productId): int
    {
        return (int) $this->model
            ->where('product_id', $productId)
            ->where('type', 'Masuk')
            ->where('status', 'Diterima')
            ->sum('quantity');
    }

    public function getStockOut(int $productId): int
    {
        return (int) $this->model
            ->where('product_id', $productId)
            ->where('type', 'Keluar')
            ->where('status', 'Dikeluarkan')
            ->sum('quantity');
    }
}