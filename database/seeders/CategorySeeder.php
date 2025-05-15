<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Category A']);
        Category::create(['name' => 'Category B']);
        Category::create(['name' => 'Category C']);
    }
}
