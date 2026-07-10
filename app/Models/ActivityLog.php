<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['subject_type', 'subject_id', 'user_id', 'action', 'changes', 'description'];

    protected $casts = ['changes' => 'array'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(Model $subject, string $action, ?array $changes = null, ?string $description = null): void
    {
        static::create([
            'subject_type' => get_class($subject),
            'subject_id'   => $subject->id,
            'user_id'      => auth()->id(),
            'action'       => $action,
            'changes'      => $changes,
            'description'  => $description,
        ]);
    }
}