<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\GLabs;
use App\Models\ObservationsStation;

use App\Http\Controllers\Controller;

class GLabsController extends Controller
{
    public function index(Request $request)
    {
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
                return response()->json(['message'=>'Invalid code']);
            }
            $bdy = $response->json();
            $accessToken = $bdy['access_token'];
            $subNum = $bdy['subscriber_number'];
        }

        # Opt-in via SMS
        if ($subNum && $accessToken) {
            $msg = "Number already registered";

            # Test if token is already used
            if(GLabs::where('access_token', $accessToken)->first()) {
                $msg = "Error: Token already used";
                return response()->json(['message'=>$msg]);
            }

            $station = ObservationsStation::where('mobile_number', '63'.$subNum)->first();

            if (!$station) { # Create station object
                $station = ObservationsStation::create([
                    'name'=>'63'.$subNum,
                    'mobile_number'=>'63'.$subNum,
                    'station_type'=>'SMS',
                    'status'=>'ACTIVE',
                ]);
            } else {
                $station->status = 'ACTIVE';
                $station->save();
            }
            $stGLabsSubs = $station->glabs_subscription;
            if (!$stGLabsSubs) { # Create new subscription
                $stGLabsSubs = $station->glabs_subscription()->create(['access_token'=>$accessToken]);
                $msg = "Station registered successfuly";
            } else { # Update token
                $stGLabsSubs->access_token = $accessToken;
                $stGLabsSubs->save();
                $msg = "Station token changed";
            }
        }

        return response()->json(['message'=>$msg]);
    }

    public function post(Request $request)
    {
        # Message Received
        # Parse and store to the database
        if (Arr::has($request->post(), 'inboundSMSMessageList')) {
            $senderAddress = $request->post('inboundSMSMessageList')['inboundSMSMessage'][0]['senderAddress'];
            $subNum = Str::substr($senderAddress, 5); #63XXXXXXXXXX
            $smsMsg = $request->post('inboundSMSMessageList')['inboundSMSMessage'][0]['message'];

            $varArray = explode("+", Str::of($smsMsg)->trim()->replaceMatches('/%20/', '+'));
            $varCount = count($varArray);

            if ($subNum) {
                $station = ObservationsStation::where('mobile_number', $subNum)->first();
            } else {
                return response()->json(['message'=>'Number not found']);
            }

            if ($varCount == 23) {
                [$_,
                    $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $windDirDeg,
                    $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                    $voltPB1, $voltPB2, $curr, $boostPB1, $boostPB2,
                    $curMon, $gsmSignalStrength, $arqTemp, $arqRH, $flashPg,
                    $dateTimeStr] = $varArray;
            } elseif ($varCount == 21) {
                [$_,
                    $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $windDirDeg,
                    $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                    $voltPB1, $curr, $boostPB1,
                    $curMon, $gsmSignalStrength, $arqTemp, $arqRH, $flashPg,
                    $dateTimeStr] = $varArray;

            } elseif ($varCount == 24) {
                [$_,
                    $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $_, $windDirDeg,
                    $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                    $voltPB1, $curr, $boostPB1,
                    $curMon, $gsmSignalStrength, $arqTemp, $arqRH, $flashPg,
                    $dateTimeStr] = $varArray;
            } else {
                Log::debug('[GlobeLabs] Invalid data. sender:'.$subNum.' message:'.$smsMsg);
                if ($station) {
                    $station->health()->create([
                        'message' => $smsMsg,
                        'timestamp' => Carbon::now()
                    ]);
                }
                return response()->json(['message'=>"Error: Message not understood", 'data'=>$smsMsg]);
            }

            if (strlen($dateTimeStr)==13) {
                $dateTime = Carbon::createFromFormat("ymd/His" ,$dateTimeStr, 'Asia/Manila');
            } else {
                $dateTime = Carbon::createFromFormat("Ymd/His" ,$dateTimeStr, 'Asia/Manila');
            }

            if ($station) {
                $obsRaw = [
                    'temp'=>(float)$tempC,
                    'rh'=>(float)$relHum,
                    'pres'=>(float)$airPresHPA,
                    'wspd'=>(float)$windSpeedKPH/3.6,
                    'wspdx'=>(float)$windGustKPH/3.6,
                    'wdir'=>(float)$windDirDeg,
                    'srad'=>(float)$solRadWPM2,
                    'td'=>(float)$dewPtC,
                    'wchill'=>(float)$windChillC,
                    'rr'=>(float)$rainTip*0.2*6.0,
                    'timestamp'=>$dateTime
                ];
                $station->observationRaw()->create($obsRaw);
                $station->observation()->create($obsRaw);

                $stnHealth = [
                    'vb1'=>(float)$voltPB1,
                    'curr'=>(float)$curr,
                    'bp1'=>(float)$boostPB1,
                    'cm'=>$curMon,
                    'ss'=>(int)$gsmSignalStrength,
                    'temp_arq'=>(float)$arqTemp,
                    'rh_arq'=>(float)$arqRH,
                    'fpm'=>(int)$flashPg,
                    'message'=>$smsMsg,
                    'timestamp'=>$dateTime
                ];
                if ($varCount == 23) {
                    $stnHealth = Arr::add($stnHealth, 'vb2', (float)$voltPB2);
                    $stnHealth = Arr::add($stnHealth, 'bp2', (float)$boostPB2);
                }
                $station->health()->create($stnHealth);

                Log::debug('[GlobeLabs] Data saved. sender:'.$subNum.' message:'.$smsMsg);
                return response()->json(['message'=>"Data saved"]);
            } else {
                Log::debug('[GlobeLabs] unknown sender:'.$subNum.' message:'.$smsMsg);
                return response()->json(['message'=>"Error: No associated weather station for ".$subNum]);
            }
        }
        # Stop Subscription
        # Delete database entry
        elseif (Arr::has($request->post(), 'unsubscribed')) {
            $subNum = $request->post('unsubscribed')['subscriber_number'];
            if ($subNum) {
                $station = ObservationsStation::where('mobile_number', "63".$subNum)->firstOrFail();

                $stGLabsSubs = $station->glabs_subscription;
                if ($stGLabsSubs) { # Delete token
                    $stGLabsSubs->delete();
                    return response()->json(['message'=>"Unsubscribed"]);
                }
            }
            Log::debug('[GlobeLabs] Unsubscribe:'.$subNum);
            return response()->json(['message'=>"Nothing to do"]);
        }
        elseif (Arr::has($request->post(), 'error')) {
            Log::debug('[GlobeLabs] Error:'.$request->post('error'));
            return response()->json(['error'=>$request->post('error')]);
        }

        return response()->json(['message'=>"Nothing to do"]);
    }
}
