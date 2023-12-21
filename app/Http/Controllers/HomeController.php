<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use function Pest\Laravel\json;

class HomeController extends Controller
{
    public function index(): Response
    {
//        return Inertia::render('Home/Show', [
//            'points' => [],
//        ]);
        $marks = DB::table('markers')
            ->select(DB::raw('id, st_y(coordinates::geometry) as lat, st_x(coordinates::geometry) as lng'))
            ->offset(0)
            ->limit(25)
            ->get();

        dump($marks->toArray());

        //format for vue maps
//        $formatted_marks = [];
//
//        foreach ($marks as $mark) {
//            $formatted_marks[] = [
//                "id" =>$mark["id"],
//                'position' => [
//                    "lat" => $mark["lat"],
//                    "lng" => $mark["lng"]
//                ]
//            ];
//        }
//            Marker::select([
//            'name' => 'hhh',
//            'coordinates' => DB::raw("ST_GeogFromText('SRID=4326;POINT($longitude $latitude)')") //'($longitude $latitude)'
//        ]);

        return Inertia::render('Welcome', [
            'markers' => $marks
        ]);
    }

    public function insert_post_markers(Request $request): JsonResponse {
        $validated = $request->validate([
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

        $raw_query = "ST_GeogFromText('SRID=4326;POINT($longitude $latitude)')";

        dump($raw_query);
        dump($request->input('longitude'));

        $mark = Marker::create([
            'name' => 'hhh',
            'coordinates' => DB::raw("ST_GeogFromText('SRID=4326;POINT($longitude $latitude)')") //'($longitude $latitude)'
        ]);

        // SELECT name, st_y(coordinates::geometry) as lat, st_x(coordinates::geometry) as long FROM public.markers
        //ORDER BY id ASC LIMIT 100

//        DB::table('markers')->insert([
//            'coordinates' => DB::raw("ST_GeogFromText('SRID=4326;POINT($longitude $latitude)')")
//        ]);

        return response()->json(['data' => $request->all()]);
    }
}
