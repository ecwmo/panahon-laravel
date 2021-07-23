<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ObservationsStation;

use App\Http\Controllers\Controller;

class ObservationsStationController extends Controller
{
    public function index()
    {
        return ObservationsStation::paginate();
    }

    public function show($id)
    {
        return ObservationsStation::find($id);
    }

    public function fetchObservations($id)
    {
        if ($id == "latest") {
            return ObservationsStation::has('latestObservation')->get()->map(function ($st) {
                return [
                    "name" => $st->name,
                    "lat" => $st->lat,
                    "lon" => $st->lon,
                    "rain" => $st->latestObservation->rain,
                    "temp" => $st->latestObservation->temp,
                    "tx" => $st->latestObservation->tx,
                    "tn" => $st->latestObservation->tn,
                    "wspd" => $st->latestObservation->wspd,
                    "wdir" => $st->latestObservation->wdir,
                    "pres" => $st->latestObservation->pres,
                ];
            });
        }
        return ObservationsStation::find($id)->observationRaw;
    }
}
