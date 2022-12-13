<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class Lufft
{
    private $MISSING_VALUE = 999.9;
    private $obs;
    private $health;

    private function toFloat(string $strVal, $cf = 1.0, $returnRaw = false)
    {
        $val = (float)$strVal;
        if ($returnRaw) {
            return $val;
        }
        if ($val == $this->MISSING_VALUE) {
            return null;
        }
        return round($val * $cf, 2);
    }

    private function isValid(string $strVal)
    {
        $val = (float)$strVal;
        return ($val != $this->MISSING_VALUE);
    }

    public function __construct(string $msg)
    {
        $dtNow = Carbon::now('Asia/Manila');
        $varArray = explode("+", Str::of($msg)->trim()->replaceMatches('/(%20)|\s/', '+'));
        $varCount = count($varArray);

        $logType = 2;

        if ($varCount == 23) {
            [
                $_,
                $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $windDirDeg,
                $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                $voltPB1, $voltPB2, $curr, $boostPB1, $boostPB2,
                $curMon, $gsmSignalStrength, $arqTemp, $arqRH, $flashPg,
                $dateTimeStr
            ] = $varArray;
        } elseif ($varCount == 19) {
            $logType = 1;
            [
                $_,
                $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $windDirDeg,
                $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                $arqTemp, $arqRH, $gsmSignalStrength,
                $voltPB1, $boostPB1, $flashPg,
                $dateTimeStr
            ] = $varArray;

            $voltPB1 = explode("#", $voltPB1)[0];
        } elseif ($varCount == 20) {
            $logType = 1;
            [
                $_,
                $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $_, $windDirDeg,
                $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                $gsmSignalStrength, $voltPB1, $boostPB1,
                $arqTemp, $arqRH, $flashPg,
                $dateTimeStr
            ] = $varArray;

            $voltPB1 = substr($voltPB1, 0, -1);
        } elseif ($varCount == 24) {
            [
                $_,
                $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $_, $windDirDeg,
                $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip,
                $voltPB1, $voltPB2, $curr, $boostPB1, $boostPB2,
                $curMon, $gsmSignalStrength, $arqTemp, $arqRH, $flashPg,
                $dateTimeStr
            ] = $varArray;
        } else {
            $this->obs = [];
            return 0;
        }

        if (strpos($dateTimeStr, '/') === false) {
            $dateTime = Carbon::createFromFormat("y:m:d:H:i:s", $dateTimeStr, 'Asia/Manila');
        } else {
            if (strlen($dateTimeStr) == 13) {
                $dateTime = Carbon::createFromFormat("ymd/His", $dateTimeStr, 'Asia/Manila');
            } else {
                $dateTime = Carbon::createFromFormat("Ymd/His", $dateTimeStr, 'Asia/Manila');
            }
        }

        $errorMsg = "";
        $minMinutesThresh =  -90 * 24 * 60; # 90 days behind
        $maxMinutesThresh =  1 * 24 * 60; # 1 day ahead
        $dtDiff = $dtNow->diffInMinutes($dateTime, false);
        $dtDiffStr = $dateTime->diffForHumans($dtNow);
        if ($dtDiff < $minMinutesThresh) {
            $absVal = abs($dtDiff);
            $errorMsg = "timestamp is {$dtDiffStr} ({$absVal} minutes behind)";
        } elseif ($dtDiff > $maxMinutesThresh) {
            $errorMsg = "timestamp is {$dtDiffStr} ({$dtDiff} minutes ahead)";
        }
        if (($dtDiff < $minMinutesThresh) || ($dtDiff > $maxMinutesThresh)) {
            $dateTime = $dtNow;
        }

        $this->obs = [
            'temp' => $this->toFloat($tempC),
            'rh' => $this->toFloat($relHum),
            'pres' => $this->toFloat($airPresHPA, 1.0, true),
            'wspd' => $this->toFloat($windSpeedKPH, 1.0 / 3.6),
            'wspdx' => $this->toFloat($windGustKPH, 1.0 / 3.6),
            'wdir' => $this->toFloat($windDirDeg),
            'srad' => $this->toFloat($solRadWPM2),
            'td' => $this->toFloat($dewPtC),
            'wchill' => $this->toFloat($windChillC),
            'rr' => $this->toFloat($rainTip, 0.2 * 6.0),
            'timestamp' => $dateTime
        ];

        $metVars = [
            $tempC, $relHum, $airPresHPA, $windSpeedKPH, $windGustKPH, $windDirDeg,
            $solRadWPM2, $dewPtC, $windChillC, $rainTip, $rainCumTip
        ];
        $metVarStat = array_map(array($this, 'isValid'), $metVars);
        $metVarStat = array_map('intval', $metVarStat);

        $stnHealth = [
            'vb1' => (float)$voltPB1,
            'bp1' => (float)$boostPB1,
            'temp_arq' => (float)$arqTemp,
            'rh_arq' => (float)$arqRH,
            'ss' => (int)$gsmSignalStrength,
            'fpm' => (int)$flashPg,
            'message' => $msg,
            'data_count' => array_sum($metVarStat),
            'data_status' => implode("", $metVarStat),
            'error_msg' => $errorMsg,
            'minutes_difference' => $dtDiff,
            'timestamp' => $dateTime
        ];

        if ($logType == 2) {
            $stnHealth = Arr::add($stnHealth, 'vb2', (float)$voltPB2);
            $stnHealth = Arr::add($stnHealth, 'bp2', (float)$boostPB2);
            $stnHealth = Arr::add($stnHealth, 'curr', (float)$curr);
            $stnHealth = Arr::add($stnHealth, 'cm', $curMon);
        }

        $this->health = $stnHealth;
    }

    public function getObs()
    {
        return $this->obs;
    }

    public function getHealth()
    {
        return $this->health;
    }
}
