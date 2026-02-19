<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publication;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publication = Publication::create([
            'image_url' => "http://localhost:8000/storage/projects/Wallpaper_B.png",
        ]);
        $publication = Publication::create([
            'image_url' => "http://localhost:8000/storage/projects/Wallpaper_C.png",
        ]);
        $publication = Publication::create([
            'image_url' => "http://localhost:8000/storage/projects/Wallpaper_C.png",
        ]);
        
    }
}
