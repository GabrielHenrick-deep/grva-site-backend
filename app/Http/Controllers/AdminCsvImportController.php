<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Support\Str;

class AdminCsvImportController extends Controller
{
    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
        }

        $file = $request->file('file');
        $csv = fopen($file->getPathname(), 'r');

        $headers = fgetcsv($csv); // pula a primeira linha
        $rows = [];

        while (($row = fgetcsv($csv)) !== false) {
            $rows[] = $row;
        }

        fclose($csv);

        // usort($rows, function ($a, $b) {
        //     return strcmp($a[0], $b[0]);
        // });

        foreach ($rows as $row) {
            $slug = Str::slug($row[0], '_');
            $fotoUrl = "http://localhost:8000/storage/members/{$slug}.jpg";
            $fotoUrl2 = "http://localhost:8000/storage/projects/{$slug}.png";

            // 🔍 Atualiza ou cria membro com base no 'name'
            $member = Member::updateOrCreate(
                ['name' => $row[0]],
                [
                    'foto'     => $fotoUrl,
                    'cell'     => $row[2],
                    'email'    => $row[3],
                    'category' => $row[4],
                    'pesquisa' => $row[5],
                    'lattes'   => $row[6],
                    'linkedin' => $row[7],
                    'orcid'    => $row[8],
                    'link'     => $row[9],
                ]
            );

            $titulo = trim($row[10] ?? '');

            if (!empty($titulo)) {
                $artigosBrutos = explode("\n", str_replace("\r", "", $row[14] ?? ''));
                $artigos = array_map(function ($line) {
                    $parts = explode(' - ', $line, 2);
                    return [
                        'title' => $parts[0] ?? '',
                        'url'   => $parts[1] ?? '',
                    ];
                }, array_filter($artigosBrutos));

                $imagePath = storage_path("app/public/projects/{$slug}.png");
                $imageUrl = file_exists($imagePath) ? $fotoUrl2 : '';// ou qualquer imagem padrão


                // 🔍 Atualiza ou cria projeto com base no título
                $project = Project::updateOrCreate(
                    ['title' => $titulo],
                    [
                        'resumo'     => $row[11] ?? '',
                        'image_url'  => $imageUrl,
                        'video'      => $row[13] ?? null,
                        'artigo'     => $artigos,
                    ]
                );

                // ✅ Garante o relacionamento (sem duplicar)
                $member->projects()->syncWithoutDetaching([$project->id]);
            }
        }

        return response()->json(['success' => true]);
    }

}
