<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\ObservationsStation;

use Illuminate\Http\Request;

class ObservationsStationController extends Controller
{
    public function index(Request $request)
    {
        $stations = ObservationsStation::where([
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

        foreach ($stations as $station) {
            $station->status_url = route('stations.index').'/'.$station->id.'/logs';
        }
        return Inertia::render('stations', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('station.form', []);
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
            'mobile_number' => 'exclude_unless:station_type,SMS|regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number',
            'date_installed' => 'nullable|date_format:Y-m-d',
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $station = ObservationsStation::create($request->all());
        return redirect()->route('stations.show', $station)->with('message', __('Station created successfully.'));
    }


    /**
    * Display the specified resource.
    *
    * @param  \App\Models\ObservationsStation  $station
    * @return \Illuminate\Http\Response
    */
    public function show(ObservationsStation $station)
    {
        return Inertia::render('station.form', compact('station'));
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
            'mobile_number' => 'exclude_unless:station_type,SMS|regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number,' . $station->id,
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $station->update($request->all());

        return redirect()->route('stations.show', $station)->with('message', __('Station updated successfully.'));
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

        return redirect()->route('stations.index')->with('message', __('Station deleted successfully.'));
    }

    public function logs(Request $request, ObservationsStation $station)
    {
        $logs = $station->health()->orderBy('timestamp', 'DESC')->paginate(20, array('timestamp', 'message'));
        return Inertia::render('station.logs', compact('logs'));
    }
}
