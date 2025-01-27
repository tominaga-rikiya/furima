<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('categories')->insert([
            [
                'category' => '時計',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => '家電',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'キッチン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => '衣類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => '食品',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
