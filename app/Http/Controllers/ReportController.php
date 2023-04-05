<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Reservations;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        return view('pages.sales-report');
    }

    public function leaderboardReport(Request $request)
    {
        $data=User::getLeaderBoard();
        return view('pages.leaderboard',compact(['data']));
    }

    public function ridesReport(Request $request)
    {
        $rides=[];
        $query = Bike::where('status', 1);
        if (Auth::user()->usertype == 1) {
            $rides=$query->get();
        } else {
            $rides=$query->where('owner', Auth::user()->id)->get();
        }
        return view('pages.rides-report', compact(['rides']));
    }

    public function salesReportList(Request $request)
    {
        $data = [];
        $query = Reservations::where('status', 2);

        if (Auth::user()->usertype == 2) {
            $availableStores = Store::where('status', 1)->where('owner', Auth::user()->id)->pluck('id')->toArray();
            $query->whereIn('bike', Bike::where('status', 1)->where('store', $availableStores)->pluck('id')->toArray());
        }

        if ($request->has('from') && $request->from != '') {
            $query->whereDate('ride_at', '>=', Carbon::parse($request->from)->format('Y-m-d'));
        }

        if ($request->has('ride') && $request->ride != '') {
            $query->where('bike', $request->ride);
        }

        if ($request->has('to') && $request->to != '') {
            $query->whereDate('drop_at', '<', Carbon::parse($request->to)->format('Y-m-d'));
        }

        $index = $request->start;

        $allCount = $query->count();

        if ($request->has('length') && $request->length != '-1') {
            $query->skip($request->start)->take($request->length);
        }

        $total = 0;

        foreach ($query->with(['bikeData', 'userData'])->orderBy('id', 'DESC')->get() as $key => $reser) {

            if ($request->has('search') &&  str_contains($reser->bikeData->reference, $request->search['value'])) {
                $total += $reser->total;

                $data[] = [
                    "#" . str_pad($reser->id, 4, "0", STR_PAD_LEFT),
                    $reser->bikeData->reference,
                    $reser->userData->email,
                    number_format(((float)$reser->distance), 2, '.', '') . 'KM',
                    $reser->ride_at,
                    $reser->drop_at,
                    '<p class="text-primary">' . format_currency($reser->total) . '</p>',
                ];
                $index++;
            }
        }

        $data[] = [
            '-',
            '-',
            '-',
            '-',
            '-',
            '-',
            format_currency($total)
        ];

        return [
            'data' => $data,
            'recordsFiltered' => $allCount,
            'recordsTotal' => $query->count(),
        ];
    }
}
