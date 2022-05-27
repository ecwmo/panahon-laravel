<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ObservationsStation;

use App\Http\Controllers\Controller;

class ObservationsStationController extends Controller
{
    public function index(Request $request)
    {
        return  ObservationsStation::where([
          ['name', '!=', null],
          [function ($query) use ($request) {
              if ($q = $request->q) {
                  $query->orWhere('name', 'LIKE', '%' . $q . '%')
                ->orWhere('address', 'LIKE', '%' . $q . '%')
                ->orWhere('mobile_number', 'LIKE', '%' . $q . '%')
                ->get();
              }
          }]
        ])
          ->orderBy('id', 'asc')
          ->paginate(15);
    }

    public function show(ObservationsStation $station)
    {
        return $station;
    }

    /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request)
    {
        $request->validate([
      'name' => 'required|max:200',
      'lon' => 'numeric|nullable',
      'lat' => 'numeric|nullable',
      'elevation' => 'numeric|nullable',
      'mobile_number' => 'regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number',
      'date_installed' => 'nullable|date_format:Y-m-d',
      'address' => 'max:255|nullable',
      'province' => 'max:255|nullable',
      'region' => 'max:255|nullable',
    ]);

        $station = ObservationsStation::create($request->all());
        return $station;
    }

    /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ObservationsStation  $station
   * @return \Illuminate\Http\Response
   */
    public function update(Request $request, ObservationsStation $station)
    {
        $request->validate([
            'name' => 'required|max:200',
            'lon' => 'numeric|nullable',
            'lat' => 'numeric|nullable',
            'elevation' => 'numeric|nullable',
            'mobile_number' => 'regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number,' . $station->id,
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $station->update($request->all());

        return $station;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObservationsStation  $station
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObservationsStation $station)
    {
        $station->delete();

        return $station;
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

    public function fetchLogs(Request $request, $id)
    {
        $station = ObservationsStation::find($id);
        $logs = $station->health()->orderBy('timestamp', 'DESC')->paginate(20, array('timestamp', 'message'));
        return $logs;
    }
}
