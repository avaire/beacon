<?php

namespace App\Http\Controllers;

use App\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller
{
    /**
     * Shows the collected total stats for all of Beacon. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stats = Cache::get('stats');

        if ($stats == null) {
            return response()->json([
                'status' => 501,
                'reason' => 'No stats data has been generated yet, check back later.',
            ], 501);
        }

        return response()->json([
            'status' => 200,
            'data' => $stats,
        ]);
    }
}
