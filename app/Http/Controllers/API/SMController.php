<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\SIMCard;
use App\Models\ObservationsStation;

use App\Helpers\Lufft;

use App\Http\Controllers\Controller;

class SMController extends Controller
{
    public function index(Request $request)
    {
        Log::debug('[SM] GET: ' . json_encode($request->all()));

        return $request->all();
    }

    public function post(Request $request)
    {
        # Message Received
        # Parse and store to the database
        if (Arr::has($request->post(), 'msg')) {
            $subNum = Str::substr($request->post('number'), 1); #63XXXXXXXXXX
            $smsMsg = $request->post('msg');

            if ($subNum) {
                $station = ObservationsStation::where('mobile_number', $subNum)->first();
            } else {
                return response()->json(['message' => 'Number not found']);
            }

            $lufft = new Lufft($smsMsg);

            if (count($lufft->getObs()) == 0) {
                Log::debug('[SM] Invalid data. sender:' . $subNum . ' message:' . $smsMsg);
                if ($station) {
                    $station->health()->create([
                        'message' => $smsMsg,
                        'timestamp' => Carbon::now()
                    ]);
                }
                return response()->json(['message' => "Error: Message not understood", 'data' => $smsMsg]);
            }

            if ($station) {
                $record = $station->observation()->firstWhere('timestamp', $lufft->getObs()['timestamp']);
                if (is_null($record)) {
                    $station->observation()->create($lufft->getObs());
                    $station->health()->create($lufft->getHealth());

                    Log::debug('[SM] Data saved. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data saved"]);
                } else {
                    Log::debug('[SM] Data not saved, record already exists. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data not saved, record already exists"]);
                }
            } else {
                Log::debug('[SM] unknown sender:' . $subNum . ' message:' . $smsMsg);
                return response()->json(['message' => "Error: No associated weather station for " . $subNum]);
            }
        }

        return response()->json(['message' => "Nothing to do"]);
    }
}
