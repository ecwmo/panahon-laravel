<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsObservation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'observations_observation';

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
