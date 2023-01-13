<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SIMCard;

use Illuminate\Http\Request;

class SIMCardController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = SIMCard::whereNotNull('mobile_number')
            ->orderBy('id')
            ->paginate(15);

        foreach ($subscribers as $subs) {
            if ($subs->station) {
                $subs->station_url = route('stations.index').'/'.$subs->station->id;
                $subs->station_name = $subs->station->name;
                unset($subs["station"]);
            }

            if ($subs->latestTopup) {
                $subs->topup_date = $subs->latestTopup->created_at;
                unset($subs["latestTopup"]);
            }
        }

        return Inertia::render('SIMCard', compact('subscribers'));
    }
}
