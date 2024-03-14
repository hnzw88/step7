<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    public function run(): void
    {
        Sale::factory()->count(5)->create();
    }
}