<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            GoalSeeder::class,
            FoodCategorySeeder::class,
            FoodSeeder::class,
            ExerciseCategorySeeder::class,
            ExerciseSeeder::class,
            WorkoutPlanSeeder::class,
            UserSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}