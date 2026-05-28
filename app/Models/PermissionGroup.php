<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'permission_groups';

    protected $fillable = ['id', 'name', 'sort_at'];

    protected $casts = [
        'sort_at' => 'integer',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
