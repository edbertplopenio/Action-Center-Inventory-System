<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'location_id' => Location::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
        ];
    }
}