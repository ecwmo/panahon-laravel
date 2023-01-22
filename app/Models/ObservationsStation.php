<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class ObservationsStation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'lat',
        'lon',
        'elevation',
        'date_installed',
        'sms_system_type',
        'mobile_number',
        'station_type',
        'station_type2',
        'station_url',
        'status',
        'logger_version',
        'priority_level',
        'provider_id',
        'address',
        'province',
        'region',
    ];

    /**
      * The model's default values for attributes.
      *
      * @var array
      */
    protected $attributes = [
        'name' => null,
        'lat' => null,
        'lon' => null,
        'elevation' => null,
        'date_installed' => null,
        'mobile_number' => null,
        'station_type' => 'MO',
        'station_type2' => 'Default',
        'station_url' => null,
        'status' => 'INACTIVE',
        'address' => null,
        'province' => null,
        'region' => null,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'observations_station';

    public function observation()
    {
        return $this
            ->hasMany(ObservationsObservation::class, 'station_id', 'id');
    }

    public function latestObservation()
    {
        $startDate = Carbon::now()->addMinutes(10);
        $endDate = Carbon::now()->addMinutes(10);

        $obsModel = ObservationsObservation::class;
        if ($this->station_type == "MO") {
            $obsModel = ObservationsMOObservation::class;
        }
        return $this
            ->hasOne($obsModel, 'station_id', 'id')
            ->whereBetween(
                'timestamp',
                [
                    $startDate,
                    $endDate
                ]
            )
            ->latest('timestamp');
    }

    public function health()
    {
        return $this
            ->hasMany(ObservationsStationHealth::class, 'station_id', 'id');
    }

    public function SIMCard()
    {
        return $this
            ->hasOne(SIMCard::class, 'mobile_number', 'mobile_number');
    }
}
