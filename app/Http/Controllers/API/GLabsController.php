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
use App\Models\SimAccessTokens;

use App\Helpers\Lufft;

use App\Http\Controllers\Controller;

class GLabsController extends Controller
{
    public $MISSING_VALUE = 999.9;

    public function index(Request $request)
    {
        $GLABS_ACCESS_TOKEN_TYPE = "GLABS";
        $GLABS_MOBILE_NUMER_TYPE = "GLOBE";

        $msg = "Nothing to do";

        $accessToken = $request->query('access_token');
        $subNum = $request->query('subscriber_number');
        $code = $request->query('code');

        # Opt-in via Webform
        if ($code) {
            $response = Http::post('https://developer.globelabs.com.ph/oauth/access_token', [
                'app_id' => env('GLABS_APP_ID'),
                'app_secret' => env('GLABS_APP_SECRET'),
                'code' => $code
            ]);
            if (!$response->ok() || Arr::has($response->json(), 'error')) {
                $msg = 'Invalid code';
                Log::debug('[GlobeLabs] Web Subscribe:' . $subNum . ' message:' . $msg);
                return response()->json(['message' => $msg]);
            }
            $bdy = $response->json();
            $accessToken = $bdy['access_token'];
            $subNum = $bdy['subscriber_number'];
        }

        # Opt-in via SMS
        if ($subNum && $accessToken) {
            $msg = "Number already registered";

            # Test if token is already used
            if (SimAccessTokens::where('type', $GLABS_ACCESS_TOKEN_TYPE)->where('access_token', $accessToken)->first()) {
                $msg = "Error: Token already used";
                Log::debug('[GlobeLabs] Subscribe:' . $subNum . ' message:' . $msg);
                return response()->json(['message' => $msg]);
            }

            $glab = SIMCard::where('mobile_number', "63" . $subNum)
                ->first();

            if (!$glab) { # Create new subscription
                $glab = SIMCard::create([
                    'mobile_number' => '63' . $subNum,
                    'type' => $GLABS_MOBILE_NUMER_TYPE
                ]);
            }

            $oldAccessToken = $glab->accessTokens()->where('type', $GLABS_ACCESS_TOKEN_TYPE)->first();

            if (!$oldAccessToken) { # Add Token
                $glab->accessTokens()->create(['type' => $GLABS_ACCESS_TOKEN_TYPE, 'access_token' => $accessToken]);
                $msg = "Mobile number registered successfuly";
            } else { # Update token
                $oldAccessToken->access_token = $accessToken;
                $oldAccessToken->save();
                $msg = "Mobile number token changed";
            }

            $station = $glab->station;
            if (!$station) { # Create station object
                $station = ObservationsStation::create([
                    'name' => '63' . $subNum,
                    'mobile_number' => '63' . $subNum,
                    'station_type' => 'SMS',
                    'status' => 'ACTIVE',
                ]);
            } else {
                $station->status = 'ACTIVE';
                $station->save();
            }

            Log::debug('[GlobeLabs] Subscribe:' . $subNum . ' message:' . $msg);
            return response()->json(['message' => $msg]);
        }

        $glabs = SIMCard::with(['station:id,mobile_number,name', 'latestTopup:mobile_number,created_at'])
            ->where('type', 'globe')
            ->orderBy('id')
            ->paginate(15);

        return $glabs;
    }

    public function post(Request $request)
    {
        # Message Received
        # Parse and store to the database
        if (Arr::has($request->post(), 'inboundSMSMessageList')) {
            $senderAddress = $request->post('inboundSMSMessageList')['inboundSMSMessage'][0]['senderAddress'];
            $subNum = Str::substr($senderAddress, 5); #63XXXXXXXXXX
            $smsMsg = $request->post('inboundSMSMessageList')['inboundSMSMessage'][0]['message'];

            if ($subNum) {
                $station = ObservationsStation::where('mobile_number', $subNum)->first();
            } else {
                return response()->json(['message' => 'Number not found']);
            }

            $lufft = new Lufft($smsMsg);

            if (count($lufft->getObs()) == 0) {
                Log::debug('[GlobeLabs] Invalid data. sender:' . $subNum . ' message:' . $smsMsg);
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

                    Log::debug('[GlobeLabs] Data saved. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data saved"]);
                } else {
                    Log::debug('[GlobeLabs] Data not saved, record already exists. sender:' . $subNum . ' message:' . $smsMsg);
                    return response()->json(['message' => "Data not saved, record already exists"]);
                }
            } else {
                Log::debug('[GlobeLabs] unknown sender:' . $subNum . ' message:' . $smsMsg);
                return response()->json(['message' => "Error: No associated weather station for " . $subNum]);
            }
        }
        # Stop Subscription
        # Delete database entry
        elseif (Arr::has($request->post(), 'unsubscribed')) {
            $subNum = $request->post('unsubscribed')['subscriber_number'];
            if ($subNum) {
                $glab = SIMCard::where('mobile_number', "63" . $subNum)
                    ->firstOrFail();
                if ($glab) { # Delete token
                    $glab->accessTokens()->where('type', 'globe')->delete();
                    // $station = $glab->station;
                    // if ($station) {
                    //     $station->mobile_number = null;
                    //     $station->save();
                    // }
                    return response()->json(['message' => "Unsubscribed"]);
                }
            }
            Log::debug('[GlobeLabs] Unsubscribe:' . $subNum);
            return response()->json(['message' => "Nothing to do"]);
        } elseif (Arr::has($request->post(), 'error')) {
            Log::debug('[GlobeLabs] Error:' . $request->post('error'));
            return response()->json(['error' => $request->post('error')]);
        }

        return response()->json(['message' => "Nothing to do"]);
    }
}
