<?php

namespace App\Console\Commands;

use App\Models\Marker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMarkers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-markers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('running');

        DB::table('markers')->insert([
            'name' => 'hello',
            'coordinates' => DB::raw("ST_GeogFromText('SRID=4326;POINT(-110 30)')")
        ]);

        // $mker = Marker::create(['name' => 'Hello', 'coordinates' => 'point({55.0},{6.3})']);
    }
}
