<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\SIMCard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;

class SIMCardController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = QueryBuilder::for(SIMCard::class)
            ->whereNotNull('mobile_number')
            ->withAggregate('station', 'id')
            ->withAggregate('station', 'name')
            ->withAggregate('latestTopup', 'created_at')
            ->defaultSort('id')
            ->allowedSorts(['id', 'mobile_number', 'created_at', 'station_name', 'latest_topup_created_at'])
            ->allowedFilters([AllowedFilter::exact('id'), 'mobile_number', 'station_name'])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('SIMCard', compact('subscribers'))->table(function (InertiaTable $table) {
            $table
                ->column('id', '#', searchable: true, sortable: true)
                ->column('mobile_number', 'Mobile Number', searchable: true, sortable: true, canBeHidden: false)
                ->column('created_at', 'Subscription Date', searchable: false, sortable: true)
                ->column('station_name', 'Station Name', searchable: true, sortable: true)
                ->column('latest_topup_created_at', 'Latest Topup', searchable: false, sortable: true);
        });
    }

    public function post(Request $request)
    {
        if ($request->has('rewardRequest')) {
            $subNum = $request->post('rewardRequest')['address'];
            $glab = SIMCard::where('mobile_number', "63" . $subNum)->firstOrFail();

            if ($glab) {
                $data = [
                    'outboundRewardRequest' => [
                        'app_id' => config('glabs.app_id'),
                        'app_secret' => config('glabs.app_secret'),
                        'rewards_token' => config('glabs.rewards_token'),
                        'address' => $subNum,
                        'promo' => config('glabs.rewards_promo'),
                    ]
                ];

                Http::withBody(json_encode($data), 'application/json')
                    ->post('https://devapi.globelabs.com.ph/rewards/v1/transactions/send');

                sleep(2);

                if ($glab->latestTopup->created_at->isCurrentDay()) {
                    return redirect()->route('simcard.index')->with('message', __('Topup successful.'));
                }
            }

            return redirect()->route('simcard.index')->with('message', __('Topup error.'));
        }
    }
}
