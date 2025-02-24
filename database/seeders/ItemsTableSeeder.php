<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item; // Make sure to import the Item model

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insert sample data into the items table
        Item::create([
            'name' => 'Sample Item 1',
            'category' => 'Office Supplies',
            'quantity' => 50,
            'unit' => 'pcs',
            'description' => 'A commonly used office supply for everyday tasks.',
            'storage_location' => 'Shelf A',
            'arrival_date' => now(),
            'date_purchased' => now(),
            'status' => 'In Stock',
            'image_url' => 'sample_item_1.jpg',
        ]);

        Item::create([
            'name' => 'Sample Item 2',
            'category' => 'Stationery',
            'quantity' => 200,
            'unit' => 'pcs',
            'description' => 'A stock of pens for office use.',
            'storage_location' => 'Drawer B',
            'arrival_date' => now()->subDays(30), // 30 days ago
            'date_purchased' => now()->subDays(30),
            'status' => 'In Stock',
            'image_url' => 'sample_item_2.jpg',
        ]);

        Item::create([
            'name' => 'Sample Item 3',
            'category' => 'Furniture',
            'quantity' => 10,
            'unit' => 'pcs',
            'description' => 'Chairs for the conference room.',
            'storage_location' => 'Conference Room',
            'arrival_date' => now()->subMonths(2), // 2 months ago
            'date_purchased' => now()->subMonths(2),
            'status' => 'In Stock',
            'image_url' => 'sample_item_3.jpg',
        ]);
    }
}

