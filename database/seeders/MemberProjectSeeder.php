<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Support\Str;

class MemberProjectSeeder extends Seeder
{
    public function run(): void
    {
        $csv = fopen(storage_path('../app/data/membros.csv'), 'r');
        if (!$csv) {
            throw new \Exception('Erro ao abrir o arquivo CSV.');
        }

        $headers = fgetcsv($csv);
        $rows = [];

        while (($row = fgetcsv($csv)) !== false) {
            $rows[] = $row;
        }
        fclose($csv);

        usort($rows, function ($a, $b) {
            return strcmp($a[0], $b[0]);
        });

        $defaultProjectImageUrl = 'http://localhost:8000/storage/projects/Wallpaper_B.png';

        foreach ($rows as $row) {
            if (count($row) < 10) continue;

            $slugName = Str::slug($row[0], '_');
            $fotoUrl = "http://localhost:8000/storage/members/{$slugName}.jpg";

            $titulo = trim($row[10] ?? '');
            $project = null;

            // 1. PRIMEIRO: Lidamos com o Projeto
            if (!empty($titulo)) {
                $artigosBrutos = explode("\n", str_replace("\r", "", $row[14] ?? ''));
                $artigos = array_map(function ($line) {
                    $parts = explode(' - ', $line, 2);
                    return [
                        'title' => $parts[0] ?? '',
                        'url'   => $parts[1] ?? '',
                    ];
                }, array_filter($artigosBrutos));

                $imagePath = storage_path("app/public/projects/{$slugName}.png");
                $imageUrl = file_exists($imagePath)
                    ? "http://localhost:8000/storage/projects/{$slugName}.png"
                    : $defaultProjectImageUrl;

                // Usamos firstOrCreate para não criar projetos duplicados
                // caso vários membros no CSV pertençam ao mesmo projeto
                $project = Project::firstOrCreate(
                    ['title' => $titulo], // Busca por esse título
                    [ // Se não achar, cria com esses dados adicionais
                        'resumo'    => $row[11] ?? '',
                        'image_url' => $imageUrl,
                        'video'     => $row[13] ?? null,
                        'artigo'    => $artigos,
                    ]
                );
            }

            // 2. SEGUNDO: Preparamos os dados do Membro
            $memberData = [
                'name'     => $row[0],
                'foto'     => $fotoUrl,
                'cell'     => $row[2],
                'email'    => $row[3],
                'category' => $row[4],
                'pesquisa' => $row[5],
                'lattes'   => $row[6],
                'linkedin' => $row[7],
                'orcid'    => $row[8],
                'link'     => $row[9],
            ];

            // 3. TERCEIRO: Criamos o Membro
            if ($project) {
                // Se existe um projeto, criamos o membro a partir da relação do projeto
                // Isso vai preencher automaticamente o 'project_id' na tabela members
                $project->member()->create($memberData);
            } else {
                // Se esse membro não tem projeto no CSV, criamos ele "solto"
                Member::create($memberData);
            }
        }
    }
}
