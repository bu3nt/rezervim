<?php

namespace Database\Seeders;

use App\Models\Navigation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Home
        $home = Navigation::factory()->create([
            'title' => 'Home',
            'url' => '#home',
            'index' => 1,
            'status' => true,
        ]);

        // About Us
        $aboutUs = Navigation::factory()->create([
            'title' => 'About',
            'url' => '#about',
            'index' => 2,
            'status' => true,
        ]);

        // Pricing
        $pricing = Navigation::factory()->create([
            'title' => 'Pricing',
            'url' => '#pricing',
            'index' => 3,
            'status' => true,
        ]);

        // Team
        $team = Navigation::factory()->create([
            'title' => 'Team',
            'url' => '#team',
            'index' => 4,
            'status' => true,
        ]);
        
        // Contact
        $contact = Navigation::factory()->create([
            'title' => 'Contact',
            'url' => '#contact',
            'index' => 5,
            'status' => true,
        ]);         
    }
}
