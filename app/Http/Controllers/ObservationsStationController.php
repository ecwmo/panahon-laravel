<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ObservationsStation;

class ObservationsStationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stations = ObservationsStation::where([
            ['name', '!=', Null],
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
        return view('station.index', compact('stations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('station.form', ['station' => new ObservationsStation()]);
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
     * Display the specified resource.
     *
     * @param  \App\Models\ObservationsStation  $station
     * @return \Illuminate\Http\Response
     */
    public function show(ObservationsStation $station)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObservationsStation  $station
     * @return \Illuminate\Http\Response
     */
    public function edit(ObservationsStation $station)
    {
        return view('station.form', compact('station'));
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function table(Request $request)
    {
        $stations = ObservationsStation::where([
            ['name', '!=', Null],
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
        return $stations;
    }

    public function showLogs(Request $request, $id)
    {
        return view('station.logs', ["id" => $id]);
    }

    public function fetchLogs(Request $request, $id)
    {
        $station = ObservationsStation::find($id);
        $logs = $station->health()->orderBy('timestamp', 'DESC')->paginate(20, array('timestamp', 'message'));
        return $logs;
    }
}
