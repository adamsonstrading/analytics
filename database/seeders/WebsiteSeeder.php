<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    public function run()
    {
        DB::table('websites')->updateOrInsert(
            ['ga4_property_id' => '497657805'],
            [
                'name' => 'My Website Project',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
