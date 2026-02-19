<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DownloadFotosCommand extends Command
{
    protected $signature = 'fotos:baixar';
    protected $description = 'Baixa fotos dos membros em ordem alfabética a partir de uma planilha CSV';

    public function handle()
    {
        $csvPath = storage_path('../app/data/membros2.csv');
        $outputDir = storage_path('../storage/app/public/projects/');

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
            if (count($row) >= 3) {
                $rows[] = $row;
            }
        }
        fclose($csv);

        // Ordena por nome (coluna 1)
        usort($rows, function ($a, $b) {
            return strcmp($a[1], $b[1]);
        });

        foreach ($rows as $row) {
            $name = $row[1]; // nome da pessoa
            $url  = $row[2]; // url da imagem

            // Gera nome de arquivo limpo
            $filename = Str::slug($name, '_') . '.jpg';
            $dest = $outputDir . $filename;

            // Trata link do Google Drive
            if (strpos($url, 'drive.google.com') !== false) {
                parse_str(parse_url($url, PHP_URL_QUERY), $query);
                if (isset($query['id'])) {
                    $url = "https://drive.google.com/uc?export=view&id=" . $query['id'];
                }
            }

            try {
                $this->info("Baixando imagem de: $name");
                $imageData = file_get_contents($url);
                file_put_contents($dest, $imageData);
                $this->info("Salvo como: $filename");
            } catch (\Exception $e) {
                $this->error("Erro ao baixar imagem de {$name}: {$e->getMessage()}");
            }
        }

        $this->info("✅ Processo finalizado. Fotos salvas em: $outputDir");
    }
}
