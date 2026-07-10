<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Supplier;

class SupplierObserver
{
    public function created(Supplier $supplier): void
    {
        ActivityLog::record($supplier, 'created', null, "Supplier \"{$supplier->name}\" ditambahkan.");
    }

    public function updated(Supplier $supplier): void
    {
        $changes = [];
        foreach ($supplier->getChanges() as $key => $newValue) {
            if ($key === 'updated_at') continue;
            $changes[$key] = [
                'from' => $supplier->getOriginal($key),
                'to'   => $newValue,
            ];
        }

        if (empty($changes)) return;

        ActivityLog::record($supplier, 'updated', $changes, "Supplier \"{$supplier->name}\" diperbarui.");
    }

    public function deleted(Supplier $supplier): void
    {
        ActivityLog::record($supplier, 'deleted', null, "Supplier \"{$supplier->name}\" dihapus.");
    }
}