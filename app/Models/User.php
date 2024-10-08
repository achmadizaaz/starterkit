<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids, HasRoles, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'image',
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'username'
            ]
        ];
    }

    // Scope
    public function scopeFilter($query, array $filters){
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where(function($query) use ($search) {
                // Cek apakah search mengandung 'active' atau 'nonactive'
                if (str_contains(strtolower($search), 'active')) {
                    // Jika mengandung 'active', cek apakah pencarian adalah 'active' atau 'nonactive'
                        if (strtolower($search) === 'active') {
                            // Jika pencarian adalah 'active', cari user yang aktif
                            $query->orWhere('is_active', true);
                        } elseif (strtolower($search) === 'nonactive' || strtolower($search) === 'non active') {
                            // Jika pencarian adalah 'nonactive' atau 'non active', cari user yang tidak aktif
                            $query->orWhere('is_active', false);
                        }
                    }else{
                        $query->whereAny(['username', 'name', 'email'], 'like', '%' . $search . '%');
                    }
                });
        });
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

}
