<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsObservation extends Model
{
    use HasFactory;

    protected $table = 'observations_observation';

    protected $dateFormat = 'Y-m-d H:i:s P';

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'station_id',
        'pres',
        'rr',
        'td',
        'temp',
        'wdir',
        'wspd',
        'wspdx',
        'srad',
        'rh',
        'wchill',
        'mslp',
        'hi',
        'timestamp',
        'qc_level',
    ];

    public function station() {
        return $this
            ->belongsTo(ObservationsStation::class);
    }
}
