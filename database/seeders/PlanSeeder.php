<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic
        $basic = Plan::factory()->create([
            'name' => 'Basic',
            'popular' => false,
            'index' => 1,
            'status' => true,
        ]);
        // Standard
        $standard = Plan::factory()->create([
            'name' => 'Standard',
            'popular' => true,
            'index' => 2,
            'status' => true
        ]);
        // Premium
        $premium = Plan::factory()->create([
            'name' => 'Premium',
            'popular' => false,
            'index' => 3,
            'status' => true
        ]);                
    }
}
