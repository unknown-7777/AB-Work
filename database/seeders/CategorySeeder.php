<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Development',    'icon' => 'bi-code-slash'],
            ['name' => 'Mobile Apps',        'icon' => 'bi-phone'],
            ['name' => 'Design & Creative',  'icon' => 'bi-palette'],
            ['name' => 'Writing',            'icon' => 'bi-pen'],
            ['name' => 'Marketing',          'icon' => 'bi-megaphone'],
            ['name' => 'Video & Audio',      'icon' => 'bi-camera-video'],
            ['name' => 'Translation',        'icon' => 'bi-translate'],
            ['name' => 'Finance',            'icon' => 'bi-graph-up-arrow'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'icon'       => $cat['icon'],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}