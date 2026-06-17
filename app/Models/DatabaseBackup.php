<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatabaseBackup extends Model
{
    protected $fillable = [
        'user_id',
        'filename',
        'disk',
        'path',
        'size',
        'connection',
        'status',
        'notes',
        'encrypted_at',
        'restored_at',
        'restored_by',
    ];

    protected function casts(): array
    {
        return [
            'encrypted_at' => 'datetime',
            'restored_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restored_by');
    }
}
