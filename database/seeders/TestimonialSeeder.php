<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1; $i<=25; $i++){
            $status = 0;
            if($i <= 3) {
                $status = 1;
            }
            $testimonial = Testimonial::factory()->create([
                'image' => 'author-0'.rand(1,6).'.png',
                'status' => $status
            ]);            
        }
    }
}
