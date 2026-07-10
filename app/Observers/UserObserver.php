<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        ActivityLog::record($user, 'created', null, "Pengguna \"{$user->name}\" ({$user->role}) ditambahkan.");
    }

    public function updated(User $user): void
    {
        $changes = [];
       foreach ($user->getChanges() as $key => $newValue) {
            if (in_array($key, ['updated_at', 'password', 'remember_token'])) continue;
            $changes[$key] = [
                'from' => $user->getOriginal($key),
                'to'   => $newValue,
            ];
        }

        if (empty($changes)) return;

        ActivityLog::record($user, 'updated', $changes, "Pengguna \"{$user->name}\" diperbarui.");
    }

    public function deleted(User $user): void
    {
        ActivityLog::record($user, 'deleted', null, "Pengguna \"{$user->name}\" dihapus.");
    }
}