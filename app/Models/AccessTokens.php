<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessTokens extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_token',
        'type',
    ];

    protected $hidden = [
        'access_token'
    ];

    public function SIMCard()
    {
        return $this->belongsTo(SIMCard::class, 'sim_id');
    }
}
