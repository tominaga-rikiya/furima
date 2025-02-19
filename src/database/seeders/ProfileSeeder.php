<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'user_id' => 1, 
            'profile_image' => 'storage/ArmaniMensClock.jpg', 
            'postal_code' => '123-1234',
            'address' => 'toyama',
            'building_name' => 'ペイサージュ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
