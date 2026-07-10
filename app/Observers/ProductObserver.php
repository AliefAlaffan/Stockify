<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        ActivityLog::record($product, 'created', null, "Produk \"{$product->name}\" dibuat.");
    }

    public function updated(Product $product): void
    {
        $changes = [];
        foreach ($product->getChanges() as $key => $newValue) {
            if ($key === 'updated_at') continue;
            $changes[$key] = [
                'from' => $product->getOriginal($key),
                'to'   => $newValue,
            ];
        }

        if (empty($changes)) return;

        ActivityLog::record($product, 'updated', $changes, "Produk \"{$product->name}\" diperbarui.");
    }

    public function deleted(Product $product): void
    {
        ActivityLog::record($product, 'deleted', null, "Produk \"{$product->name}\" dihapus.");
    }
}