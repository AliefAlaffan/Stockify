<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\StockTransaction;

class StockTransactionObserver
{
    public function created(StockTransaction $trx): void
    {
        $product = $trx->product->name ?? 'produk';
        $isOpname = str_starts_with($trx->notes ?? '', 'Stock Opname:');

        if ($isOpname) {
            $arah = $trx->type === 'Masuk' ? 'penambahan' : 'pengurangan';
            ActivityLog::record(
                $trx,
                'stock_opname',
                ['quantity' => $trx->quantity, 'type' => $trx->type],
                "melakukan stock opname pada \"{$product}\": {$arah} {$trx->quantity} unit. {$trx->notes}"
            );
            return;
        }

        $verb = $trx->type === 'Masuk' ? 'mencatat permintaan barang masuk' : 'mencatat permintaan barang keluar';

        ActivityLog::record($trx, 'created', null, "{$verb}: {$product} sebanyak {$trx->quantity} unit.");
    }

    public function updated(StockTransaction $trx): void
    {
        if (!$trx->isDirty('status')) return;

        $product = $trx->product->name ?? 'produk';
        $status  = $trx->status;

        $description = match ($status) {
            'Diterima'    => "mengonfirmasi barang masuk: {$product} ({$trx->quantity} unit) diterima.",
            'Dikeluarkan' => "mengonfirmasi barang keluar: {$product} ({$trx->quantity} unit) telah dikeluarkan.",
            'Ditolak'     => "menolak barang masuk: {$product} ({$trx->quantity} unit).",
            default       => "memperbarui status transaksi {$product} menjadi {$status}.",
        };

        ActivityLog::record($trx, 'updated', ['status' => ['from' => $trx->getOriginal('status'), 'to' => $status]], $description);
    }
}