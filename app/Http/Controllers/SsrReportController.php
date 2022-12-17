<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\SsrReport;
use Illuminate\Http\Request;

class SsrReportController extends Controller
{
    public function show($cache_id = null)
    {
        if ($cache_id) {
            $cache_id_db = md5(SsrReport::first()->created_at ?? null);
        }
        if (!$cache_id || $cache_id != $cache_id_db) {
            return redirect()->route('ssr', $cache_id_db);
        }

        $ssr = SsrReport::
            //
            // limit(100)->
            //
            get();

        $headers = [
            'department',
            'sub_department',
            'po_number',
            'item_code',
            'description',
            'category',
            'condition',
            'supplier',
            'uom',
            'center',
            'north',
            'south',
            'huawei',
            'zte',
            'ericsson'
        ];

        $top_headers = [
            ['colspan' => 9, 'title' => ''],
            ['colspan' => 3, 'title' => '3PL WH'],
            ['colspan' => 3, 'title' => 'OEM WH'],
        ];

        return view(request('view'), compact('ssr', 'headers', 'top_headers'));
    }


    public function summary($groupping = null)
    {
        switch ($groupping) {
            case 'category':
                $group = '`category`';
                break;
            case 'department':
                $group = '`category`,`department`';
                break;
            case 'condition':
                $group = '`category`,`department`,`condition`';
                break;

            default:
                return redirect()->route('ssr-summary.groupping', 'category');
                break;
        }

        $headers = explode(',', $group);

        $categories = Config::getItem('ssr_categories');

        $ssr = SsrReport::selectRaw($group . ', sum(north) as north, sum(south) as south, sum(center) as center, sum(huawei) as huawei, sum(zte) as zte, sum(ericsson) as ericsson, sum(north+center+south+huawei+zte+ericsson) as total')
            ->when(is_array($categories) && sizeof($categories), function ($q) use ($categories) {
                return $q->whereIn('category', $categories);
            })
            ->orderByRaw($group)
            ->groupByRaw($group)
            ->get()
            ->map(function ($r) {
                $r->center = number_format($r->center);
                $r->north = number_format($r->north);
                $r->south = number_format($r->south);
                $r->huawei = number_format($r->huawei);
                $r->zte = number_format($r->zte);
                $r->ericsson = number_format($r->ericsson);
                $r->total = number_format($r->total);

                return $r;
            });

        $headers = explode(',', str_replace('`', '', $group));
        array_push(
            $headers,
            ...['center', 'north', 'south', 'huawei', 'zte', 'ericsson', 'total']
        );
        $top_headers = [
            ['colspan' => sizeof(explode(',', $group)), 'title' => ''],
            ['colspan' => 3, 'title' => '3PL WH'],
            ['colspan' => 3, 'title' => 'OEM WH'],
            ['colspan' => 1, 'title' => ''],
        ];

        return view(request('view'), compact('ssr', 'headers', 'top_headers'));
    }
}
