<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Illuminate\Support\Facades\Http;

class ImportCars extends Command {
    protected $signature = 'import:cars {--local}';
    protected $description = 'Importa carros de JSON/API';

    public function handle()
    {
        if ($this->option('local')) {
            $path = storage_path('app/sample.json');
            if (!file_exists($path)) {
                $this->error("Arquivo sample.json não encontrado");
                return Command::FAILURE;
            }
            $json = file_get_contents($path);
            $data = json_decode($json, true);
        } else {
            // Busca da API ignorando problema de SSL
                $response = Http::withOptions(['verify' => false])
                                ->get('https://hub.alpes.one/api/v1/integrator/export/1902');

                if ($response->failed()) {
                    $this->error("Erro ao acessar API");
                    return Command::FAILURE;
                }
                $data = $response->json();
        }
        

        foreach ($data as $item) {
            
            Car::updateOrCreate(

                
                ['external_id' => $item['id']],
                [
                    'type' => $item['type'] ?? null,
                    'brand' => $item['brand'] ?? null,
                    'model' => $item['model'] ?? null,
                    'version' => $item['version'] ?? null,
                    'year_model' => $item['year']['model'] ?? null,
                    'year_build' => $item['year']['build'] ?? null,
                    'optionals' => json_encode($item['optionals'] ?? []),
                    'doors' => $item['doors'] ?? null,
                    'board' => $item['board'] ?? null,
                    'chassi' => $item['chassi'] ?? null,
                    'transmission' => $item['transmission'] ?? null,
                    'km' => $item['km'] ?? null,
                    'description' => $item['description'] ?? null,
                    'created_api' => $item['created'] ?? null,
                    'updated_api' => $item['updated'] ?? null,
                    'sold' => isset($item['sold']) ? (bool)$item['sold'] : false,
                    'category' => $item['category'] ?? null,
                    'url_car' => $item['url_car'] ?? null,
                    'old_price' => $item['old_price'] ?? null,
                    'price' => $item['price'] ?? null,
                    'color' => $item['color'] ?? null,
                    'fuel' => $item['fuel'] ?? null,
                    'fotos' => json_encode($item['fotos'] ?? []),
                ]
            );
        }

        $this->info("Importação concluída com sucesso!");
        return Command::SUCCESS;
    }




}