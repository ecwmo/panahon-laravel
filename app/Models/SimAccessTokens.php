<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimAccessTokens extends Model
{
    use HasFactory;

    protected $table = 'sim_access_tokens';

    protected $primaryKey = 'access_token';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'access_token',
        'type',
        'mobile_number',
    ];

    protected $hidden = [
        'access_token'
    ];

    public function SIMCard()
    {
        return $this->belongsTo(SIMCard::class, 'mobile_number');
    }
}
