<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        // @todo work with eloquent. casts are a little bit finicky for postgis columns
        $markers = DB::table('markers')
            ->select(DB::raw('id, st_y(coordinates::geometry) as lat, st_x(coordinates::geometry) as lng'))
            ->offset(0)
            ->limit(25)
            ->get();

        return Inertia::render('Welcome', [
            'markers' => $markers
        ]);
    }

    public function insert_post_markers(Request $request): JsonResponse
    {
        $request->validate([
            'longitude' => [
                'bail',
                'required',
                'regex:/^(\+|-)?(?:180(?:(?:\.0{1,8})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/'
            ],
            'latitude' => [
                'required',
                'regex:/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/'
            ]
        ]);

        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $mark = Marker::create([
            'name' => 'hhh',
            'coordinates' => DB::raw("ST_GeogFromText('SRID=4326;POINT($longitude $latitude)')")
        ]);

        return response()->json(['data' => $mark]);
    }
}
