<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\GLabs;

use Illuminate\Http\Request;

class GLabsController extends Controller
{
    public function index(Request $request)
    {
        $glabs = GLabs::with(['station:id,mobile_number,name', 'latestTopup:glabs_id,created_at'])
            ->orderBy('id')
            ->paginate(15);

        foreach ($glabs as $glabs0) {
            if ($glabs0->station) {
                $glabs0->station_url = route('stations.index').'/'.$glabs0->station->id;
                $glabs0->station_name = $glabs0->station->name;
            }
        }

        return Inertia::render('glabs', compact('glabs'));
    }
}
