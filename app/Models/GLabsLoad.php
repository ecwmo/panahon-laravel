<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLabsLoad extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'glabs_load';

    protected $fillable = [
        'status',
        'promo',
        'transaction_id'
    ];

    public function subscription()
    {
        return $this->belongsTo(GLabs::class);
    }
}
