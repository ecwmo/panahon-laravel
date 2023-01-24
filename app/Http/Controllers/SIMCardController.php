<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use Illuminate\Http\Request;

use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

use App\Models\SIMCard;

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
}
