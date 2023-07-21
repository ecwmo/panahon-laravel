<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsMOObservationRaw extends Model
{
    use HasFactory;

    protected $table = 'observations_mo_observationraw';

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
        'wdirx',
        'wspd',
        'wspdx',
        'srad',
        'rh',
        'rain',
        'wchill',
        'tx',
        'tn',
        'wrun',
        'hi',
        'thwi',
        'thswi',
        'senergy',
        'sradx',
        'uvi',
        'uvdose',
        'uvx',
        'hdd',
        'cdd',
        'et',
        'timestamp',
    ];

    public function station() {
        return $this
            ->belongsTo(ObservationsStation::class);
    }
}
