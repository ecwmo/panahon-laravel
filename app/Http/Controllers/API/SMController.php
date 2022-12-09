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

class SMController extends Controller
{
    public function index(Request $request)
    {
        Log::debug('[SM] GET: ' . json_encode($request->all()));

        return $request->all();
    }

    public function post(Request $request)
    {
        Log::debug('[SM] POST: ' . json_encode($request->post()));

        return $request->post();
    }
}
