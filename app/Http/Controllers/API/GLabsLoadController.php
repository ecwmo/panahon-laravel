<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Models\GLabsLoad;

use App\Http\Controllers\Controller;

class GLabsLoadController extends Controller
{
    public function post(Request $request)
    {
        # Topup detected
        # Parse and store to the database
        if (Arr::has($request->post(), 'outboundRewardRequest')) {
            $subNum = $request->post('outboundRewardRequest')['address'];
            $promo = $request->post('outboundRewardRequest')['promo'];
            $status = $request->post('outboundRewardRequest')['status'];
            $transactionID = (int)($request->post('outboundRewardRequest')['transaction_id']);

            Log::debug('[GlobeLabs:Load] Topup detected for ' . $subNum . ' promo: ' . $promo . ' status: ' . $status);

            GLabsLoad::create([
                'mobile_number' => $subNum,
                'status' => $status,
                'promo' => $promo,
                'transaction_id' => $transactionID,
            ]);
            return response()->json($request->post('outboundRewardRequest'));


        } elseif (Arr::has($request->post(), 'error')) {
            Log::debug('[GlobeLabs:Load] Error:' . $request->post('error'));
            return response()->json(['error' => $request->post('error')]);
        }

        return response()->json(['message' => "Nothing to do"]);
    }
}
