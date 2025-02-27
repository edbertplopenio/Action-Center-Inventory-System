<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Location;
use App\Models\Equipment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed categories
        Category::factory(10)->create();

        // Seed locations
        Location::factory(5)->create();

        // Seed equipment
        Equipment::factory(50)->create();
    }
}