<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLabsLoad extends Model
{
    use HasFactory;

    protected $table = 'glabs_load';

    protected $dateFormat = 'Y-m-d H:i:s P';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'mobile_number',
        'status',
        'promo',
        'transaction_id',
    ];

    public function SIMCard()
    {
        return $this->belongsTo(SIMCard::class, 'mobile_number');
    }
}
