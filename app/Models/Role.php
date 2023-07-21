<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s P';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this
            ->belongsToMany(User::class)
            ->withTimestamps();
    }
}
