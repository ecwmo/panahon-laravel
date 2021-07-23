<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsObservationRaw extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'observations_observationraw';

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
        'timestamp',
    ];

    public function station() {
        return $this
            ->belongsTo(ObservationsStation::class);
    }
}
