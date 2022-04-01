<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservationsStationHealth extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'observations_stationhealth';

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
    'err_msg',
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
