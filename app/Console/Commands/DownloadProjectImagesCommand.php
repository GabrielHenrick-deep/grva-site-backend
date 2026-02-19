<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DownloadProjectImagesCommand extends Command
{
    protected $signature = 'fotos:projetos';
    protected $description = 'Baixa imagens dos projetos a partir da planilha CSV';

    public function handle()
    {
        $csvPath = storage_path('../app/data/membros.csv');
        $outputDir = storage_path('app/public/projects');

        if (!file_exists($csvPath)) {
            $this->error("Arquivo CSV não encontrado em: $csvPath");
            return;
        }

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        $csv = fopen($csvPath, 'r');
        $headers = fgetcsv($csv); // pula o cabeçalho
        $rows = [];

        while (($row = fgetcsv($csv)) !== false) {
            if (count($row) >= 13 && !empty($row[13]) && !empty($row[12])) {
                $rows[] = $row;
            }
        }
        fclose($csv);

        // Ordena por título do projeto (coluna 10)
        usort($rows, function ($a, $b) {
            return strcmp($a[10], $b[10]);
        });

        foreach ($rows as $row) {
            $projectTitle = $row[10];
            $imageUrl = $row[12];

            // Nome limpo para o arquivo da imagem
            $filename = Str::slug($projectTitle, '_') . '.jpg';
            $dest = $outputDir . $filename;

            try {
                $this->info("Baixando imagem do projeto: $projectTitle");
                $imageData = file_get_contents($imageUrl);
                file_put_contents($dest, $imageData);
                $this->info("Salvo como: $filename");
            } catch (\Exception $e) {
                $this->error("Erro ao baixar imagem do projeto {$projectTitle}: {$e->getMessage()}");
            }
        }

        $this->info("✅ Processo finalizado. Imagens salvas em: $outputDir");
    }
}
