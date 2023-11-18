<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=5; $i++){         
            $slider = Slider::factory()->create([
                'image' => 'slide-0'.$i.'.png',
                'status' => 1,
                'index' => $i
            ]);            
        }
    }
}
