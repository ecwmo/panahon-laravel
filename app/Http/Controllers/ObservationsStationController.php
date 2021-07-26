<?php

namespace App\Http\Controllers;

use App\Models\ObservationsStation;
use Illuminate\Http\Request;

class ObservationsStationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $stations = ObservationsStation::paginate(10);
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
            'mobile_number' => 'regex:/63[0-9]{10}/|size:12|nullable|unique:App\Models\ObservationsStation,mobile_number',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $station = ObservationsStation::find($id);
        return view('station.form', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        // return view('station.edit', compact('station'));
        $request->validate([
            'name' => 'required|max:200',
            'lon' => 'numeric|nullable',
            'lat' => 'numeric|nullable',
            'elevation' => 'numeric|nullable',
            'mobile_number' => 'regex:/63[0-9]{10}/|size:12|nullable',
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $station = ObservationsStation::findOrFail($id);
        $station->update($request->all());
        // $station->save();
        return back()->with('success', 'Station updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $station = ObservationsStation::find($id);
        $station->delete();

        return redirect('stations')->with('success', 'Station deleted!');
    }
}
