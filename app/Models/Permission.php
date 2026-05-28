<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, HasUlids;

    protected $fillable = ['id', 'name', 'guard_name', 'permission_group_id'];

    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
        return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function permissionGroup(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}