<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SIMCard extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sim_card';

    protected $fillable = [
        'type',
        'access_token',
        'mobile_number',
    ];

    protected $hidden = [
        'access_token'
    ];

    public function station()
    {
        return $this->belongsTo(ObservationsStation::class, 'mobile_number', 'mobile_number');
    }

    public function topups()
    {
        return $this
            ->hasMany(GLabsLoad::class, 'sim_id');
    }

    public function latestTopup()
    {
        return $this
            ->hasOne(GLabsLoad::class, 'sim_id')->where('status', 'SUCCESS')->latest();
    }
}
