<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'birth_date',
        'country',
        'address',
        'website',
        'social_media',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'social_media' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
