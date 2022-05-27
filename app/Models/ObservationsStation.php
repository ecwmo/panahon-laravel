<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ObservationsStation extends Model
{
    use HasFactory;

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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'observations_station';

    public function observationRaw()
    {
        return $this
            ->hasMany(ObservationsObservationRaw::class, 'station_id', 'id');
    }

    public function observation()
    {
        return $this
            ->hasMany(ObservationsObservation::class, 'station_id', 'id');
    }

    public function latestObservationRaw()
    {
        $startDate = Carbon::now()->addMinutes(10);
        $endDate = Carbon::now()->addMinutes(10);

        $obsModel = ObservationsObservationRaw::class;
        if ($this->station_type == "MO") {
            $obsModel = ObservationsMOObservationRaw::class;
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

    public function glabs_subscription()
    {
        return $this
            ->hasOne(GLabs::class, 'mobile_number', 'mobile_number');
    }
}
