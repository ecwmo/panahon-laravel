<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\ObservationsStation;

use App\Helpers\Lufft;

use App\Http\Controllers\Controller;

class M360Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('message')) {
            $subNum = '63' . $request->string('msisdn')->trim()->substr(1); #63XXXXXXXXXX
            $smsMsg = $request->string('message')->trim();

            if ($subNum) {
                $station = ObservationsStation::where('mobile_number', $subNum)->first();
            } else {
                return response()->json(['message' => 'Number not found']);
            }

            $lufft = new Lufft($smsMsg);

            if (count($lufft->getObs()) == 0) {
                Log::debug('[m360] Invalid data. sender:' . $subNum . ' message:' . $smsMsg);
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

                    Log::debug('[m360] Data saved. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data saved"]);
                } else {
                    Log::debug('[m360] Data not saved, record already exists. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data not saved, record already exists"]);
                }
            } else {
                Log::debug('[m360] unknown sender:' . $subNum . ' message:' . $smsMsg);
                return response()->json(['message' => "Error: No associated weather station for " . $subNum]);
            }
        }

        return response()->json(['message' => "Nothing to do"]);
    }
}
