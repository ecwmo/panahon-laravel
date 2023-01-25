<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

use App\Models\ObservationsStation;
use App\Models\SIMCard;

class ObservationsStationController extends Controller
{
    public function index(Request $request)
    {
        $stations = QueryBuilder::for(ObservationsStation::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'name', 'station_type', 'status', 'date_installed'])
            ->allowedFilters([AllowedFilter::exact('id'), 'name', 'station_type', 'status'])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Stations', compact('stations'))->table(function (InertiaTable $table) {
            $table
                ->column('id', '#', searchable: true, sortable: true)
                ->column('name', 'Station Name', searchable: true, sortable: true, canBeHidden: false)
                ->column('station_type', 'Type', searchable: true, sortable: true)
                ->selectFilter(key: 'station_type', label: 'Type', options: [
                    'SMS' => 'SMS',
                    'MO' => 'MO',
                    'Others' => 'Others',
                ])
                ->column('status', 'Status', searchable: true, sortable: true)
                ->selectFilter(key: 'status', label: 'Status', options: [
                    'ONLINE' => 'ONLINE',
                    'OFFLINE' => 'OFFLINE',
                    'ERROR' => 'ERROR',
                    'INACTIVE' => 'INACTIVE',
                ])
                ->column('date_installed', 'Install Date', searchable: false, sortable: true);
            $is_admin  = false;
            $user = Auth::user();
            if ($user) {
                $is_admin = $user->isAdmin();
            }
            if ($is_admin) {
                $table->column(label: 'Actions');
            }
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $station = new ObservationsStation();
        return $this->show($station);
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
        $logs = QueryBuilder::for($station->health())
            ->defaultSort('-timestamp')
            ->allowedSorts(['timestamp'])
            ->allowedFilters(['message'])
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('StationLogs', compact('logs'))->table(function (InertiaTable $table) {
            $table
                ->column('timestamp', 'Timestamp', searchable: false, sortable: true, canBeHidden: false)
                ->column('message', 'String', searchable: true, sortable: false, canBeHidden: false);
        });
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
        $stnNameValidator = 'required|max:200|unique:observations_station,name';
        $cpNumUniqueValidator = 'unique:observations_station,mobile_number';
        $stnUrlValidator = 'exclude_unless:station_type,MO|nullable|URL|unique:observations_station,station_url';
        if ($station) {
            $stnNameValidator = $stnNameValidator . ',' . $station->id;
            $cpNumUniqueValidator = $cpNumUniqueValidator . ',' . $station->id;
            $stnUrlValidator = $stnUrlValidator . ',' . $station->id;
        }

        $validator = Validator::make($request->all(), [
            'name' => $stnNameValidator,
            'lon' => 'numeric|nullable',
            'lat' => 'numeric|nullable',
            'elevation' => 'numeric|nullable',
            'station_type' => 'max:255',
            'station_type2' => 'max:255|nullable',
            'mobile_number' => [
                Rule::excludeIf(fn () => $request->station_type == 'MO' && $request->station_type2 == 'Default'),
                'regex:/63[0-9]{10}/',
                $cpNumUniqueValidator,
            ],
            'station_url' => $stnUrlValidator,
            'status' => 'max:255',
            'date_installed' => 'nullable|date_format:Y-m-d',
            'address' => 'max:255|nullable',
            'province' => 'max:255|nullable',
            'region' => 'max:255|nullable',
        ]);

        $validated = $validator->validated();

        if (!$station) {
            $station = ObservationsStation::create($validated);
        } else {
            $station->update($validated);
        }

        # Create new SIMCard if not exist
        if (isset($validated['mobile_number']) && (!$station->SIMCard)) {
            SIMCard::create([
                'mobile_number' => $validated['mobile_number'],
            ]);
        }

        return $station;
    }
}
