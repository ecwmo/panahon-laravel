<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\SMSGateway;

use Illuminate\Http\Request;

class SMSGatewayController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = SMSGateway::with(['station:id,mobile_number,name', 'latestTopup:glabs_id,created_at'])
            ->orderBy('id')
            ->paginate(15);

        foreach ($subscribers as $subs) {
            if ($subs->station) {
                $subs->station_url = route('stations.index').'/'.$subs->station->id;
                $subs->station_name = $subs->station->name;
            }
        }

        return Inertia::render('SMSGateway', compact('subscribers'));
    }
}
