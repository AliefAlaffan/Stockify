<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function findBySku(string $sku)
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function lowStock()
    {
        // Sementara dikosongkan dulu, akan kita isi
        // di Fase 6 setelah logika stok dari stock_transactions siap.
        return collect();
    }

    public function allWithRelations()
    {
        return $this->model->with(['category', 'supplier'])->latest()->get();
    }

    public function findWithRelations(int $id)
    {
        return $this->model->with(['category', 'supplier', 'attributes'])->findOrFail($id);
    }
}