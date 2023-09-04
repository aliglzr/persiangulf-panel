<?php

namespace Database\Seeders;

use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'پشتیبانی',
            'slug' => 'support',
            'is_visible' => 1
        ]);
        Category::create([
            'name' => 'امور مالی',
            'slug' => 'financial',
            'is_visible' => 1
        ]);
        Category::create([
            'name' => 'مدیریت',
            'slug' => 'management',
            'is_visible' => 1
        ]);
    }
}
