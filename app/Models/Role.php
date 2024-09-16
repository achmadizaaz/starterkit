<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory, HasUlids;

    protected $fillable = ['id', 'name', 'is_admin', 'level', 'guard_name'];
    
    // Scope
    public function scopeFilter($query, array $filters){
    $query->when($filters['search'] ?? false, function($query, $search){
        return $query->where(function($query) use ($search) {
            // Cek apakah search mengandung 'admin' atau 'nonadmin'
            if (str_contains(strtolower($search), 'admin')) {
                // Jika mengandung 'admin', cek apakah pencarian adalah 'admin' atau 'nonadmin'
                    if (strtolower($search) == 'admin') {
                        $query->orWhere('is_admin', true);
                    } elseif (strtolower($search) == 'nonadmin' || 'non admin') {
                        $query->orWhere('is_admin', false);
                    }
                }
            })->orWhereAny(['name', 'level', 'created_at'], 'like', '%' . $search . '%');
    });
}
}
