<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::insert([
            [
                'title' => 'Avanços em Realidade Virtual na Saúde',
                'slug' => Str::slug('Avanços em Realidade Virtual na Saúde'),
                'image' => 'http://localhost:8000/storage/projects/Wallpaper_B.png',
                'category' => 'Tecnologia',
                'author' => 'Gabriel Henrick',
                'excerpt' => 'Descubra como a realidade virtual está revolucionando os tratamentos médicos.',
                'content' => "A realidade virtual tem se mostrado uma ferramenta promissora na área da saúde.\n\nCom simulações precisas, os profissionais conseguem treinar e desenvolver novas técnicas sem riscos aos pacientes.",
                'date' => '2025-06-25',
                'link' => 'https://github.com/douglasresendemaciel/cursos-grva-lia2-ia/pulse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'IA na Educação: Transformando o Aprendizado',
                'slug' => Str::slug('IA na Educação: Transformando o Aprendizado'),
                'image' => 'http://localhost:8000/storage/projects/Wallpaper_C.png',
                'category' => 'Educação',
                'author' => 'Carla Silva',
                'excerpt' => 'Como a inteligência artificial está sendo utilizada em salas de aula.',
                'content' => "Plataformas com IA estão personalizando o ensino e melhorando o desempenho dos alunos.\n\nO futuro da educação passa pela adaptação ao perfil de aprendizado de cada estudante.",
                'date' => '2025-06-28',
                'link' => 'https://github.com/douglasresendemaciel/cursos-grva-lia2-ia/pulse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
