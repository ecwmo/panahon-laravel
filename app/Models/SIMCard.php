<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SIMCard extends Model
{
    use HasFactory;


    protected $table = 'sim_cards';

    protected $primaryKey = 'mobile_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'mobile_number',
        'type',
    ];

    public function station()
    {
        return $this->belongsTo(ObservationsStation::class, 'mobile_number', 'mobile_number');
    }

    public function topups()
    {
        return $this
            ->hasMany(GLabsLoad::class, 'mobile_number');
    }

    public function latestTopup()
    {
        return $this
            ->hasOne(GLabsLoad::class, 'mobile_number')
            ->ofMany(['created_at' => 'max'], function ($query) {
                $query->where('status', 'SUCCESS');
            });
    }

    public function accessTokens()
    {
        return $this
            ->hasMany(SimAccessTokens::class, 'mobile_number');
    }
}
