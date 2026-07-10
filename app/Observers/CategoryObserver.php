<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        ActivityLog::record($category, 'created', null, "Kategori \"{$category->name}\" dibuat.");
    }

    public function updated(Category $category): void
    {
        $changes = [];
        foreach ($category->getChanges() as $key => $newValue) {
            if ($key === 'updated_at') continue;
            $changes[$key] = [
                'from' => $category->getOriginal($key),
                'to'   => $newValue,
            ];
        }

        if (empty($changes)) return;

        ActivityLog::record($category, 'updated', $changes, "Kategori \"{$category->name}\" diperbarui.");
    }

    public function deleted(Category $category): void
    {
        ActivityLog::record($category, 'deleted', null, "Kategori \"{$category->name}\" dihapus.");
    }
}