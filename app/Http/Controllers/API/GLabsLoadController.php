<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;


use App\Models\SMSGateway;

use App\Http\Controllers\Controller;

class GLabsLoadController extends Controller
{
    public function post(Request $request)
    {
        # Topup detected
        # Parse and store to the database
        if (Arr::has($request->post(), 'outboundRewardRequest')) {
            $subNum = $request->post('outboundRewardRequest')['address'];
            $glab = SMSGateway::where('type', 'globe')->where('mobile_number', "63" . $subNum)->firstOrFail();

            if ($glab) {
                $glab->topups()->create([
                    'status' => $request->post('outboundRewardRequest')['status'],
                    'promo' => $request->post('outboundRewardRequest')['promo'],
                    'transaction_id' => (int)($request->post('outboundRewardRequest')['transaction_id'])
                ]);
                Log::debug('[GlobeLabs:Load] Topup detected for ' . $subNum . ' promo: ' . $request->post('outboundRewardRequest')['promo'] . ' status: ' . $request->post('outboundRewardRequest')['status']);
                return response()->json($request->post('outboundRewardRequest'));
            }
        } elseif (Arr::has($request->post(), 'error')) {
            Log::debug('[GlobeLabs:Load] Error:' . $request->post('error'));
            return response()->json(['error' => $request->post('error')]);
        }

        return response()->json(['message' => "Nothing to do"]);
    }
}
