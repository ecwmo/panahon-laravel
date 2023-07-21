<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsStationHealth extends Model
{
    use HasFactory;

    protected $table = 'observations_stationhealth';

    protected $dateFormat = 'Y-m-d H:i:s P';

    protected $casts = [
        'timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
    'station_id',
    'vb1',
    'vb2',
    'curr',
    'bp1',
    'bp2',
    'cm',
    'ss',
    'temp_arq',
    'rh_arq',
    'fpm',
    'error_msg',
    'message',
    'data_count',
    'data_status',
    'minutes_difference',
    'timestamp',
  ];

    public function station()
    {
        return $this
      ->belongsTo(ObservationsStation::class);
    }
}
