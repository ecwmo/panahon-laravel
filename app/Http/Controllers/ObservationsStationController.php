<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\ObservationsStation;
use App\Models\SMSGateway;

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
        return Inertia::render('Stations', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('StationForm', []);
    }

    /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request)
    {
        $station = $this->storeOrUpdate($request);
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
        return Inertia::render('StationForm', compact('station'));
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
        $station = $this->storeOrUpdate($request, $station);
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
        $isDeleted = $station->delete();

        if ($isDeleted) {
            $station->mobile_number = null;
            $station->save();
        }

        return redirect()->route('stations.index')->with('message', __('Station deleted successfully.'));
    }

    public function logs(Request $request, ObservationsStation $station)
    {
        $logs = $station->health()->orderBy('timestamp', 'DESC')->paginate(20, array('timestamp', 'message'));
        return Inertia::render('StationLogs', compact('logs'));
    }

    /**
   * Store or Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ObservationsStation  $station
   * @return \App\Models\ObservationsStation  $station
   */
    private function storeOrUpdate(Request $request, ObservationsStation $station = null)
    {
        $cpNumValidator = 'exclude_if:station_type,MO|regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number';
        $stnUrlValidator = 'exclude_unless:station_type,MO|URL|nullable|unique:observations_station,station_url';
        if ($station) {
            $cpNumValidator = $cpNumValidator . ',' . $station->id;
            $stnUrlValidator = $stnUrlValidator . ',' . $station->id;
        }

        $validated = $request->validate([
            'name' => 'required|max:200',
            'lon' => 'numeric|nullable',
            'lat' => 'numeric|nullable',
            'elevation' => 'numeric|nullable',
            'station_type' => 'max:255',
            'station_type2' => 'max:255|nullable',
            'mobile_number' => $cpNumValidator,
            'station_url' => $stnUrlValidator,
            'status' => 'max:255',
            'date_installed' => 'nullable|date_format:Y-m-d',
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        if (!$station) {
            $station = ObservationsStation::create($validated);
        } else {
            $station->update($validated);
        }

        # Create new subscription
        if (isset($validated['mobile_number']) && (!$station->sms_gateway_subscription)) {
            $subscription = SMSGateway::create([
                'mobile_number' => $validated['mobile_number'],
            ]);
        }

        return $station;
    }
}
