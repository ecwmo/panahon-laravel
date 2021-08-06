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
    public function index(Request $request) {
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
            ->orderByRaw('date_installed DESC NULLS LAST')
            ->orderBy('id', 'asc')
            ->orderBy('status', 'asc')
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

        ObservationsStation::create($request->all());
        return back()->with('success', 'New station added.');
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
    public function edit(ObservationsStation $station) {
        return view('station.form', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObservationsStation  $station
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ObservationsStation $station) {
        $request->validate([
            'name' => 'required|max:200',
            'lon' => 'numeric|nullable',
            'lat' => 'numeric|nullable',
            'elevation' => 'numeric|nullable',
            'mobile_number' => 'regex:/63[0-9]{10}/|size:12|nullable|unique:observations_station,mobile_number,'. $station->id,
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $station->update($request->all());

        return back()->with('success', 'Station updated!');
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

        return redirect('stations')->with('success', 'Station deleted!');
    }
}
