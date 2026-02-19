<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event1 = Event::create([
            'image_url' => "http://localhost:8000/storage/projects/Wallpaper_C.png",
            'order' => "1", 
        ]);

        $event2 = Event::create([
        'image_url' => "http://localhost:8000/storage/projects/Wallpaper_B.png",
        'order' => "2",
        ]);
    }
}
